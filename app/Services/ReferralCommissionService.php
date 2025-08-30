<?php

namespace App\Services;

use App\Models\User;
use App\Models\Commission;
use Illuminate\Support\Facades\DB;

class ReferralCommissionService
{
    // L1 15%, L2 5%, L3 2%
    private const REFERRAL_RATES = [1 => 0.15, 2 => 0.05, 3 => 0.02];

    /**
     * Pay uplines for a verified purchase.
     *
     * @param  User   $subscriber   The user who just had their purchase approved.
     * @param  float  $planAmount   The base amount to commission on.
     * @param  int    $purchaseId   The membership_payments.id (for idempotency/audit).
     * @param  int|null $levelId    The purchased level/package id (optional, stored in meta).
     */
    public function createReferralCommissions(User $subscriber, float $planAmount, int $purchaseId, ?int $levelId = null): void
    {
        if ($planAmount <= 0) return;

        // resolve uplines up to 3 levels as User models
        $uplines = $this->getUplines($subscriber, 3); // [1 => upline1, 2 => upline2, 3 => upline3]

        DB::transaction(function () use ($subscriber, $planAmount, $uplines, $purchaseId, $levelId) {
            foreach (self::REFERRAL_RATES as $depth => $rate) {
                $beneficiary = $uplines[$depth] ?? null;
                if (!$beneficiary) continue;

                $amount = round($planAmount * $rate, 2);
                if ($amount <= 0) continue;

                // --- Idempotency: don't pay twice for same purchase/upline/depth ---
                // Prefer JSON path if 'meta' is a JSON column:
                $already = Commission::where('type', 'referral')
                    ->where('beneficiary_user_id', $beneficiary->id)
                    ->where('source_user_id', $subscriber->id)
                    ->where('level', $depth)
                    ->where('meta->purchase_id', $purchaseId) // works if meta is JSON
                    ->exists();

                if ($already) continue;

                // If your 'meta' is TEXT (not JSON), fallback:
                // $already = Commission::where('type','referral')
                //     ->where('beneficiary_user_id', $beneficiary->id)
                //     ->where('source_user_id', $subscriber->id)
                //     ->where('level', $depth)
                //     ->where('meta', 'LIKE', '%"purchase_id":'.$purchaseId.'%')
                //     ->exists();

                Commission::create([
                    'beneficiary_user_id' => $beneficiary->id,
                    'source_user_id'      => $subscriber->id,
                    'task_log_id'         => null,
                    'video_id'            => null,
                    'amount'              => $amount,
                    'level'               => $depth,
                    'type'                => 'referral',
                    'meta'                => [
                        'purchase_id' => $purchaseId,
                        'level_id'    => $levelId,
                        'plan_amount' => $planAmount,
                        'rates'       => self::REFERRAL_RATES,
                    ],
                ]);

                // Credit wallet/totals
                $beneficiary->increment('wallet_balance', $amount);
                $beneficiary->increment('total_earnings', $amount);
            }
        });
    }

    /**
     * Return uplines up to N levels as an array keyed by depth (1..N).
     */
    private function getUplines(User $user, int $levels): array
    {
        $out = [];
        $seen = [$user->id => true];
        $currentId = $user->referred_by;

        // dd($currentId);

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
