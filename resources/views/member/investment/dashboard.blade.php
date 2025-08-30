@extends('layouts.dashboard-app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="bi bi-graph-up me-2"></i>
                    Investment Dashboard
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <h1>&nbsp;</h1>
</div>

<div class="row">
    <!-- Investment Overview -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Investment Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Investment Details</h6>
                        <p><strong>Package:</strong> {{ $activeInvestment->product->name }}</p>
                        <p><strong>Investment Amount:</strong> ₦{{ number_format($activeInvestment->amount, 2) }}</p>
                        <p><strong>Daily Profit Rate:</strong> {{ $activeInvestment->product->daily_rate }}%</p>
                        <p><strong>Daily Profit:</strong> ₦{{ number_format($activeInvestment->daily_profit, 2) }}</p>
                        <p><strong>Start Date:</strong> {{ $activeInvestment->start_date->format('M d, Y') }}</p>
                        <p><strong>End Date:</strong> {{ $activeInvestment->end_date->format('M d, Y') }}</p>
                        <p><strong>Status:</strong> 
                            <span class="badge bg-success">Active</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Progress</h6>
                        @php
                            $totalDays = $activeInvestment->start_date->diffInDays($activeInvestment->end_date);
                            $elapsedDays = $activeInvestment->start_date->diffInDays(now());
                            $remainingDays = $activeInvestment->getRemainingDays();
                            $progressPercentage = \min(100, ($elapsedDays / $totalDays) * 100);
                        @endphp
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>Investment Progress</span>
                                <span>{{ number_format($progressPercentage, 1) }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar bg-success" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                        </div>
                        
                        <div class="border rounded p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Days Elapsed:</span>
                                <strong>{{ $elapsedDays }} days</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Days Remaining:</span>
                                <strong>{{ $remainingDays }} days</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Total Duration:</span>
                                <strong>{{ $totalDays }} days</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Profit Summary -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Profit Summary</h5>
            </div>
            <div class="card-body">
                @php
                    $currentProfit = $activeInvestment->calculateCurrentProfit();
                    $totalExpectedProfit = $activeInvestment->daily_profit * $totalDays;
                @endphp
                
                <div class="text-center mb-4">
                    <h3 class="text-success mb-1">₦{{ number_format($currentProfit, 2) }}</h3>
                    <p class="text-muted mb-0">Current Total Profit</p>
                </div>
                
                <div class="border rounded p-3 mb-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Daily Profit:</span>
                        <strong>₦{{ number_format($activeInvestment->daily_profit, 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Current Profit:</span>
                        <strong>₦{{ number_format($currentProfit, 2) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Expected Total:</span>
                        <strong>₦{{ number_format($totalExpectedProfit, 2) }}</strong>
                    </div>
                </div>
                
                @if($activeInvestment->hasEnded())
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Investment Completed!</strong> Your investment duration has ended. You can now complete the investment to withdraw your profits.
                    </div>
                    
                    @php
                        $user = Auth::user();
                        $hasBankDetails = !empty($user->bank_name) && !empty($user->account_number) && !empty($user->account_holder_name);
                    @endphp
                    
                    @if(!$hasBankDetails)
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Bank Details Required!</strong> Please update your bank details before completing the investment.
                            <br><br>
                            <a href="{{ route('payment.update') }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-bank me-1"></i>
                                Update Bank Details
                            </a>
                        </div>
                    @endif
                    
                    <form action="{{ route('investment.complete', $activeInvestment->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success w-100" {{ !$hasBankDetails ? 'disabled' : '' }}>
                            <i class="bi bi-check-circle me-2"></i>
                            Complete Investment & Withdraw Profits
                        </button>
                    </form>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Investment Active!</strong> You're earning daily profits.
                    </div>
                @endif
                
                @if($activeInvestment->status === 'completed')
                    @php
                        $withdrawal = \App\Models\Withdrawal::where('user_id', Auth::id())
                            ->where('description', 'like', '%Investment profit withdrawal%')
                            ->where('description', 'like', '%' . $activeInvestment->product->name . '%')
                            ->latest()
                            ->first();
                    @endphp
                    
                    @if($withdrawal)
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Withdrawal Status:</strong> 
                            <span class="badge bg-{{ $withdrawal->status === 'approved' ? 'success' : ($withdrawal->status === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($withdrawal->status) }}
                            </span>
                            <br>
                            <small class="text-muted">
                                Amount: ₦{{ number_format($withdrawal->amount, 2) }} | 
                                Reference: {{ $withdrawal->reference }}
                            </small>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <h1>&nbsp;</h1>
</div>

<div class="row">
    <!-- Profit History -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Profit History</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Daily Profit</th>
                                <th>Cumulative Profit</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cumulativeProfit = 0;
                                $currentDate = $activeInvestment->start_date->copy();
                            @endphp
                            
                            @while($currentDate->lte(now()) && $currentDate->lte($activeInvestment->end_date))
                                @php
                                    $cumulativeProfit += $activeInvestment->daily_profit;
                                @endphp
                                <tr>
                                    <td>{{ $currentDate->format('M d, Y') }}</td>
                                    <td class="text-success">+₦{{ number_format($activeInvestment->daily_profit, 2) }}</td>
                                    <td class="fw-bold">₦{{ number_format($cumulativeProfit, 2) }}</td>
                                    <td>
                                        @if($currentDate->isToday())
                                            <span class="badge bg-primary">Today</span>
                                        @elseif($currentDate->isPast())
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $currentDate->addDay();
                                @endphp
                            @endwhile
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
