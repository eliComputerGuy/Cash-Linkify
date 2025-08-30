<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InvestmentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [App\Http\Controllers\PagesController::class, 'index'])->name('index');
Route::get('/about', [App\Http\Controllers\PagesController::class, 'about'])->name('about');
Route::get('/packages', [App\Http\Controllers\PagesController::class, 'packages'])->name('packages');
Route::get('/faqs', [App\Http\Controllers\PagesController::class, 'faqs'])->name('faqs');
Route::get('/contact', [App\Http\Controllers\PagesController::class, 'contact'])->name('contact');

Auth::routes();

Route::get('/verify-email', [App\Http\Controllers\Auth\VerificationController::class, 'otpForm'])->name('verification.code');
Route::get('/verify-email/resend/{email}', [App\Http\Controllers\Auth\VerificationController::class, 'resend'])
    ->name('verification.resend');
Route::post('/verify-email', [App\Http\Controllers\Auth\VerificationController::class, 'verify']);

Route::get('/signup-success', [App\Http\Controllers\HomeController::class, 'signupSuccess'])->name('signup.success');
Route::get('/complete-kyc', [App\Http\Controllers\HomeController::class, 'kycForm'])->name('kyc.form');
Route::post('/submit-kyc', [App\Http\Controllers\HomeController::class, 'submitKYC'])->name('submit.kyc');
Route::get('/investement-packages', [App\Http\Controllers\HomeController::class, 'membershipPackage'])->name('membership.package');
Route::post('/package-payment', [App\Http\Controllers\HomeController::class, 'submitPackagePayment'])->name('membership.payment.submit');
Route::get('/review-dashboard', [App\Http\Controllers\HomeController::class, 'reviewDashboard'])->name('review.dashboard');

// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
Route::middleware(['auth', 'registration.complete', 'account.verified'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('/wallet', [App\Http\Controllers\HomeController::class, 'wallet'])->name('wallet');
    Route::get('/my-earnings', [App\Http\Controllers\HomeController::class, 'myEarnings'])->name('my.earnings');
    Route::post('/task/complete', [App\Http\Controllers\VideoController::class, 'completeVideoTask'])->name('task.complete');


    Route::get('/my-subscriptions', [App\Http\Controllers\HomeController::class, 'mySubscriptions'])->name('my.subscriptions');
    Route::get('/my-investments', [App\Http\Controllers\HomeController::class, 'myInvestments'])->name('my.investments');
    Route::get('/my-transactions', [App\Http\Controllers\HomeController::class, 'myTransactions'])->name('my.transactions');
    Route::get('/withdrawal', [App\Http\Controllers\HomeController::class, 'withdrawal'])->name('withdrawal');
    Route::post('/withdrawals', [App\Http\Controllers\WithdrawalController::class, 'store'])->name('withdrawals.store');

    Route::get('/settings', [App\Http\Controllers\ProfileController::class, 'profileSettings'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\ProfileController::class, 'update'])->name('settings.update');
    Route::get('/settings/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('password.change');
    Route::get('/settings/payment-update', [App\Http\Controllers\ProfileController::class, 'paymentUpdate'])->name('payment.update');
    Route::post('/settings/payment-update', [App\Http\Controllers\ProfileController::class, 'updatePayment'])->name('payment.update.submit');
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    Route::get('/referrals', [App\Http\Controllers\ReferralController::class, 'referrals'])->name('referrals');
    
    
    // Investment Routes
    Route::get('/investment', [InvestmentController::class, 'index'])->name('investment.index');
    Route::get('/investment/packages', [InvestmentController::class, 'packages'])->name('investment.packages');
    Route::get('/investment/package/{id}', [InvestmentController::class, 'showPackage'])->name('investment.package.show');
    Route::post('/investment/package/{id}/select', [InvestmentController::class, 'selectPackage'])->name('investment.package.select');
    Route::get('/investment/{id}/payment', [InvestmentController::class, 'payment'])->name('investment.payment');
    Route::post('/investment/{id}/payment', [InvestmentController::class, 'submitPayment'])->name('investment.payment.submit');
    Route::get('/investment/dashboard', [InvestmentController::class, 'dashboard'])->name('investment.dashboard');
    Route::post('/investment/{id}/complete', [InvestmentController::class, 'completeInvestment'])->name('investment.complete');
    
    // Admin Investment Routes
    Route::get('/admin/investment/pending-payments', [InvestmentController::class, 'pendingPayments'])->name('admin.investment.pending');
    Route::post('/admin/investment/{id}/verify', [InvestmentController::class, 'verifyPayment'])->name('admin.investment.verify');
});


Route::get('/test-approve/{paymentId}', function($paymentId) {
    $controller = app(\App\Http\Controllers\ReferralController::class);
    $request = request();
    $refService = app(\App\Services\ReferralCommissionService::class);
    return $controller->approve($request, $paymentId, $refService);
});

// Test route for assets
Route::get('/test-assets', function() {
    return response()->json([
        'css_url' => asset('assets/css/landing.css'),
        'js_url' => asset('assets/js/landing.js'),
        'app_url' => config('app.url'),
        'css_exists' => file_exists(public_path('assets/css/landing.css')),
        'js_exists' => file_exists(public_path('assets/js/landing.js')),
    ]);
});