<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function profileSettings()
    {
        $breadcrumbs = [
            'Profile Settings' => '' // current page, no link
        ];
        $title = 'Profile Settings';

        return view('member.profile', [
            'breadcrumbs' => $breadcrumbs,
            'title' => $title,
        ]);
    }

    public function changePassword()
    {
        $breadcrumbs = [    
            'Change Password' => '' // current page, no link
        ];
        $title = 'Change Password';

        return view('member.change-password', [
            'breadcrumbs' => $breadcrumbs,
            'title' => $title,
        ]);
    }

    public function paymentUpdate()
    {
        $breadcrumbs = [    
            'Payment Update' => '' // current page, no link
        ];
        $title = 'Payment Update';

        return view('member.payment-update', [
            'breadcrumbs' => $breadcrumbs,
            'title' => $title,
        ]);
    }

    public function updatePayment(Request $request)
    {
        $request->validate([
            'country' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
        ]);

        $user = \App\Models\User::find(Auth::id());
        
        $user->country = $request->country;
        $user->bank_name = $request->bank_name;
        $user->account_number = $request->account_number;
        $user->account_holder_name = $request->account_name;
        $user->save();

        return redirect()->back()->with('success', 'Payment information updated successfully!');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
        ]);

        $user = \App\Models\User::find(Auth::id());
        
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = \App\Models\User::find(Auth::id());
        $user->password = bcrypt($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
