<?php

namespace App\Http\Controllers;

use App\Models\UserVideoTask;
use Illuminate\Http\Request;
use App\Models\TaskLog;
use Carbon\Carbon;
use App\Models\Commission;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Level;

class VideoController extends Controller
{
    // public function completeVideoTask(Request $request)
    // {
    //     $request->validate([
    //         'video_id' => 'required|exists:videos,id',
    //     ]);

    //     $userId = auth()->id();
    //     $videoId = $request->video_id;

    //     // Check if already earned today for this video
    //     $alreadyEarned = TaskLog::where('user_id', $userId)
    //         ->where('video_id', $videoId)
    //         ->whereDate('created_at', Carbon::today())
    //         ->exists();

    //     if ($alreadyEarned) {
    //         return response()->json(['status' => 'already_earned']);
    //     }

    //     // Create task log
    //     TaskLog::create([
    //         'user_id' => $userId,
    //         'video_id' => $videoId,
    //         'earned' => true
    //     ]);

    //     // Get reward from user's level
    //     $rewardPerVideo = $user->level->reward_per_video ?? 0;


    //     // Log earning in commissions table
    //     UserVideoTask::create([
    //         'user_id' => $userId,
    //         'video_id' => $videoId,
    //         'date_assigned' => Carbon::now(),
    //         'earnings' => $rewardPerVideo,
    //         'status' => 'completed',
    //         // 'description' => 'Earning for completing video task'
    //     ]);

    //     // Update user's balance
    //     $user = auth()->user();
    //     $user->wallet_balance += $rewardPerVideo;
    //     $user->total_earnings += $rewardPerVideo;
    //     $user->save();

    //     return response()->json(['status' => 'success']);
    // }


    // % by depth from the earner (1 = direct sponsor)
    private const REFERRAL_RATES = [
        1 => 0.15, // 15%
        2 => 0.10, // 10%
        3 => 0.05, // 5%
    ];

    public function completeVideoTask(Request $request)
    {
        $request->validate([
            'video_id' => 'required|exists:videos,id',
        ]);

        $user = auth()->user();
        $userId = $user->id;
        $videoId = (int) $request->video_id;

        // reward amount for the earner (from their level)
        $rewardPerVideo = (float) optional($user->level)->reward_per_video;

        return DB::transaction(function () use ($user, $userId, $videoId, $rewardPerVideo) {

            // prevent duplicate earning for this video today
            $alreadyEarned = TaskLog::where('user_id', $userId)
                ->where('video_id', $videoId)
                ->whereDate('created_at', Carbon::today())
                ->exists();

            if ($alreadyEarned) {
                return response()->json(['status' => 'already_earned']);
            }

            // 1) Log the task completion (this is the unique “anchor” for commission rows)
            $taskLog = TaskLog::create([
                'user_id'  => $userId,
                'video_id' => $videoId,
                'earned'   => true,
            ]);

            // 2) Credit the earner
            UserVideoTask::create([
                'user_id'      => $userId,
                'video_id'     => $videoId,
                'date_assigned'=> Carbon::now(),
                'earnings'     => $rewardPerVideo,
                'status'       => 'completed',
            ]);

            $user->increment('wallet_balance', $rewardPerVideo);
            $user->increment('total_earnings', $rewardPerVideo);

            // 3) Pay uplines from the earner’s reward (direct=15%, second=5%, third=2%)
            $this->payVideoReferralBonuses($earner = $user, $baseAmount = $rewardPerVideo, $taskLog);

            return response()->json(['status' => 'success']);
        });
    }

    /**
     * Pays referral commissions for video completion.
     * Depths: 1 => 15%, 2 => 5%, 3 => 2% (config above).
     */
    private function payVideoReferralBonuses(User $earner, float $baseAmount, TaskLog $taskLog): void
    {
        if ($baseAmount <= 0) return;

        // climb up to 3 uplines via user->referrer relation
        $uplines = $this->getUplines($earner, 3); // [1 => userA, 2 => userB, 3 => userC] in depth order

        foreach (self::REFERRAL_RATES as $depth => $rate) {
            if (!isset($uplines[$depth])) continue;

            $beneficiary = $uplines[$depth];
            if (!$beneficiary) continue;

            $amount = round($baseAmount * $rate, 2);
            if ($amount <= 0) continue;

            // Idempotency: avoid double-paying if the same taskLog already generated this commission
            $already = Commission::where('task_log_id', $taskLog->id)
                ->where('beneficiary_user_id', $beneficiary->id)
                ->where('level', $depth)
                ->exists();

            if ($already) continue;

            // Create commission row
            Commission::create([
                'beneficiary_user_id' => $beneficiary->id,
                'source_user_id'      => $earner->id,
                'task_log_id'         => $taskLog->id,
                'video_id'            => $taskLog->video_id,
                'amount'              => $amount,
                'level'               => $depth,
                'type'                => 'video_task',
                'meta'                => ['rates' => self::REFERRAL_RATES],
            ]);

            // Credit beneficiary wallet
            $beneficiary->increment('wallet_balance', $amount);
            $beneficiary->increment('total_earnings', $amount);
        }
    }

    /**
     * Returns an array keyed by depth => User (1..$levels)
     * Requires a relation like: User::belongsTo(User::class, 'referrer_id')
     */
    // private function getUplines(User $user, int $levels): array
    // {
    //     $out = [];
    //     $current = $user;

    //     for ($d = 1; $d <= $levels; $d++) {
    //         $current = $current->referrer ?? null;
    //         if (!$current) break;
    //         $out[$d] = $current;
    //     }
    //     return $out;
    // }


    private function getUplines(User $user, int $levels): array
    {
        $out = [];
        $seen = [$user->id => true];
        $currentId = $user->referred_by;

        for ($d = 1; $d <= $levels; $d++) {
            if (!$currentId) break;

            $ref = \App\Models\User::select('id','name','referred_by','wallet_balance','total_earnings')
                ->find($currentId);

            if (!$ref || isset($seen[$ref->id])) break; // stop on missing or cycle

            $out[$d] = $ref;          // User model
            $seen[$ref->id] = true;
            $currentId = $ref->referred_by;
        }
        return $out;
    }
}
