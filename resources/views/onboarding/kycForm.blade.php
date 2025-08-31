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

        <div class="h-100 py-3 px-3">
            <div class="row h-100 align-items-center justify-content-center">
                <div class="col-11 col-sm-8 col-md-11 col-xl-11 col-xxl-10 login-box">
                    <div class="text-center mb-4">
                        <h2 class="mb-3">Complete your KYC</h2>
                        <p class="text-secondary">Upload supportive document type</p>
                    </div>
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ secure_url('/onboarding/kyc') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Country -->
                        <div class="form-floating mb-3">
                            <select class="form-select" id="country" name="country" aria-label="Country">
                                <option value="Libya">Libya</option>
                                <option value="Nigeria">Nigeria</option>
                                <option value="Germany">Germany</option>
                                <option value="Italy">Italy</option>
                                <option value="Netherlands">Netherlands</option>
                            </select>
                            <label for="country">Country</label>
                        </div>

                        <!-- Document Type -->
                         <div class="form-floating mb-3">
                            <select class="form-select" id="document_type" name="document_type" aria-label="Document Type">
                                <option value="Passport">Passport</option>
                                <option value="National ID">National ID</option>
                                <option value="Driver's License">Driver's License</option>
                            </select>
                            <label for="document_type">Document Type</label>
                        </div>

                        <!-- Document Upload -->
                        <div class="form-floating mb-4">
                            <input type="file" class="form-control" name="document_file" id="document_file" required>
                            <label for="document_file" class="form-label">Upload Document</label>
                            <small class="text-muted d-block mb-3">Accepted formats: JPG, JPEG, PNG (max 2MB)</small>
                        </div>

                        <button type="submit" class="btn btn-lg btn-theme w-100 mb-4">Submit KYC</button>
                    </form>
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
@endsection
