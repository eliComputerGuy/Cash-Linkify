@extends('layouts.dashboard-app')

@section('content')

<div class="row">
    <div class="col-12 col-lg-8 col-xl-12">
        <div class="alert alert-info alert-dismissible" role="alert">
            <p>Your KYC, membership payment are currently being reviewed. You will be notified once the review is complete.</p>
        </div>
        <div class="card adminuiux-card mb-4">
            <div class="card-header">
                <h6>Current Level </h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-6 col-xl-4 mb-4 mb-lg-0">
                        <div class="card adminuiux-card border mb-3 mb-lg-0">
                            <div class="coverimg height-100 w-100 rounded">
                                <img src="assets/img/modern-ai-image/flamingo-4.jpg" alt="">
                            </div>
                            <div class="card-body text-center mt--50">
                                <figure class="avatar avatar-60 mb-3 mx-auto mtop-35 rounded">
                                    <img src="assets/img/logo-512.png" class="mw-100" alt="">
                                </figure>
                                <h4>{{ $payments->first()->level->name ?? 'N/A' }}</h4>
                                <p class="text-secondary">Membership Plan</p>
                            </div>
                            <div class="card-footer text-center">
                                <h4>₦{{ number_format($payments->first()->amount ?? '0.00', 2) }}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-6 col-xl-4 mb-4 mb-lg-0">
                        <h6>Level Features</h6>
                        <p class="text-secondary mb-4">Including features of basic plan</p>
                        <div class="row mb-3">
                            <div class="col-auto">
                                <i class="bi bi-check-circle text-secondary"></i>
                            </div>
                            <div class="col-auto ps-0">
                                {{ $payments->first()->level->daily_tasks ?? 'N/A' }} Daily Tasks
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-auto">
                                <i class="bi bi-check-circle text-secondary"></i>
                            </div>
                            <div class="col-auto ps-0">
                                ₦{{ number_format($payments->first()->level->reward_per_video ?? 'N/A', 2) }} Reward Per Task
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-auto">
                                <i class="bi bi-check-circle text-secondary"></i>
                            </div>
                            <div class="col-auto ps-0">
                                ₦{{ number_format($payments->first()->level->max_withdrawal_weekly ?? 'N/A', 2) }} Weekly Withdrawal Limit
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-auto">
                                <i class="bi bi-check-circle text-secondary"></i>
                            </div>
                            <div class="col-auto ps-0">
                                Initiate withdrawal anytime
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-auto">
                                <i class="bi bi-check-circle text-secondary"></i>
                            </div>
                            <div class="col-auto ps-0">
                                No hidden fees or charges
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 col-lg-12 col-xl-4">
                        <h6>Payment</h6>
                        <p class="text-secondary mb-4">Membership registration</p>
                        <div class="row mb-3">
                            <div class="col-auto">
                                <i class="bi bi-calendar-event text-theme-1"></i>
                            </div>
                            <div class="col-auto ps-0">
                                Payment date is <b>{{ $payments->first()->created_at->format('d-M-Y') }}</b>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-auto">
                                <i class="bi bi-bank text-theme-1"></i>
                            </div>
                            <div class="col-auto ps-0">
                                Payment status: @if ($payments->first()->status === 'pending')
                                    <span class="badge badge-sm light bg-yellow">{{ ucfirst($payments->first()->status) }}</span>
                                @elseif ($payments->first()->status === 'rejected')
                                    <span class="badge badge-sm light bg-red"> {{ ucfirst($payments->first()->status) }}</span>
                                @else
                                    <span class="badge badge-sm light bg-green"> {{ ucfirst($payments->first()->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="card-footer text-center">
                <button class="btn btn-theme w-100">Upgrade Membership</button>
            </div> -->
        </div>
    </div>
</div>

@endsection