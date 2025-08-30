<?php

namespace App\Http\Controllers;

use App\Models\InvestmentProduct;
use App\Models\UserInvestment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class InvestmentController extends Controller
{
    /**
     * Show investment dashboard
     */
    public function index()
    {
        $breadcrumbs = [    
            'Investment' => '' // current page, no link
        ];
        $title = 'Investment';

        $user = Auth::user();
        $activeInvestment = UserInvestment::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('payment_status', 'verified')
            ->with('product')
            ->first();

        if ($activeInvestment) {
            // User has active investment - show investment analysis
            return view('member.investment.dashboard', compact('activeInvestment', 'breadcrumbs', 'title'));
        } else {
            // User has no active investment - show available packages
            $packages = InvestmentProduct::active()->get();
            return view('member.investment.packages', compact('packages', 'breadcrumbs', 'title'));
        }
    }

    /**
     * Show available investment packages
     */
    public function packages()
    {
        $breadcrumbs = [    
            'Investment' => '' // current page, no link
        ];
        $title = 'Investment';

        $packages = InvestmentProduct::active()->get();
        return view('member.investment.packages', compact('packages', 'breadcrumbs', 'title'));
    }

    /**
     * Show package details and investment form
     */
    public function showPackage($id)
    {
        $breadcrumbs = [    
            'Investment' => route('investment.index'),
            'Package Details' => '',
            
        ];
        $title = 'Package Details';

        $package = InvestmentProduct::active()->findOrFail($id);
        return view('member.investment.package-details', compact('package', 'breadcrumbs', 'title'));
    }

    /**
     * Process investment selection
     */
    public function selectPackage(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);

        $package = InvestmentProduct::active()->findOrFail($id);
        
        // Validate amount is within package range
        if ($request->amount < $package->min_amount || $request->amount > $package->max_amount) {
            return back()->withErrors(['amount' => 'Investment amount must be between $' . $package->min_amount . ' and $' . $package->max_amount]);
        }

        // Validate duration
        if ($request->duration < $package->duration_days) {
            return back()->withErrors(['duration' => 'Duration must be at least ' . $package->duration_days . ' days']);
        }

        // Calculate dates
        $startDate = Carbon::now();
        $endDate = $startDate->copy()->addDays((int) $request->duration);
        $dailyProfit = $package->calculateDailyProfit((float) $request->amount);

        // Create investment record
        $investment = UserInvestment::create([
            'user_id' => Auth::id(),
            'product_id' => $package->id,
            'amount' => (float) $request->amount,
            'daily_profit' => (float) $dailyProfit,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'payment_status' => 'pending',
            'status' => 'active',
        ]);

        return redirect()->route('investment.payment', $investment->id);
    }

    /**
     * Show payment page
     */
    public function payment($id)
    {
        $breadcrumbs = [    
            'Investment' => route('investment.index'),
            'Payment' => '',
            
        ];
        $title = 'Payment';

        $investment = UserInvestment::where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->with('product')
            ->findOrFail($id);

        return view('member.investment.payment', compact('investment', 'breadcrumbs', 'title'));
    }

    /**
     * Process payment proof upload
     */
    public function submitPayment(Request $request, $id)
    {
        $request->validate([
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $investment = UserInvestment::where('user_id', Auth::id())
            ->where('payment_status', 'pending')
            ->findOrFail($id);

        // Upload payment proof
        $path = $request->file('payment_proof')->store('payment_proofs', 'public');

        $investment->update([
            'payment_proof' => $path,
        ]);

        return redirect()->route('investment.index')
            ->with('success', 'Payment proof submitted successfully! Please wait for admin verification.');
    }

    /**
     * Show investment dashboard (for active investments)
     */
    public function dashboard()
    {
        $user = Auth::user();
        $activeInvestment = UserInvestment::where('user_id', $user->id)
            ->where('status', 'active')
            ->where('payment_status', 'verified')
            ->with('product')
            ->first();

        if (!$activeInvestment) {
            return redirect()->route('investment.index');
        }

        return view('member.investment.dashboard', compact('activeInvestment'));
    }

    /**
     * Admin: Show pending payments
     */
    public function pendingPayments()
    {
        $pendingInvestments = UserInvestment::pending()
            ->with(['user', 'product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.investment.pending-payments', compact('pendingInvestments'));
    }

    /**
     * Admin: Verify payment
     */
    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'notes' => 'nullable|string',
        ]);

        $investment = UserInvestment::findOrFail($id);
        
        $investment->update([
            'payment_status' => $request->status,
            'admin_notes' => $request->notes,
            'verified_at' => $request->status === 'verified' ? Carbon::now() : null,
            'verified_by' => $request->status === 'verified' ? Auth::id() : null,
        ]);

        $message = $request->status === 'verified' 
            ? 'Payment verified successfully!' 
            : 'Payment rejected.';

        return back()->with('success', $message);
    }

    /**
     * Complete investment (when duration ends)
     */
    public function completeInvestment($id)
    {
        $investment = UserInvestment::where('user_id', Auth::id())
            ->where('status', 'active')
            ->findOrFail($id);

        if (!$investment->hasEnded()) {
            return back()->withErrors(['message' => 'Investment duration has not ended yet.']);
        }

        // Check if user has bank details
        $user = Auth::user();
        if (empty($user->bank_name) || empty($user->account_number) || empty($user->account_holder_name)) {
            return back()->withErrors(['message' => 'Please update your bank details in your profile before completing the investment.']);
        }

        // Calculate final profit
        $finalProfit = $investment->calculateCurrentProfit();
        
        // Update investment status
        $investment->update([
            'status' => 'completed',
            'total_profit' => $finalProfit,
        ]);

        // Create withdrawal request for the profit
        $withdrawal = \App\Models\Withdrawal::create([
            'user_id' => Auth::id(),
            'amount' => $finalProfit,
            'method' => 'bank_transfer',
            'status' => 'pending',
            'description' => 'Investment profit withdrawal - ' . $investment->product->name,
            'reference' => 'INV-' . $investment->id . '-' . time(),
        ]);

        return back()->with('success', 'Investment completed successfully! A withdrawal request for ₦' . number_format($finalProfit, 2) . ' has been created and is pending admin approval.');
    }
}
