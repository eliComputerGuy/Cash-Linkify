@extends('layouts.dashboard-app')

@section('content')

<div class="row align-items-center">
    <div class="col-12 col-lg mb-4">
        <h3 class="fw-normal mb-0 text-secondary">{{ App\Helpers\GetGreetings::getGreeting() }},</h3>
        <h1>{{ explode(' ', trim(Auth::user()->name))[0] }}</h1>
    </div>    
</div>

<div class="row">
    <!-- summary quick -->
    <div class="col-12 col-lg-6 col-xl-4 mb-4">
        <div class="card adminuiux-card position-relative overflow-hidden bg-theme-1 h-100">
            <div class="position-absolute top-0 start-0 h-100 w-100 z-index-0 coverimg opacity-50">
                <img src="{{ asset('assets/img/modern-ai-image/flamingo-4.jpg') }}" alt="">
            </div>
            <div class="card-body z-index-1">
                <div class="row align-items-center justify-content-center h-100 py-4">
                    <div class="col-11">
                        <h2 class="fw-normal">Your earnings value has grown by</h2>
                        <h1 class="mb-3">₦{{ number_format($earningsMonth ?? 0, 2) }}</h1>
                        <p>In this month</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary chart -->
    <div class="col-12 col-lg-6 col-xl-4 mb-4">
        <div class="card adminuiux-card">
            <div class="row gx-0">

                <!-- summary account -->
                <div class="col-12 col-xl-12">
                    <div class="card-header">
                        <h6>Summary</h6>
                    </div>
                    <div class="card-body pb-0">
                        <div class="card adminuiux-card bg-theme-1 mb-3">
                            <div class="card-body">
                                <p class="text-white mb-2">Today's Earnings</p>
                                <h4 class="fw-medium">₦{{ number_format($earningsToday ?? 0, 2) }}</h4>
                            </div>
                        </div>
                        <div class="card adminuiux-card bg-theme-1-subtle mb-3">
                            <div class="card-body">
                                <p class="text-secondary mb-2">This Week Earnings</p>
                                <h4 class="fw-medium">₦{{ number_format($earningsWeek ?? 0, 2) }}</h4>
                            </div>
                        </div>
                        <div class="card adminuiux-card bg-theme-1-subtle mb-3">
                            <div class="card-body">
                                <p class="text-secondary mb-2">This Month Earnings</p>
                                <h4 class="fw-medium">₦{{ number_format($earningsMonth ?? 0, 2) }} <span class="text-success fs-14"><i class="bi bi-arrow-up-short me-1"></i> {{ $growthPct ?? 0 }}%</span></h4>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- start investment -->
    <div class="col-12 col-lg-6 col-xl-4 mb-4">
        <div class="row mb-2">
            <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl mb-3">
                <a href="{{ route('wallet') }}" class="card adminuiux-card style-none text-center h-100">
                    <div class="card-body">
                        <i class="avatar avatar-40 text-theme-1 h3 bi bi-wallet mb-3"></i>
                        <p class="text-secondary small">My Wallet</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl mb-3">
                <a href="{{ route('my.earnings') }}" class="card adminuiux-card style-none text-center h-100">
                    <div class="card-body">
                        <i class="avatar avatar-40 text-theme-1 bi bi-cash-stack h3 mb-3"></i>
                        <p class="text-secondary small">My Earnings</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl mb-3">
                <a href="{{ route('my.subscriptions') }}" class="card adminuiux-card style-none text-center h-100">
                    <div class="card-body">
                        <i class="avatar avatar-40 text-theme-1 bi bi-bank h3 mb-3"></i>
                        <p class="text-secondary small">Subscription</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl mb-3">
                <a href="investment-investment-plans.html" class="card adminuiux-card style-none text-center h-100">
                    <div class="card-body">
                        <i class="avatar avatar-40 text-theme-1 bi bi-piggy-bank h3 mb-3"></i>
                        <p class="text-secondary small">Investment</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl mb-3">
                <a href="{{ route('my.transactions') }}" class="card adminuiux-card style-none text-center">
                    <div class="card-body">
                        <i class="avatar avatar-40 text-theme-1 bi bi-bar-chart h3 mb-3"></i>
                        <p class="text-secondary small">Transactions</p>
                    </div>
                </a>
            </div>
            <div class="col-6 col-md-6 col-lg-6 col-xl-6 col-xxl mb-3">
                <a href="{{ route('settings') }}" class="card adminuiux-card style-none text-center h-100">
                    <div class="card-body">
                        <i class="avatar avatar-40 text-theme-1 bi bi-gear h3 mb-3"></i>
                        <p class="text-secondary small">Settings</p>
                    </div>
                </a>
            </div>
            <div class="col-12 col-lg-12 mb-4">
                <div class="card adminuiux-card">
                    <div class="card-body">
                        <div class="row gx-3">
                            <div class="col">
                                <h4>Refer friends & earn</h4>
                                <p class="text-secondary">Tell your friends to join us & earn 15% bonus.</p>
                                <a href="{{ route('referrals') }}" class="btn btn-sm btn-outline-theme my-1">Invite to Join</a>
                            </div>
                            <div class="col-auto">
                                <div class="avatar avatar-80 rounded bg-theme-1-subtle text-theme-1">
                                    <i class="bi bi-send h1"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
