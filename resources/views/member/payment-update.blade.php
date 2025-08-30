@extends('layouts.dashboard-app')

@section('content')
<!-- settings -->
<div class="row">
    <div class="col-12 col-md-4 col-lg-4 col-xl-3">
        <div class="position-sticky" style="top:5.5rem">
            <div class="card adminuiux-card mb-4">
                <div class="card-body">
                    <ul class="nav nav-pills adminuiux-nav-pills flex-column">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('settings.update') }}">
                                <div class="avatar avatar-28 icon"><i data-feather="user"></i></div>
                                <div class="col">
                                    <p class="h6 mb-0">My Profile</p>
                                    <p class="small opacity-75">Basic Details</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('password.change') }}">
                                <div class="avatar avatar-28 icon"><i class="bi bi-people fs-4"></i></div>
                                <div class="col">
                                    <p class="h6 mb-0">Access Control</p>
                                    <p class="small opacity-75">Change your password</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{ route('payment.update') }}">
                                <div class="avatar avatar-28 icon"><i class="bi bi-cash-stack fs-4"></i></div>
                                <div class="col">
                                    <p class="h6 mb-0">Payment</p>
                                    <p class="small opacity-75">Update your payment</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card adminuiux-card overflow-hidden mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bank me-2"></i>
                        Payment Information
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

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

                    <form action="{{ route('payment.update.submit') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country Name</label>
                                <select class="form-select @error('country') is-invalid @enderror" 
                                        id="country" name="country" required>
                                    <option value="">Select Country</option>
                                    <option value="Libya" {{ (Auth::user()->country ?? '') == 'Libya' ? 'selected' : '' }}>Libya</option>
                                    <option value="Nigeria" {{ (Auth::user()->country ?? '') == 'Nigeria' ? 'selected' : '' }}>Nigeria</option>
                                    <option value="Ghana" {{ (Auth::user()->country ?? '') == 'Ghana' ? 'selected' : '' }}>Ghana</option>
                                    <option value="Kenya" {{ (Auth::user()->country ?? '') == 'Kenya' ? 'selected' : '' }}>Kenya</option>
                                    <option value="South Africa" {{ (Auth::user()->country ?? '') == 'South Africa' ? 'selected' : '' }}>South Africa</option>
                                    <option value="Egypt" {{ (Auth::user()->country ?? '') == 'Egypt' ? 'selected' : '' }}>Egypt</option>
                                    <option value="Morocco" {{ (Auth::user()->country ?? '') == 'Morocco' ? 'selected' : '' }}>Morocco</option>
                                    <option value="Other" {{ (Auth::user()->country ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('country_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="bank_name" class="form-label">Bank Name</label>
                                <input type="text" class="form-control @error('bank_name') is-invalid @enderror" 
                                    id="bank_name" name="bank_name" value="{{ Auth::user()->bank_name ?? '' }}" 
                                    placeholder="Enter your bank name" required>
                                @error('bank_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="account_number" class="form-label">Account Number</label>
                                <input type="text" class="form-control @error('account_number') is-invalid @enderror" 
                                    id="account_number" name="account_number" value="{{ Auth::user()->account_number ?? '' }}" 
                                    placeholder="Enter your account number" required>
                                @error('account_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="account_name" class="form-label">Account Name</label>
                                <input type="text" class="form-control @error('account_name') is-invalid @enderror" 
                                    id="account_name" name="account_name" value="{{ Auth::user()->account_holder_name ?? '' }}" 
                                    placeholder="Enter account holder name" required>
                                @error('account_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Important:</strong> Please ensure all payment information is accurate. Incorrect details may delay your withdrawals.
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-theme">
                                <i class="bi bi-check-circle me-2"></i>
                                Update Payment Information
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
