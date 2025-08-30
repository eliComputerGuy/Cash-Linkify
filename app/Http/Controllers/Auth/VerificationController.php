<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Helpers\CodeGenerator;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    // protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    public function otpForm(Request $request)
    {
        $email = $request->query('email', Auth::user() ? Auth::user()->email : null);
        return view('auth.verify-email', compact('email'));
    }


    public function resend($email)
    {
        // Logic to send a new verification code
        $this->sendVerificationCode($email); 

        return redirect()->back()->with('status', 'A new verification code has been sent to your email.');
    }

    protected function sendVerificationCode($email)
    {
        $user = User::where('email', $email)->first();

        $verificationCode = CodeGenerator::generateVerificationCode();

        if ($user) {
            $user->email_verification_code = $verificationCode;
            $user->save();

            Mail::send('emails.verification-code', ['user' => $user, 'code' => $verificationCode], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Email Verification Code');
            });
        }
    }

    public function verify(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && $user->email_verification_code == $request->code) {
            $user->is_email_verified = true;
            $user->email_verification_code = null;
            $user->email_verified_at = now(); // Set the email verified timestamp
            $user->save();

            Auth::login($user); // Log the user in if not already

            return redirect('/signup-success')->with('status', 'Email verified successfully!');
        }

        return back()->withErrors(['code' => 'Invalid verification code.']);
    }
}
