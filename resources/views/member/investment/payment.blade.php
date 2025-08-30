@extends('layouts.dashboard-app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="bi bi-credit-card me-2"></i>
                    Payment Instructions
                </h4>
                <a href="{{ route('investment.package.show', $investment->product_id) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>
                    Back to Package
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
                <h5 class="card-title mb-0">Investment Summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Investment Details</h6>
                        <p><strong>Package:</strong> {{ $investment->product->name }}</p>
                        <p><strong>Amount:</strong> ₦{{ number_format($investment->amount, 2) }}</p>
                        <p><strong>Duration:</strong> {{ Carbon\Carbon::parse($investment->start_date)->diffInDays($investment->end_date) }} days</p>
                        <p><strong>Daily Profit:</strong> ₦{{ number_format($investment->daily_profit, 2) }}</p>
                        <p><strong>Start Date:</strong> {{ $investment->start_date->format('M d, Y') }}</p>
                        <p><strong>End Date:</strong> {{ $investment->end_date->format('M d, Y') }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Expected Returns</h6>
                        <div class="border rounded p-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Daily Profit:</span>
                                <strong>₦{{ number_format($investment->daily_profit, 2) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Profit:</span>
                                <strong>₦{{ number_format($investment->daily_profit * Carbon\Carbon::parse($investment->start_date)->diffInDays($investment->end_date), 2) }}</strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Total Return:</span>
                                <strong>₦{{ number_format($investment->amount + ($investment->daily_profit * Carbon\Carbon::parse($investment->start_date)->diffInDays($investment->end_date)), 2) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Payment Details</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>Important:</strong> Please make payment to the account below and upload proof of payment.
                </div>
                
                <div class="border rounded p-3 mb-3">
                    <h6 class="mb-2">Bank Account Details</h6>
                    <p class="mb-1"><strong>Bank:</strong> Bank Name</p>
                    <p class="mb-1"><strong>Account Name:</strong> Account Name</p>
                    <p class="mb-1"><strong>Account Number:</strong> 1234567890</p>
                    <p class="mb-0"><strong>Amount:</strong> ₦{{ number_format($investment->amount, 2) }}</p>
                </div>
                
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Note:</strong> After making payment, please upload your payment receipt or screenshot as proof.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <h1>&nbsp;</h1>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Upload Payment Proof</h5>
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

                <form action="{{ route('investment.payment.submit', $investment->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="payment_proof" class="form-label">Payment Proof (Receipt/Screenshot)</label>
                        <input type="file" 
                               class="form-control @error('payment_proof') is-invalid @enderror" 
                               id="payment_proof" 
                               name="payment_proof" 
                               accept="image/*,.pdf"
                               required>
                        <div class="form-text">
                            Upload a clear image or PDF of your payment receipt. Accepted formats: JPG, PNG, PDF (Max: 2MB)
                        </div>
                        @error('payment_proof')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-success">
                        <i class="bi bi-check-circle me-2"></i>
                        <strong>Next Steps:</strong>
                        <ol class="mb-0 mt-2">
                            <li>Make payment to the provided bank account</li>
                            <li>Upload proof of payment above</li>
                            <li>Submit the form</li>
                            <li>Wait for admin verification (usually within 24 hours)</li>
                            <li>Start earning daily profits once verified!</li>
                        </ol>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-upload me-2"></i>
                            Submit Payment Proof
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
