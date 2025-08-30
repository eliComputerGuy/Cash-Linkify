<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Helpers\CodeGenerator;
use App\Models\User;

class EnsureUserCompletedRegistration
{
    public function handle(Request $request, Closure $next)
    {
        $loggedInUser = Auth::user();

        if (!$loggedInUser) {
            return redirect()->route('login');
        }

        // Redirect to email verification if needed
        if ($loggedInUser->is_email_verified == false) {
            // return redirect()->route('verification.notice');
            $verificationCode = CodeGenerator::generateVerificationCode();
            $user = User::where('email', $loggedInUser->email)->first();
            $user->email_verification_code = $verificationCode;
            $user->save();
            // Send the code to the user's email
            Mail::send('emails.verification-code', ['user' => $user, 'code' => $verificationCode], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Email Verification Code');
            });
            return redirect()->route('verification.code', ['email' => $user->email]);
        }

        // Redirect to KYC if registration is at 'basic'
        if ($loggedInUser->registration_stage === 'basic') {
            return redirect()->route('kyc.form');
        }

        // Redirect to membership selection if KYC is done but no package
        if ($loggedInUser->registration_stage === 'kyc') {
            return redirect()->route('membership.package');
        }

        // If all good, proceed
        return $next($request);
    }
}
