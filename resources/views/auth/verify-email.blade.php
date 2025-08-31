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
                        <h1 class="mb-2">Verify Your Email</h1>
                        <p class="text-secondary">Enter the verification code sent to your email</p>
                    </div>
                    @if(session('status'))
                        <div class="alert alert-success">{{ session('status') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger">{{ $errors->first() }}</div>
                    @endif
                    <form method="POST" action="{{ secure_url('/verify-email') }}">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <div class="mb-3">
                            <label for="code" class="form-label">Verification Code</label>
                            <input type="text" class="form-control" id="code" name="code" placeholder="Enter verification code" required autofocus>
                        </div>
                        <p>&nbsp;</p>
                        <button type="submit" class="btn btn-lg btn-theme w-100">Verify</button>
                    </form>

                    <!-- Resend link -->
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Didn't receive the code? 
                            <a href="{{ route('verification.resend', ['email' => $email]) }}">
                                Resend
                            </a>
                        </small>
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

                                            <!-- Slider container -->
                                            <div class="swiper swipernavpagination pb-5">
                                                <div class="swiper-wrapper">
                                                    <!-- Slides -->
                                                    <div class="swiper-slide">
                                                        <img src="{{asset('assets/img/investment/slide2.png')}}" alt="" class="mw-100 mb-3">
                                                        <h2 class="text-white mb-3">Earn Rewards by Completing Daily Tasks.</h2>
                                                        <p class="lead opacity-75">Watch Videos each day and earn money for <br/> completing queick and easy tasks.</p>
                                                    </div>
                                                    <div class="swiper-slide">
                                                        <img src="{{asset('assets/img/investment/slide.png')}}" alt="" class="mw-100 mb-3">
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
@endsection