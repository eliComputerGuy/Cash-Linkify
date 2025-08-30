<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WithdrawalController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount'  => 'required|numeric|min:0.01',
            // 'contact' is optional now; we’ll build from the user profile
        ]);

        $user = $request->user();

        // Require bank details on file
        if (empty($user->account_holder_name) || empty($user->account_number) || empty($user->bank_name)) {
            return response()->json([
                'status'  => 'missing_bank',
                'message' => 'Please add your bank details before requesting a withdrawal.',
            ], 422);
        }

        // Amount checks (you already have balance checks; keep your >= rule if desired)
        $amount  = (float) $request->amount;
        $balance = (float) $user->wallet_balance;

        // ---- MINIMUM BY LEVEL ----
        $level = $user->loadMissing('level')->level;

        // Prefer a DB column, else fall back to hard map
        $fallbackMinMap = [
            1=>9500, 2=>19500, 3=>25000, 4=>37500, 5=>67500, 6=>150000,
            7=>225000, 8=>535000, 9=>975000, 10=>1500000, 11=>3750000, 12=>5250000,
        ];

        $levelId = (int) (\Illuminate\Support\Arr::get($user, 'level_id') ?? \Illuminate\Support\Arr::get($level, 'id', 0));
        $minRequired = (float) (\Illuminate\Support\Arr::get($level, 'min_withdrawal') ?? ($fallbackMinMap[$levelId] ?? 0));

        if ($minRequired > 0 && $amount < $minRequired) {
            return response()->json([
                'status'  => 'below_minimum',
                'message' => 'Minimum withdrawal for your level is ₦'.number_format($minRequired, 2),
                'min'     => $minRequired,
            ], 422);
        }
        
        // ---- AMOUNT CHECKS ----
        if ($amount >= $balance) {
            return response()->json([
                'status'  => 'insufficient',
                'message' => 'Low balance. Please enter a lower amount.',
            ], 422);
        }

        // Deduct immediately (reserve funds)
        $user->wallet_balance = round($balance - $amount, 2);
        $user->save();

        // Build contact/method from profile (don’t trust client)
        $methodDisplay = "{$user->account_holder_name} - {$user->account_number} - {$user->bank_name}";

        $w = \App\Models\Withdrawal::create([
            'user_id'   => $user->id,
            'amount'    => $amount,
            'status'    => 'pending',
            // 'method'    => $methodDisplay,            // or separate columns if you have them
            'requested_at'    => now(),
            // 'reference' => (string) \Illuminate\Support\Str::uuid(),
        ]);

        return response()->json([
            'status'        => 'ok',
            'id'            => $w->id,
            'new_balance'   => $user->wallet_balance,
            'min'           => $minRequired,
        ]);
    }
}
