@extends('layouts.login-app')

@section('content')
<div class="container-fluid">
                <div class="auth-wrapper">
                    <!--Page body-->

                    <!-- login wrap -->
                    <div class="row">
                        <div class="col-12 col-md-6 col-xl-4 minvheight-100 d-flex flex-column px-0">
                            <!-- standard header -->
                            <!-- standard header -->
@include('includes.login-header')

        <div class="h-100 py-4 px-3">
            <div class="row h-100 align-items-center justify-content-center mt-md-4">
                <div class="col-11 col-sm-8 col-md-11 col-xl-11 col-xxl-10 login-box">
                    <div class="text-center mb-4">
                        <h1 class="mb-2">Welcome&#9996;</h1>
                        <p class="text-secondary">Enter your credential to login</p>
                    </div>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-floating mb-3">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter email address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            <label for="email">Email Address</label>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="position-relative">
                            <div class="form-floating mb-3">
                                <input id="passwd" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter your password" name="password" required autocomplete="current-password">
                                <label for="passwd">Password</label>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <button class="btn btn-square btn-link text-theme-1 position-absolute end-0 top-0 mt-2 me-2 ">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="rememberme" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="rememberme">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                            @if (Route::has('password.request'))
                            <div class="col-auto">
                                <a href="{{ route('password.request') }}" class=" ">Forget Password?</a>
                            </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-lg btn-theme w-100 mb-4">
                            {{ __('Login') }}
                        </button>
                        <!-- <a href="investment-dashboard.html" class="btn btn-lg btn-theme w-100 mb-4">Login</a> -->
                        <!-- <button class="btn btn-lg btn-theme w-100 mb-4">Login</button> -->
                        <div class="text-center mb-3">
                            Don't have account? <a href="{{ route('register') }}" class=" ">Create Account</a>
                        </div>
                    </form>
                    <div class="row align-items-center mb-3">
                        <div class="col">
                            <hr class="">
                        </div>
                        <div class="col-auto">
                            <p class="text-secondary">OR</p>
                        </div>
                        <div class="col">
                            <hr class="">
                        </div>
                    </div>

                    <button class="btn btn-lg btn-outline-theme w-100 mb-3 text-start">
                        <img src="{{secure_url('assets/img/g-logo.png')}}" alt="" class="me-2"> Sign in with Google
                    </button>
                    <button class="btn btn-lg btn-outline-theme w-100 mb-4 text-start">
                        <img src="{{secure_url('assets/img/f-logo.png')}}" alt="" class="me-2"> Sign in with Facebook
                    </button>
                    <br><br>
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

                                            <!-- Slider container -->
                                            <div class="swiper swipernavpagination pb-5">
                                                <div class="swiper-wrapper">
                                                    <!-- Slides -->
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
                                                <!-- pagination -->
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



<!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->
@endsection
