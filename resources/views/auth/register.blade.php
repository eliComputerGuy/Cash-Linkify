@extends('layouts.login-app')

@section('content')
<div class="container-fluid">
    <div class="auth-wrapper">
        <div class="row">
            <div class="col-12 col-md-6 col-xl-4 minvheight-100 d-flex flex-column px-0">
                @include('includes.login-header')
                <div class="h-100 py-3 px-3">
                    <div class="row h-100 align-items-center justify-content-center">
                        <div class="col-11 col-sm-8 col-md-11 col-xl-11 col-xxl-10 login-box">
                            <div class="text-center mb-4">
                                <h1 class="mb-3">Let's get started&#128077;</h1>
                                <p class="text-secondary">Provide your few details</p>
                            </div>
                            <form method="POST" action="{{ secure_url('/register') }}">
                                @csrf
                                <div class="form-floating mb-3">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter first name" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                                    <label for="name">Full Name</label>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address" name="email" value="{{ old('email') }}" autocomplete="email">
                                    <label for="email">Email Address</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-floating mb-3" id="referral_code_section">
                                    <input id="referral_code_input" type="text" class="form-control" placeholder="Enter referral code" name="referral_code" readonly>
                                    <label for="referral_code_input">Referral Code</label>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="form-floating maxwidth-100">
                                        <select class="form-select" id="code" name="country_code" aria-label="Country code">
                                            <option value="218">+218</option>
                                            <option value="234">+234</option>
                                            <option value="91">+91</option>
                                        </select>
                                        <label for="code">Code</label>
                                    </div>
                                    <div class="form-floating">
                                        <input type="text" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" id="phone_number" placeholder="Enter your phone number">
                                        <label for="phone_number">Phone Number</label>
                                    </div>
                                    @error('phone_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="position-relative">
                                    <div class="form-floating mb-3">
                                        <input id="checkstrength" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" name="password" autocomplete="new-password">
                                        <label for="checkstrength">Password</label>
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <button type="button" class="btn btn-square btn-link text-theme-1 position-absolute end-0 top-0 mt-2 me-2">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="feedback mb-3">
                                    <div class="row">
                                        <div class="col">
                                            <div class="check-strength" id="checksterngthdisplay">
                                                <div></div><div></div><div></div><div></div><div></div><div></div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <span class="small" id="textpassword"></span>
                                            <i class="bi bi-info-circle text-theme ms-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Password should contain atleast 1 capital, 1 alphanumeric & min. 8 characters"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="position-relative">
                                    <div class="form-floating mb-3">
                                        <input id="password-confirm" type="password" placeholder="Confirm your password" class="form-control" name="password_confirmation" autocomplete="new-password">
                                        <label for="password-confirm">Confirm Password</label>
                                    </div>
                                    <button type="button" class="btn btn-square btn-link text-theme-1 position-absolute end-0 top-0 mt-2 me-2">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-lg btn-theme w-100 mb-4">Sign up</button>
                            </form>
                            <div class="text-center mb-3">
                                Already have account? <a href="{{ route('login') }}">Login</a> here.
                            </div>
                            <div class="row align-items-center mb-3">
                                <div class="col"><hr></div>
                                <div class="col-auto">
                                    <p class="text-secondary">OR Continue with</p>
                                </div>
                                <div class="col"><hr></div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <button class="btn btn-lg btn-outline-theme w-100 mb-3 text-start">
                                        <img src="assets/img/g-logo.png" alt="" class="me-2"> Google
                                    </button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-lg btn-outline-theme w-100 mb-4 text-start">
                                        <img src="assets/img/f-logo.png" alt="" class="me-2"> Facebook
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @include('includes.login-footer')
            </div>
            <div class="col-12 col-md-6 col-xl-8 p-4 d-none d-md-block">
                <div class="card adminuiux-card bg-theme-1-space position-relative overflow-hidden h-100">
                    <div class="card-body position-relative z-index-1">
                        <div class="row h-100 d-flex flex-column justify-content-center align-items-center gx-0 text-center">
                            <div class="col-10 col-md-11 col-xl-8 mb-4 mx-auto">
                                <div class="swiper swipernavpagination pb-5">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <img src="{{secure_url('assets/img/investment/slide2.png')}}" alt="" class="mw-100 mb-3">
                                            <h2 class="text-white mb-3">Earn Rewards by Completing Daily Tasks.</h2>
                                            <p class="lead opacity-75">Watch Videos each day and earn money for <br/> completing queick and easy tasks.</p>
                                        </div>
                                        <div class="swiper-slide">
                                            <img src="{{secure_url('assets/img/investment/slide.png')}}" alt="" class="mw-100 mb-3">
                                            <h2 class="text-white mb-3">Grow Your Investments with Muiltiple Opportunities</h2>
                                            <p class="lead opacity-75">Choose from a variety of investment options <br/> to diversify your portfolio and maxinize returns.</p>
                                        </div>
                                    </div>
                                    <div class="swiper-pagination white bottom-0"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function getCookie(name) {
        let match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
        if (match) return decodeURIComponent(match[2]);
        return null;
    }

    $(document).ready(function() {
        var ref = getCookie('referral_code');
        // console.log('Referral code from cookie:', ref); // Debug line
        if (ref) {
            $('#referral_code_input').val(ref);
        } else {
            $('#referral_code_section').hide();
        }
    });
</script>
@endsection
