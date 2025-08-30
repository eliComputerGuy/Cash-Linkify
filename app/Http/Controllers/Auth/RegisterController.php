<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Helpers\CodeGenerator;
use App\Models\Referral;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'country_code' => ['required', 'string'],
            'phone_number' => ['required', 'string'],
            'password' => [
            'required',
            'string',
            'min:8',
            'confirmed',
            'regex:/^(?=.*[A-Z])(?=.*[a-zA-Z])(?=.*\d).+$/'
            ],
        ], [
            'password.regex' => 'Password must contain at least 1 uppercase letter, 1 number, and be at least 8 characters.',
        
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Find the user with the provided referral code
        $referredUser = null;
        if (!empty($data['referral_code'])) {
            $referredUser = User::where('referral_code', $data['referral_code'])->first();
        }

        $verificationCode = CodeGenerator::generateVerificationCode();
        // dd($data);
        $phone = '+' . $data['country_code'] . $data['phone_number'];
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $phone,
            // 'referral_code' => uniqid('LFT'),
            'referral_code' => 'LFT' . Str::upper(Str::random(7)),
            'referred_by' => $referredUser ? $referredUser->id : null,
            'registration_stage' => 'basic',
            'password' => Hash::make($data['password']),
            'email_verification_code' => $verificationCode,
        ]);

        // if ($referredUser) {
        //     Referral::create([
        //         'user_id' => $user->id,
        //         'referred_user_id' => $referredUser->id,
        //         'depth_level'
        //     ]);
        // }

        // Send the code to the user's email
        Mail::send('emails.verification-code', ['user' => $user, 'code' => $verificationCode], function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('Email Verification Code');
        });

        return $user;
    }


    // function generateVerificationCode($length = 6) {
    //     $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    //     $charactersLength = strlen($characters);
    //     $randomCode = '';
    //     for ($i = 0; $i < $length; $i++) {
    //         $randomCode .= $characters[random_int(0, $charactersLength - 1)];
    //     }
    //     return $randomCode;
    // }
}
