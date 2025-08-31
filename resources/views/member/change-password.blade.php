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
                            <a class="nav-link active" aria-current="page" href="{{ route('password.change') }}">
                                <div class="avatar avatar-28 icon"><i class="bi bi-people fs-4"></i></div>
                                <div class="col">
                                    <p class="h6 mb-0">Access Control</p>
                                    <p class="small opacity-75">Change your password</p>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('payment.update') }}">
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
                        <i class="bi bi-shield-lock me-2"></i>
                        Security Settings
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

                    <div class="row">
                        <div class="col-lg-6">
                            <h6 class="mb-3">Change Password</h6>
                            <form action="{{ secure_url('/settings/change-password') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                        id="current_password" name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" 
                                        id="new_password" name="new_password" required>
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" 
                                        id="new_password_confirmation" name="new_password_confirmation" required>
                                </div>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-key me-2"></i>
                                    Change Password
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
