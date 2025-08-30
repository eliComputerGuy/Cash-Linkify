<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\MembershipPayment;
use Illuminate\Support\Facades\DB;
use App\Services\ReferralCommissionService;

class ReferralController extends Controller
{
    //
    public function referrals()
    {
        $breadcrumbs = [
            'Referrals' => '' // current page, no link
        ];
        $title = 'Referrals';
        $authUserId = auth()->id();

        // Total registrations (direct referrals)
        $totalRegistrations = User::where('referred_by', $authUserId)->count();

        // Pending purchases (among direct referrals)
        $pendingPurchases = MembershipPayment::whereIn('user_id', function ($q) use ($authUserId) {
            $q->select('id')
            ->from('users')
            ->where('referred_by', $authUserId);
        })->where('status', 'pending')->count();

        // Completed purchases (among direct referrals)
        $completedPurchases = MembershipPayment::whereIn('user_id', function ($q) use ($authUserId) {
            $q->select('id')
            ->from('users')
            ->where('referred_by', $authUserId);
        })->where('status', 'verified')->count();
        $totalEarnings = Commission::where('beneficiary_user_id', auth()->id())->where('type', 'referral')->sum('amount');

        return view('member.referral', [
            'totalRegistrations' => $totalRegistrations,
            'pendingPurchases' => $pendingPurchases,
            'completedPurchases' => $completedPurchases,
            'totalEarnings' => $totalEarnings,
            'breadcrumbs' => $breadcrumbs,
            'title' => $title,
        ]);
    }


    

    public function approve(Request $request, int $paymentId, ReferralCommissionService $refService)
    {
        return DB::transaction(function () use ($paymentId, $refService) {
            /** @var MembershipPayment $payment */
            $payment = MembershipPayment::lockForUpdate()->findOrFail($paymentId);
            if ($payment->status !== 'pending') {
                return back()->with('warning', 'Payment is not pending.');
            }

            // Load subscriber
            /** @var User $subscriber */
            $subscriber = User::lockForUpdate()->findOrFail($payment->user_id);

            // (Optional) upgrade subscriber’s level if that’s your business rule
            if (property_exists($payment, 'level_id') && $payment->level_id) {
                // $subscriber->level_id = $payment->level_id;
                $subscriber->status = 'verified';
                $subscriber->save();
            }


            // Approve payment
            $payment->status = 'verified';
            // $payment->approved_at = now();
            $payment->save();



            // Trigger referral commissions (idempotent per purchase)
            $refService->createReferralCommissions(
                subscriber: $subscriber,
                planAmount: (float) $payment->amount,
                purchaseId: $payment->id,
                levelId:    $payment->level_id ?? null
            );

            // return back()->with('success', 'Payment approved and referral commissions paid.');
            return 'success';
        });
    }


        
}
