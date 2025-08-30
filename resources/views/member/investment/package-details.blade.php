@extends('layouts.dashboard-app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="bi bi-graph-up me-2"></i>
                    {{ $package->name }} - Investment Details
                </h4>
                <a href="{{ route('investment.packages') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Packages
                </a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <h1>&nbsp;</h1>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Investment Form</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Please fix the following errors:
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('investment.package.select', $package->id) }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="amount" class="form-label">Investment Amount (₦)</label>
                            <input type="number" 
                                   class="form-control @error('amount') is-invalid @enderror" 
                                   id="amount" 
                                   name="amount" 
                                   min="{{ $package->min_amount }}" 
                                   max="{{ $package->max_amount }}" 
                                   step="0.01"
                                   value="{{ old('amount', $package->min_amount) }}"
                                   required>
                            <div class="form-text">
                                Range: ₦{{ number_format($package->min_amount) }} - ₦{{ number_format($package->max_amount) }}
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="duration" class="form-label">Investment Duration (Days)</label>
                            <input type="number" 
                                   class="form-control @error('duration') is-invalid @enderror" 
                                   id="duration" 
                                   name="duration" 
                                   min="{{ $package->duration_days }}" 
                                   value="{{ old('duration', $package->duration_days) }}"
                                   required>
                            <div class="form-text">
                                Minimum: {{ $package->duration_days }} days
                            </div>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Investment Summary:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Daily Profit Rate: <strong>{{ $package->daily_rate }}%</strong></li>
                            <li>Package: <strong>{{ $package->name }}</strong></li>
                            <li>Duration: <strong id="duration-display" data-min-duration="{{ $package->duration_days }}">{{ $package->duration_days }} days</strong></li>
                            <li>Estimated Daily Profit: <strong id="daily-profit" data-rate="{{ $package->daily_rate }}" data-min-amount="{{ $package->min_amount }}">₦0.00</strong></li>
                            <li>Total Estimated Profit: <strong id="total-profit">₦0.00</strong></li>
                        </ul>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-theme">
                            <i class="bi bi-check-circle me-2"></i>
                            Proceed to Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Package Information</h5>
            </div>
            <div class="card-body">
                @if($package->image)
                <div class="text-center mb-3">
                    <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="img-fluid rounded" style="max-height: 200px;">
                </div>
                @endif
                
                <h6 class="text-primary">{{ $package->name }}</h6>
                
                @if($package->description)
                <p class="text-muted">{{ $package->description }}</p>
                @endif
                
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-success mb-1">{{ $package->daily_rate }}%</h4>
                            <small class="text-muted">Daily Profit Rate</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="border rounded p-3">
                            <h4 class="text-info mb-1">{{ $package->duration_days }}</h4>
                            <small class="text-muted">Min Duration (Days)</small>
                        </div>
                    </div>
                </div>
                
                <div class="border rounded p-3">
                    <h6 class="mb-2">Investment Range</h6>
                    <p class="mb-1"><strong>Minimum:</strong> ₦{{ number_format($package->min_amount) }}</p>
                    <p class="mb-0"><strong>Maximum:</strong> ₦{{ number_format($package->max_amount) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const amountInput = document.getElementById('amount');
    const durationInput = document.getElementById('duration');
    const dailyProfitDisplay = document.getElementById('daily-profit');
    const totalProfitDisplay = document.getElementById('total-profit');
    const durationDisplay = document.getElementById('duration-display');
    
    // Get values from data attributes
    const dailyRate = parseFloat(dailyProfitDisplay.dataset.rate);
    const minAmount = parseFloat(dailyProfitDisplay.dataset.minAmount);
    const minDuration = parseInt(durationDisplay.dataset.minDuration);
    
    console.log('Initial values:', { dailyRate, minAmount, minDuration });
    console.log('Elements found:', { amountInput, durationInput, dailyProfitDisplay, totalProfitDisplay, durationDisplay });
    
    function calculateProfits() {
        const amount = parseFloat(amountInput.value) || minAmount;
        const duration = parseInt(durationInput.value) || minDuration;
        
        const dailyProfit = (amount * dailyRate) / 100;
        const totalProfit = dailyProfit * duration;
        
        dailyProfitDisplay.textContent = '₦' + dailyProfit.toFixed(2);
        totalProfitDisplay.textContent = '₦' + totalProfit.toFixed(2);
        durationDisplay.textContent = duration + ' days';
        
        console.log('Calculated:', { amount, duration, dailyRate, dailyProfit, totalProfit });
    }
    
    // Add event listeners
    if (amountInput) {
        amountInput.addEventListener('input', calculateProfits);
        amountInput.addEventListener('change', calculateProfits);
    }
    
    if (durationInput) {
        durationInput.addEventListener('input', calculateProfits);
        durationInput.addEventListener('change', calculateProfits);
    }
    
    // Calculate initial values
    calculateProfits();
    
    // Also calculate on window load as backup
    window.addEventListener('load', calculateProfits);
});
</script>
@endpush
