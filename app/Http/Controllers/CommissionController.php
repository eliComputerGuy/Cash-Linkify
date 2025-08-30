<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Level;
use App\Models\Commission;
use App\Models\Referral;
use Illuminate\Support\Facades\DB;

class CommissionController extends Controller
{
    //
    public function distributeReferralCommission(User $subscriber, Level $level)
    {
        // Commission rates for levels 1, 2, 3
        $rates = [
            1 => 0.15, // 15%
            2 => 0.05, // 5%
            3 => 0.02, // 2%
        ];

        // Find uplines
        $upline = $subscriber;
        for ($i = 1; $i <= 3; $i++) {
            $referral = Referral::where('user_id', $upline->id)->first();

            if (!$referral || !$referral->referrer_id) {
                break; // No more uplines
            }

            $uplineUser = User::find($referral->referrer_id);
            if (!$uplineUser) {
                break;
            }

            // Calculate commission amount
            $commissionAmount = $level->entry_fee * $rates[$i];

            DB::transaction(function () use ($uplineUser, $subscriber, $level, $commissionAmount, $i) {
                // Insert into commissions table
                Commission::create([
                    'user_id' => $uplineUser->id,
                    'from_user_id' => $subscriber->id,
                    'level_id' => $level->id,
                    'amount' => $commissionAmount,
                    'referral_level' => $i,
                    'description' => "{$commissionAmount} earned from level {$i} referral (User ID {$subscriber->id})",
                ]);

                // Update wallet balance
                $wallet = User::firstOrCreate(['id' => $uplineUser->id]);
                $wallet->balance += $commissionAmount;
                $wallet->save();
            });

            // Move up the chain
            $upline = $uplineUser;
        }
    }



    public function confirmMembershipPayment(Request $request, $paymentId)
    {
        // $payment = Payment::findOrFail($paymentId);
        // $payment->status = 'approved';
        // $payment->save();

        // $user = $payment->user;
        // $level = $payment->level;

        // // Distribute commissions
        // $this->distributeReferralCommission($user, $level);

        // return redirect()->route('dashboard')->with('success', 'Payment approved and commissions distributed.');
    }
}
