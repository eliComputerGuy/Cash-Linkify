@extends('layouts.landing')

@section('title', 'Packages - Cash Linkify')
@section('description', 'Explore our investment packages: Starter, Professional, and Premium. Choose the perfect plan to start your earning journey with Cash Linkify.')
@section('keywords', 'investment packages, starter package, professional package, premium package, investment plans, earning plans, Cash Linkify packages')
@section('og_image', asset('assets/img/logo-512.png'))

@section('content')
    <!-- Hero Section -->
    <section class="hero-simple">
        <div class="container">
            <div class="hero-content">
                <h1>Investment <span class="highlight">Packages</span></h1>
                <p>Choose the perfect investment plan that matches your financial goals and risk tolerance.</p>
            </div>
        </div>
    </section>

    <!-- Packages Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Choose Your Investment Plan</h2>
            <p class="section-subtitle">We offer three distinct packages designed to meet different investment needs and goals</p>
            
            <div class="package-grid">
                <!-- Basic Package -->
                <div class="package-card">
                    <h3 class="package-name">Starter Package</h3>
                    <div class="package-price">$100<small>/month</small></div>
                    <p>Perfect for beginners who want to start their investment journey with minimal risk.</p>
                    <ul class="package-features">
                        <li>Low-risk investment strategy</li>
                        <li>Monthly returns of 5-8%</li>
                        <li>Basic portfolio management</li>
                        <li>Email support</li>
                        <li>Access to educational resources</li>
                        <li>Referral commission: 5%</li>
                    </ul>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Access Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    @endauth
                </div>
                
                <!-- Professional Package -->
                <div class="package-card featured">
                    <h3 class="package-name">Professional Package</h3>
                    <div class="package-price">$500<small>/month</small></div>
                    <p>Our most popular package offering balanced growth and security for serious investors.</p>
                    <ul class="package-features">
                        <li>Balanced risk-reward strategy</li>
                        <li>Monthly returns of 8-12%</li>
                        <li>Advanced portfolio management</li>
                        <li>Priority support</li>
                        <li>Exclusive investment opportunities</li>
                        <li>Referral commission: 10%</li>
                        <li>Personal investment advisor</li>
                        <li>Weekly market analysis</li>
                    </ul>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Access Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    @endauth
                </div>
                
                <!-- Premium Package -->
                <div class="package-card">
                    <h3 class="package-name">Premium Package</h3>
                    <div class="package-price">$1000<small>/month</small></div>
                    <p>For experienced investors seeking maximum returns with premium services and support.</p>
                    <ul class="package-features">
                        <li>High-growth investment strategy</li>
                        <li>Monthly returns of 12-18%</li>
                        <li>Premium portfolio management</li>
                        <li>24/7 dedicated support</li>
                        <li>Exclusive high-yield opportunities</li>
                        <li>Referral commission: 15%</li>
                        <li>Personal investment advisor</li>
                        <li>Daily market analysis</li>
                        <li>Custom investment strategies</li>
                        <li>Priority withdrawal processing</li>
                    </ul>
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-primary">Access Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">Why Choose Our Investment Packages?</h2>
            <p class="section-subtitle">Discover the advantages that make our investment plans stand out</p>
            
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Proven Track Record</h3>
                    <p class="feature-description">Our investment strategies have consistently delivered returns for thousands of members across Libya.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Secure & Protected</h3>
                    <p class="feature-description">Your investments are protected by advanced security measures and insurance coverage.</p>
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Flexible Withdrawals</h3>
                    <p class="feature-description">Access your earnings anytime with our flexible withdrawal system and multiple payment options.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Start Your Investment Journey Today</h2>
            <p>Choose the package that best fits your financial goals and begin building your wealth</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-cta">Access Your Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-cta">Get Started Now</a>
            @endauth
        </div>
    </section>
@endsection
