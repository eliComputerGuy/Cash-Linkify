@extends('layouts.dashboard-app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="bi bi-graph-up me-2"></i>
                    Investment Packages
                </h4>
                <p class="card-text">Choose the investment package that best suits your financial goals</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <h1>&nbsp;</h1>
</div>
<div class="row">
    @foreach($packages as $package)
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 border-0 shadow-sm">
            @if($package->image)
            <div class="card-img-top text-center p-3">
                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="img-fluid" style="max-height: 150px;">
            </div>
            @endif
            
            <div class="card-body d-flex flex-column">
                <h5 class="card-title text-theme-1">{{ $package->name }}</h5>
                
                @if($package->description)
                <p class="card-text text-muted">{{ $package->description }}</p>
                @endif
                
                <div class="mb-3">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h6 class="text-success mb-1">{{ $package->daily_rate }}%</h6>
                                <small class="text-muted">Daily Profit</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h6 class="text-info mb-1">{{ $package->duration_days }} Days</h6>
                            <small class="text-muted">Duration</small>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Investment Range:</span>
                        <span class="fw-bold">₦{{ number_format($package->min_amount) }} - ₦{{ number_format($package->max_amount) }}</span>
                    </div>
                </div>
                
                <div class="mt-auto">
                    <a href="{{ route('investment.package.show', $package->id) }}" class="btn btn-theme w-100">
                        <i class="bi bi-arrow-right me-2"></i>
                        Select Package
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($packages->isEmpty())
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h4 class="mt-3">No Investment Packages Available</h4>
                <p class="text-muted">Please check back later for available investment opportunities.</p>
            </div>
        </div>
    </div>
</div>
@endif

@endsection
