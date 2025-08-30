<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\MembershipPayment;
use App\Models\UserVideoTask;
use Carbon\Carbon;
use App\Models\Video;
use App\Models\Withdrawal;
use App\Models\Commission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        // if ($user->registration_stage === 'basic' && $user->status === 'pending') {
        //     return redirect()->route('kyc.form'); // route to KYC form
        // }

        // if ($user->registration_stage === 'kyc' && $user->status === 'pending') {
        //     return redirect()->route('membership.package'); // route to membership selection/payment
        // }

        // if ($user->registration_stage === 'complete' && $user->status === 'review') {
        //     return redirect()->route('review.dashboard'); // route to dashboard
        // }

        $uid  = $user->id;

        // Ranges
        $todayStart  = now()->startOfDay();
        $todayEnd    = now()->endOfDay();
        $weekStart   = now()->startOfWeek();
        $weekEnd     = now()->endOfWeek();
        $monthStart  = now()->startOfMonth();
        $monthEnd    = now()->endOfMonth();

        // Helper closures
        $sumTasks = fn($from = null, $to = null) =>
            UserVideoTask::where('user_id', $uid)
                ->where('status', 'completed')
                ->when($from && $to, fn($q) => $q->whereBetween('created_at', [$from, $to]))
                ->sum('earnings');

        $sumComms = fn($from = null, $to = null) =>
            Commission::where('beneficiary_user_id', $uid)
                ->when($from && $to, fn($q) => $q->whereBetween('created_at', [$from, $to]))
                ->sum('amount');

        // Totals
        $earningsToday  = (float)$sumTasks($todayStart, $todayEnd)  + (float)$sumComms($todayStart, $todayEnd);
        $earningsWeek   = (float)$sumTasks($weekStart, $weekEnd)    + (float)$sumComms($weekStart, $weekEnd);
        $earningsMonth  = (float)$sumTasks($monthStart, $monthEnd)  + (float)$sumComms($monthStart, $monthEnd);

        $prevMonthStart = now()->subMonthNoOverflow()->startOfMonth();
        $prevMonthEnd   = now()->subMonthNoOverflow()->endOfMonth();
        $earningsPrevMonth = (float)$sumTasks($prevMonthStart,$prevMonthEnd) + (float)$sumComms($prevMonthStart,$prevMonthEnd);
        $growthAmount = $earningsMonth - $earningsPrevMonth;
        $growthPct = $earningsPrevMonth > 0 ? ($growthAmount / $earningsPrevMonth) * 100 : null;

        return view('home', [
            'earningsToday' => $earningsToday,
            'earningsWeek'  => $earningsWeek,
            'earningsMonth' => $earningsMonth,
            'growthPct' => $growthPct,
        ]);

        // return view('home'); // Only users with 'complete' stage get to dashboard
    }


    public function reviewDashboard()
    {
        $breadcrumbs = [
            'Review Dashboard' => '' // current page, no link
        ];

        $payments = MembershipPayment::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->with(['user', 'level'])
            ->get();

        return view('onboarding.review-dashboard', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Review Dashboard',
            'payments' => $payments
        ]);
    }

    /**
     * Show the signup success page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // This method is called after successful registration
    // It can be used to show a success message or redirect to another page


    public function signupSuccess()
    {
        $breadcrumbs = [
            'signup Success' => '' // current page, no link
        ];

        return view('onboarding.signup-success', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Signup Success'
        ]);
        // return view('onboarding.kycForm'); // KYC form view
    }

    public function kycForm()
    {
        $breadcrumbs = [
            // 'KYC Compliance' => route('kyc.form'),
            'KYC Form' => '' // current page, no link
        ];

        return view('onboarding.kycForm', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'KYC Form'
        ]);
        // return view('onboarding.kycForm'); // KYC form view
    }


    public function submitKYC(Request $request)
    {
        $request->validate([
            'country' => 'required|string',
            'document_type' => 'required|string',
            'document_file' => 'required|file|mimes:jpg,jpeg,png|max:2048', // 2MB max
        ]);

        // Save file
        $filePath = $request->file('document_file')->store('kyc-documents', 'public');

        $user = auth()->user();
        $user->kyc_document_type = $request->document_type;
        $user->country = $request->country;
        $user->kyc_document_file = $filePath;
        $user->registration_stage = 'kyc'; // Update registration stage to kyc
        $user->save();

        return redirect()->route('membership.package')->with('success', 'KYC submitted successfully.');
    }

    
    public function membershipPackage()
    {
        $breadcrumbs = [
            'Membership Package' => '' // current page, no link
        ];

        $levels = Level::orderBy('id')->get();

        return view('onboarding.membership-package', [
            'breadcrumbs' => $breadcrumbs,
            'title' => 'Membership Package',
            'levels' => $levels
        ]);
    }


    public function submitPackagePayment(Request $request)
    {
        $request->validate([
        'level_id' => 'required|exists:levels,id',
        'payment_proof' => 'required|file|mimes:jpg,jpeg,png|max:2048', // 2MB max
    ]);

    $level = Level::findOrFail($request->level_id);

    // $filename = uniqid('proof_') . '.' . $request->file('payment_proof')->getClientOriginalExtension();
    // $destinationPath = public_path('assets/payment-proofs');

    // if (!file_exists($destinationPath)) {
    //     mkdir($destinationPath, 0755, true);
    // }

    // $request->file('payment_proof')->move($destinationPath, $filename);
    $filePath = $request->file('payment_proof')->store('payment-documents', 'public');

    MembershipPayment::create([
        'user_id' => auth()->id(),
        'level_id' => $level->id,
        'amount' => $level->entry_fee,
        'payment_proof' => $filePath,
        'status' => 'pending',
    ]);

    $user = auth()->user();
    $user->registration_stage = 'complete'; // Update registration stage to complete
    $user->status = 'review'; // Set status to review
    $user->level_id = $level->id; // Set user's level
    $user->save();

    return redirect()->route('dashboard')->with('success', 'Payment submitted successfully. Awaiting verification.');
    }


    // public function wallet()
    // {
    //     $breadcrumbs = [
    //         'Wallet' => '' // current page, no link
    //     ];

    //     $userId = auth()->id();
    //     $totalWalletBalance = auth()->user()->wallet_balance;
    //     $taskIncomeToday = UserVideoTask::where('user_id', $userId)
    //         ->where('status', 'completed')
    //         ->whereDate('created_at', Carbon::today())
    //         ->sum('earnings');

    //     $taskIncomeThisWeek = UserVideoTask::where('user_id', $userId)
    //         ->where('status', 'completed')
    //         ->whereBetween('created_at', [
    //             Carbon::now()->startOfWeek(),
    //             Carbon::now()->endOfWeek()
    //         ])->sum('earnings');

    //     $taskIncomeThisMonth = UserVideoTask::where('user_id', $userId)
    //         ->where('status', 'completed')
    //         ->whereMonth('created_at', Carbon::now()->month)
    //         ->whereYear('created_at', Carbon::now()->year)
    //         ->sum('earnings');

    //     $allTaskIncome = UserVideoTask::where('user_id', $userId)
    //         ->where('status', 'completed')
    //         ->sum('earnings');

    //     return view('member.wallet', [
    //         'breadcrumbs' => $breadcrumbs,
    //         'title' => 'Wallet',
    //         'totalWalletBalance' => $totalWalletBalance,
    //         'taskIncomeToday' => $taskIncomeToday,
    //         'taskIncomeThisWeek' => $taskIncomeThisWeek,
    //         'taskIncomeThisMonth' => $taskIncomeThisMonth,
    //         'allTaskIncome' => $allTaskIncome,
    //     ]);
    // }


    // public function wallet()
    // {
    //     $breadcrumbs = ['Wallet' => ''];
    //     $user   = auth()->user();
    //     $userId = $user->id;

    //     $totalWalletBalance = $user->wallet_balance;

    //     // --- your existing task income blocks stay unchanged ---

    //     // 1) Commission credits (referral + task)
    //     $commissionCredits = Commission::with(['sourceUser:id,name', 'video:id,title'])
    //         ->where('beneficiary_user_id', $userId)   // <-- correct column
    //         ->latest()
    //         ->take(40)
    //         ->get()
    //         ->map(function ($c) {
    //             $from = optional($c->sourceUser)->name ?? 'Someone';
    //             $title = $c->type === 'task'
    //                 ? "Task commission (L{$c->level}) from {$from}"
    //                 : "Referral commission (L{$c->level}) from {$from}";

    //             $subtitle = $c->video ? ('Video: '.$c->video->title) : null;

    //             return [
    //                 'date'      => $c->created_at,
    //                 'amount'    => (float) $c->amount,
    //                 'title'     => $title,
    //                 'subtitle'  => $subtitle,
    //                 'direction' => 'credit',
    //                 'icon'      => 'bi-arrow-down-left',
    //                 'class'     => 'text-theme-1',
    //             ];
    //         });

    //     // 2) Own video task earnings (credits)
    //     $ownTaskEarnings = \DB::table('user_video_tasks as uvt')
    //         ->leftJoin('videos as v', 'uvt.video_id', '=', 'v.id')
    //         ->where('uvt.user_id', $userId)
    //         ->where('uvt.status', 'completed')
    //         ->orderByDesc('uvt.created_at')
    //         ->limit(40)
    //         ->get(['uvt.created_at as date', 'uvt.earnings as amount', 'v.title as video_title'])
    //         ->map(fn($row) => [
    //             'date'      => $row->date,
    //             'amount'    => (float) $row->amount,
    //             'title'     => 'Video task earning',
    //             'subtitle'  => $row->video_title ? 'Video: '.$row->video_title : null,
    //             'direction' => 'credit',
    //             'icon'      => 'bi-arrow-down-left',
    //             'class'     => 'text-theme-1',
    //         ]);

    //     // 3) Withdrawals (debits) — include only successful/paid ones
    //     $withdrawals = Withdrawal::where('user_id', $userId)
    //         ->whereIn('status', ['approved', 'paid', 'completed']) // adapt to your statuses
    //         ->latest()
    //         ->take(40)
    //         ->get()
    //         ->map(function ($w) {
    //             // If you store fees, you can display both or net amount; here we show the gross debit.
    //             $method = $w->method ?? null;      // optional columns
    //             $ref    = $w->reference ?? null;

    //             $subtitleParts = [];
    //             if ($method) $subtitleParts[] = "Method: {$method}";
    //             if ($ref)    $subtitleParts[] = "Ref: {$ref}";
    //             $subtitle = $subtitleParts ? implode(' • ', $subtitleParts) : null;

    //             return [
    //                 'date'      => $w->created_at,
    //                 'amount'    => (float) $w->amount, // keep positive; Blade prefixes '-' for debits
    //                 'title'     => 'Withdrawal',
    //                 'subtitle'  => $subtitle,
    //                 'direction' => 'debit',
    //                 'icon'      => 'bi-arrow-up-right',
    //                 'class'     => '', // no green for debits
    //             ];
    //         });

    //     // Merge all, sort by date desc, take 10 for the widget
    //     $recentTransactions = $commissionCredits
    //         ->merge($ownTaskEarnings)
    //         ->merge($withdrawals)
    //         ->sortByDesc('date')
    //         ->take(10)
    //         ->values();

    //     return view('member.wallet', [
    //         'breadcrumbs'        => $breadcrumbs,
    //         'title'              => 'Wallet',
    //         'totalWalletBalance' => $totalWalletBalance,
    //         'taskIncomeToday'    => UserVideoTask::where('user_id', $userId)->where('status', 'completed')->whereDate('created_at', now())->sum('earnings'),
    //         'taskIncomeThisWeek' => UserVideoTask::where('user_id', $userId)->where('status', 'completed')->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('earnings'),
    //         'taskIncomeThisMonth'=> UserVideoTask::where('user_id', $userId)->where('status', 'completed')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('earnings'),
    //         'allTaskIncome'      => UserVideoTask::where('user_id', $userId)->where('status', 'completed')->sum('earnings'),
    //         'recentTransactions' => $recentTransactions,
    //     ]);
    // }


    public function wallet()
    {
        $breadcrumbs = ['Wallet' => ''];
        $user   = auth()->user();
        $userId = $user->id;

        $bankOk = !empty($user->account_holder_name) && !empty($user->account_number) && !empty($user->bank_name);
        $bankContactString = $bankOk
            ? "{$user->account_holder_name} - {$user->account_number} - {$user->bank_name}"
            : null;

        // your existing totals (unchanged) ...
        $totalWalletBalance = $user->wallet_balance;
        $taskIncomeToday = \App\Models\UserVideoTask::where('user_id', $userId)->where('status','completed')->whereDate('created_at', Carbon::today())->sum('earnings');
        $taskIncomeThisWeek = \App\Models\UserVideoTask::where('user_id', $userId)->where('status','completed')->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('earnings');
        $taskIncomeThisMonth = \App\Models\UserVideoTask::where('user_id', $userId)->where('status','completed')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('earnings');
        $allTaskIncome = \App\Models\UserVideoTask::where('user_id', $userId)->where('status','completed')->sum('earnings');

        // 1) commissions (credits)
        $commQ = DB::table('commissions as c')
            ->leftJoin('users as su', 'c.source_user_id', '=', 'su.id')
            ->leftJoin('videos as v', 'c.video_id', '=', 'v.id')
            ->where('c.beneficiary_user_id', $userId)
            ->selectRaw("
                c.created_at as happened_at,
                c.amount as amount,
                'credit' as direction,
                CASE WHEN c.type = 'video_task'
                    THEN CONCAT('Task commission (L', c.`level`, ') from ', COALESCE(su.name,'Someone'))
                    ELSE CONCAT('Referral commission (L', c.`level`, ') from ', COALESCE(su.name,'Someone'))
                END as title,
                v.title as subtitle,
                'bi-arrow-down-left' as icon,
                'text-theme-1' as class
            ")
            ->orderByDesc('c.created_at')  // <-- qualify
            ->limit(40);

        $taskQ = DB::table('user_video_tasks as uvt')
            ->leftJoin('videos as v', 'uvt.video_id', '=', 'v.id')
            ->where('uvt.user_id', $userId)
            ->where('uvt.status', 'completed')
            ->selectRaw("
                uvt.created_at as happened_at,
                uvt.earnings as amount,
                'credit' as direction,
                'Video task earning' as title,
                v.title as subtitle,
                'bi-arrow-down-left' as icon,
                'text-theme-1' as class
            ")
            ->orderByDesc('uvt.created_at') // <-- qualify
            ->limit(40);

        $withQ = DB::table('withdrawals as w')
            ->where('w.user_id', $userId)
            ->whereIn('w.status', ['approved','paid','completed','pending'])
            ->selectRaw("
                w.created_at as happened_at,
                w.amount as amount,
                'debit' as direction,
                'Withdrawal Request' as title,
                NULL as subtitle,
                'bi-arrow-up-right' as icon,
                '' as class
            ")
            ->orderByDesc('w.created_at')   // <-- qualify
            ->limit(40);

        // Union and final sort
        $union = $commQ->unionAll($taskQ)->unionAll($withQ);

        $recentTransactions = DB::query()
            ->fromSub($union, 'feed')
            ->orderByDesc('happened_at') // final sort across all types
            ->limit(5)
            ->get()
            ->map(function ($r) {
                return [
                    'date'      => $r->happened_at,
                    'amount'    => (float)$r->amount,
                    'title'     => $r->title,
                    'subtitle'  => $r->subtitle ? 'Video: '.$r->subtitle : null,
                    'direction' => $r->direction,
                    'icon'      => $r->icon,
                    'class'     => $r->class,
                ];
            });

        $user = auth()->user()->loadMissing('level');

        $fallbackMinMap = [
            1=>9500, 2=>19500, 3=>25000, 4=>37500, 5=>67500, 6=>150000,
            7=>225000, 8=>535000, 9=>975000, 10=>1500000, 11=>3750000, 12=>5250000,
        ];

        $levelId = (int) data_get($user, 'level_id', data_get($user, 'level.id', 0));
        $minWithdrawalForUser = (float) (data_get($user, 'level.min_withdrawal') ?? ($fallbackMinMap[$levelId] ?? 0));

        return view('member.wallet', compact(
            'breadcrumbs','totalWalletBalance','taskIncomeToday',
            'taskIncomeThisWeek','taskIncomeThisMonth','allTaskIncome',
            'recentTransactions','bankContactString','bankOk','minWithdrawalForUser'
        ))->with('title','Wallet');
    }


    // public function myEarnings()
    // {
    //     $breadcrumbs = [
    //         'My Earnings' => '' // current page, no link
    //     ];

    //     $userId = auth()->id();
    //     $user = auth()->user()->loadMissing('level');

    //     $totalEarningsToday = UserVideoTask::where('user_id', $userId)
    //     ->where('status', 'completed')
    //     ->whereDate('created_at', Carbon::today())
    //     ->sum('earnings');

    //     // Videos available today
    //     $videosToday = Video::whereDate('available_date', Carbon::today())->get();

    //     // Get the amount per video for the user
    //     $rewardPerVideo = (float) data_get($user, 'level.reward_per_video', 0);

    //     return view('member.earnings', [
    //         'breadcrumbs' => $breadcrumbs,
    //         'title' => 'My Earnings',
    //         'totalEarningsToday' => $totalEarningsToday,
    //         'videosToday' => $videosToday,
    //         'rewardPerVideo' => $rewardPerVideo,
    //     ]);
    // }


    public function myEarnings()
    {
        $breadcrumbs = ['My Earnings' => ''];

        $user = auth()->user()->loadMissing('level');
        $rewardPerVideo = (float) data_get($user, 'level.reward_per_video', 0);
        $limit = (int) data_get($user, 'level.daily_tasks', 0); // 0/null = no cap

        // (Optional but sensible) exclude videos the user already completed today
        $completedTodayIds = \App\Models\UserVideoTask::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereDate('created_at', now()->toDateString())
            ->pluck('video_id');

        $videosQuery = \App\Models\Video::whereDate('available_date', now()->toDateString())
            // ->when($completedTodayIds->isNotEmpty(), fn($q) => $q->whereNotIn('id', $completedTodayIds))
            ->orderBy('available_date', 'desc'); // or ->latest()

        // Apply the level limit directly to the query
        if ($limit > 0) {
            $videosQuery->limit($limit);
        }
        $videosToday = $videosQuery->get();

        $totalEarningsToday = \App\Models\UserVideoTask::where('user_id', $user->id)
            ->where('status', 'completed')
            ->whereDate('created_at', now()->toDateString())
            ->sum('earnings');

        return view('member.earnings', [
            'breadcrumbs'        => $breadcrumbs,
            'title'              => 'My Earnings',
            'totalEarningsToday' => $totalEarningsToday,
            'videosToday'        => $videosToday,     // already limited
            'rewardPerVideo'     => $rewardPerVideo,  // dynamic amount by level
            'dailyLimit'         => $limit,           // if you still want to show it
        ]);
    }



    public function mySubscriptions()
    {
        $breadcrumbs = ['My Subscription' => ''];

        $payments = MembershipPayment::where('user_id', auth()->id())
            ->where('status', 'verified')
            ->with(['user', 'level'])
            ->get();

        return view('member.subscription', [
            'breadcrumbs' => $breadcrumbs,
            'payments' => $payments,
            'title'      => 'My Subscription',
        ]);
    }



    public function myTransactions()
    {
        $breadcrumbs = ['My Transactions' => ''];

        $user   = auth()->user();
        $userId = $user->id;

        // 1) Commissions (credits)
        $commQ = DB::table('commissions as c')
            ->leftJoin('users as su', 'c.source_user_id', '=', 'su.id')
            ->where('c.beneficiary_user_id', $userId)
            ->selectRaw("
                c.created_at  as happened_at,
                CASE WHEN c.type = 'video_task'
                    THEN CONCAT('Task commission (L', c.`level`, ') from ', COALESCE(su.name,'Someone'))
                    ELSE CONCAT('Referral commission (L', c.`level`, ') from ', COALESCE(su.name,'Someone'))
                END            as description,
                c.amount       as amount,
                'completed'    as status,
                'credit'       as direction
            ");

        // 2) Your own video task earnings (credits)
        $taskQ = DB::table('user_video_tasks as uvt')
            ->leftJoin('videos as v', 'uvt.video_id', '=', 'v.id')
            ->where('uvt.user_id', $userId)
            ->where('uvt.status', 'completed')
            ->selectRaw("
                uvt.created_at          as happened_at,
                'Video task earning'    as description,
                uvt.earnings            as amount,
                uvt.status              as status,
                'credit'                as direction
            ");

        // 3) Withdrawals (debits)
        $withQ = DB::table('withdrawals as w')
            ->where('w.user_id', $userId)
            ->selectRaw("
                w.created_at   as happened_at,
                'Withdrawal Request'   as description,
                w.amount       as amount,
                w.status       as status,
                'debit'        as direction
            ");

        // 4) Membership payments (debits)
        $mpQ = DB::table('membership_payments as mp')
            ->where('mp.user_id', $userId)
            ->selectRaw("
                mp.created_at  as happened_at,
                'Membership Subscription' as description,
                mp.amount      as amount,
                mp.status      as status,
                'debit'        as direction
            ");

        // Merge all, sort by date (newest first). No inner ORDER BY to avoid ambiguity.
        $union = $commQ->unionAll($taskQ)->unionAll($withQ)->unionAll($mpQ);

        $rows = DB::query()
            ->fromSub($union, 't')
            ->orderBy('happened_at', 'asc') // final sort across all types
            ->limit(500) // adjust or paginate if needed
            ->get()
            ->map(function ($r) {
                // normalize status text for display (optional)
                $status = (string) $r->status;
                return (object)[
                    'happened_at' => $r->happened_at,
                    'description' => $r->description,
                    'amount'      => (float)$r->amount,
                    'direction'   => $r->direction,  // 'credit' | 'debit'
                    'status'      => Str::headline($status), // e.g., "In Progress" / "Completed"
                    'status_raw'  => $status,              // raw if you need badges by value
                ];
            });

        return view('member.transaction', [
            'breadcrumbs' => $breadcrumbs,
            'transactions' => $rows,
            'title'      => 'My Transactions',
        ]);
    }




    public function withdrawal()
    {        
        $breadcrumbs = ['Withdrawals' => ''];

        $userId = auth()->id();

        // Status buckets (tweak to match your app’s exact values)
        $approvedStatuses = ['approved','paid','completed','success','successful'];
        $pendingStatuses  = ['pending','processing','in_progress','queued'];
        $rejectedStatuses = ['rejected','failed','declined','cancelled','error'];

        // Totals for the cards
        $approvedTotal = Withdrawal::where('user_id', $userId)
            ->whereIn('status', $approvedStatuses)
            ->sum('amount');

        $pendingTotal = Withdrawal::where('user_id', $userId)
            ->whereIn('status', $pendingStatuses)
            ->sum('amount');

        $rejectedTotal = Withdrawal::where('user_id', $userId)
            ->whereIn('status', $rejectedStatuses)
            ->sum('amount');

        // Optional counts (if you want to show “X requests” under each card)
        $approvedCount = Withdrawal::where('user_id', $userId)->whereIn('status',$approvedStatuses)->count();
        $pendingCount  = Withdrawal::where('user_id', $userId)->whereIn('status',$pendingStatuses)->count();
        $rejectedCount = Withdrawal::where('user_id', $userId)->whereIn('status',$rejectedStatuses)->count();

        // List data (paginated)
        $withdrawals = Withdrawal::where('user_id', $userId)
            ->orderByDesc('created_at')
            ->paginate(500); // adjust page size as you like

        return view('member.withdrawal', [
            'breadcrumbs'    => $breadcrumbs,
            'title'          => 'Withdrawals',
            'approvedTotal'  => $approvedTotal,
            'pendingTotal'   => $pendingTotal,
            'rejectedTotal'  => $rejectedTotal,
            'approvedCount'  => $approvedCount,
            'pendingCount'   => $pendingCount,
            'rejectedCount'  => $rejectedCount,
            'withdrawals'    => $withdrawals,
        ]);
    }

}
