<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PagesController extends Controller
{
    public function index()
    {
        // $referral_code = request()->get('ref');
        // if ($referral_code) {
        //     $referral = User::where('referral_code', $referral_code)->first();
        //     if ($referral) {

                
        //     }
        // }
        return view('welcome');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function packages()
    {
        return view('pages.packages');
    }

    public function faqs()
    {
        return view('pages.faqs');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}
