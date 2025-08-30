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
                            <a class="nav-link active" aria-current="page" href="{{ route('settings.update') }}">
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
                        <i class="bi bi-person-circle me-2"></i>
                        Personal Information
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
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                    id="name" name="name" value="{{ Auth::user()->name }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input disabled type="email" class="form-control @error('email') is-invalid @enderror" 
                                    id="email" name="email" value="{{ Auth::user()->email }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                    id="phone" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <select class="form-select @error('country') is-invalid @enderror" 
                                        id="country" name="country">
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
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                    id="city" name="city" value="{{ Auth::user()->city ?? '' }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                    id="date_of_birth" name="date_of_birth" value="{{ Auth::user()->date_of_birth ?? '' }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="bio" class="form-label">Bio</label>
                            <textarea class="form-control @error('bio') is-invalid @enderror" 
                                    id="bio" name="bio" rows="3" placeholder="Tell us about yourself...">{{ Auth::user()->bio ?? '' }}</textarea>
                            @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-theme">
                                <i class="bi bi-check-circle me-2"></i>
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
