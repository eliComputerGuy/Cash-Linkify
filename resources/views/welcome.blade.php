@extends('layouts.landing')

@section('title', 'Cash Linkify – Your Partner in Growth and Opportunity')
@section('description', 'Join Cash Linkify and start earning through daily video tasks and referrals. Build sustainable income with our legitimate platform. Register now and unlock your financial potential.')
@section('keywords', 'Cash Linkify, earn money online, video tasks, referral program, passive income, Libya, financial opportunities, investment platform, daily earnings, legitimate earning platform')
@section('og_image', url('assets/img/logo-512.png'))

@section('content')
    <!-- Hero Section -->
    <section class="hero">
        <!-- Hero Slider -->
        <div class="hero-slider">
            <!-- Slide 1: Dashboard Overview -->
            <div class="hero-slide active" style="background-image: url('{{ url('assets/img/banner_1_dashboard.png') }}');">
                <div class="hero-slide-content">
                    <h1>Your Partner in <span class="highlight">Growth</span> and <span class="highlight">Opportunity</span></h1>
                    <p>Join Cash Linkify and start earning daily through video tasks and referrals. Build your future with our innovative platform.</p>
                    <div class="hero-buttons">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-hero btn-hero-primary">Go to Dashboard</a>
                        @else
                            <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">Start Earning Today</a>
                        @endauth
                        <a href="#features" class="btn-hero btn-hero-secondary">Learn More</a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 2: Daily Earnings -->
            <div class="hero-slide" style="background-image: url('{{ url('assets/img/banner_2_daily_earnings.png') }}');">
                <div class="hero-slide-content">
                    <h1>Earn <span class="highlight">Daily</span> Through <span class="highlight">Video Tasks</span></h1>
                    <p>Complete simple video tasks every day and watch your earnings grow. Our platform makes earning money accessible to everyone.</p>
                    <div class="hero-buttons">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-hero btn-hero-primary">View Tasks</a>
                        @else
                            <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">Start Earning</a>
                        @endauth
                        <a href="#features" class="btn-hero btn-hero-secondary">See How It Works</a>
                    </div>
                </div>
            </div>
            
            <!-- Slide 3: Referral System -->
            <div class="hero-slide" style="background-image: url('{{ url('assets/img/banner_3_referrals.png') }}');">
                <div class="hero-slide-content">
                    <h1>Build <span class="highlight">Passive Income</span> with <span class="highlight">Referrals</span></h1>
                    <p>Invite friends and family to join our platform. Earn up to 15% commission on their activities across 3 levels deep.</p>
                    <div class="hero-buttons">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn-hero btn-hero-primary">Invite Friends</a>
                        @else
                            <a href="{{ route('register') }}" class="btn-hero btn-hero-primary">Join Now</a>
                        @endauth
                        <a href="#referral-system" class="btn-hero btn-hero-secondary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Slider Controls -->
        <div class="hero-slider-controls">
            <div class="slider-dot active" data-slide="0"></div>
            <div class="slider-dot" data-slide="1"></div>
            <div class="slider-dot" data-slide="2"></div>
        </div>
    </section>

    <!-- About Brief Section -->
    <section class="section">
        <div class="container">
            <div class="about-brief-grid">
                <div class="about-brief-content fade-in-left">
                    <h2 class="section-title fade-in-up">About Cash Linkify</h2>
                    <p class="section-subtitle fade-in-up">Empowering Libyans through innovative earning opportunities</p>
                    <p class="fade-in-up">Cash Linkify is a leading platform dedicated to providing accessible, legitimate earning opportunities for people across Libya. We believe that financial empowerment is the foundation of a prosperous society, and we're committed to helping our members build sustainable wealth through our innovative video task system and referral program.</p>
                    <p class="fade-in-up">Our mission is to create a community where every individual has the opportunity to achieve financial independence while contributing to the nation's economic growth. With over 10,000 active members and millions in earnings distributed, we've established ourselves as a trusted partner in financial success.</p>
                    <div class="about-stats-brief">
                        <div class="stat-item stagger-item">
                            <h3 class="counter" data-target="10000">0</h3>
                            <p>Active Members</p>
                        </div>
                        <div class="stat-item stagger-item">
                            <h3 class="counter" data-target="2000000">0</h3>
                            <p>Total Earnings</p>
                        </div>
                        <div class="stat-item stagger-item">
                            <h3 class="counter" data-target="98">0</h3>
                            <p>Satisfaction Rate</p>
                        </div>
                    </div>
                </div>
                <div class="about-brief-image fade-in-right">
                    <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2111&q=80" alt="Cash Linkify Team">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="section section-gray">
        <div class="container">
            <h2 class="section-title fade-in-up">Why Choose Cash Linkify?</h2>
            <p class="section-subtitle fade-in-up">Our platform offers multiple ways to earn and grow your income</p>
            
            <div class="features-grid">
                <!-- Video Tasks -->
                <div class="feature-card stagger-item">
                    <div class="feature-icon scale-in">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Daily Video Tasks</h3>
                    <p class="feature-description">Complete daily video tasks and earn rewards. Simple, engaging, and profitable activities designed for everyone.</p>
                    <ul class="feature-list">
                        <li>Easy-to-complete tasks</li>
                        <li>Daily earning opportunities</li>
                        <li>Flexible schedule</li>
                    </ul>
                </div>

                <!-- Referral Program -->
                <div class="feature-card stagger-item">
                    <div class="feature-icon scale-in">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Referral Rewards</h3>
                    <p class="feature-description">Invite friends and family to join our platform. Earn commissions on their activities and build a passive income stream.</p>
                    <ul class="feature-list">
                        <li>Generous commission rates</li>
                        <li>Multi-level rewards</li>
                        <li>Passive income potential</li>
                    </ul>
                </div>

                <!-- Secure Platform -->
                <div class="feature-card stagger-item">
                    <div class="feature-icon scale-in">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="feature-title">Secure & Reliable</h3>
                    <p class="feature-description">Your security and trust are our top priorities. We use advanced security measures to protect your account and earnings.</p>
                    <ul class="feature-list">
                        <li>Advanced security protocols</li>
                        <li>Secure payment processing</li>
                        <li>24/7 support available</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title fade-in-up">How It Works</h2>
            <p class="section-subtitle fade-in-up">Get started in just a few simple steps</p>

            <div class="steps-grid">
                <!-- Step 1 -->
                <div class="step stagger-item">
                    <div class="step-number scale-in">1</div>
                    <h3 class="step-title">Sign Up</h3>
                    <p class="step-description">Create your account in minutes. Complete your profile and verification to unlock all features.</p>
                </div>

                <!-- Step 2 -->
                <div class="step stagger-item">
                    <div class="step-number scale-in">2</div>
                    <h3 class="step-title">Start Earning</h3>
                    <p class="step-description">Complete daily video tasks and invite friends to earn through our referral program.</p>
                </div>

                <!-- Step 3 -->
                <div class="step stagger-item">
                    <div class="step-number scale-in">3</div>
                    <h3 class="step-title">Withdraw Earnings</h3>
                    <p class="step-description">Cash out your earnings anytime. Multiple withdrawal options available for your convenience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Investment Plans Section -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title fade-in-up">Investment Plans</h2>
            <p class="section-subtitle fade-in-up">Offering Personalized Strategies to Help You Build Wealth and Achieve Financial Security</p>
            
            <div class="investment-grid">
                <div class="investment-card stagger-item">
                    <div class="investment-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <h3>Conservative Growth</h3>
                    <p>Perfect for beginners and those seeking steady, reliable returns. Our conservative plan focuses on stable investments with moderate risk and consistent earnings.</p>
                    <ul>
                        <li>Low to moderate risk</li>
                        <li>Steady monthly returns</li>
                        <li>Capital preservation focus</li>
                        <li>Ideal for long-term goals</li>
                    </ul>
                </div>
                
                <div class="investment-card featured stagger-item">
                    <div class="investment-icon scale-in">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <h3 class="fade-in-up">Balanced Portfolio</h3>
                    <p>Our most popular plan offering the perfect balance between growth and security. Diversified investments across multiple sectors for optimal returns.</p>
                    <ul>
                        <li>Balanced risk-reward ratio</li>
                        <li>Diversified investment strategy</li>
                        <li>Higher potential returns</li>
                        <li>Professional portfolio management</li>
                    </ul>
                </div>
                
                <div class="investment-card stagger-item">
                    <div class="investment-icon scale-in">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <h3 class="fade-in-up">Aggressive Growth</h3>
                    <p>For experienced investors seeking maximum returns. High-growth opportunities with advanced strategies and premium market access.</p>
                    <ul>
                        <li>High growth potential</li>
                        <li>Advanced investment strategies</li>
                        <li>Premium market access</li>
                        <li>Expert financial guidance</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Referral System Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title fade-in-up">Multi-Level Referral System</h2>
            <p class="section-subtitle fade-in-up">Earn bonuses up to 3 levels deep and build a sustainable passive income</p>
            
            <div class="referral-system">
                <div class="referral-overview">
                    <div class="referral-stats">
                        <div class="referral-stat stagger-item">
                            <h3 class="counter" data-target="3">0</h3>
                            <p>Deep Referral System</p>
                        </div>
                        <div class="referral-stat stagger-item">
                            <h3 class="counter" data-target="15">0</h3>
                            <p>Commission Rate</p>
                        </div>
                        <div class="referral-stat stagger-item">
                            <h3>Unlimited</h3>
                            <p>Earning Potential</p>
                        </div>
                    </div>
                </div>
                
                <div class="referral-levels">
                    <div class="level-card stagger-item">
                        <div class="level-number scale-in">1</div>
                        <h3 class="fade-in-up">Direct Referrals</h3>
                        <p class="fade-in-up">Earn 10% commission on all earnings from members you directly refer to the platform.</p>
                        <div class="level-benefits">
                            <span class="fade-in-up">10% Commission</span>
                            <span class="fade-in-up">Direct Relationship</span>
                            <span class="fade-in-up">Immediate Rewards</span>
                        </div>
                    </div>
                    
                    <div class="level-card stagger-item">
                        <div class="level-number scale-in">2</div>
                        <h3 class="fade-in-up">Second Level</h3>
                        <p class="fade-in-up">Earn 3% commission on earnings from your referrals' referrals (second generation).</p>
                        <div class="level-benefits">
                            <span class="fade-in-up">3% Commission</span>
                            <span class="fade-in-up">Passive Income</span>
                            <span class="fade-in-up">Network Growth</span>
                        </div>
                    </div>
                    
                    <div class="level-card stagger-item">
                        <div class="level-number scale-in">3</div>
                        <h3 class="fade-in-up">Third Level</h3>
                        <p class="fade-in-up">Earn 2% commission on earnings from the third level of your referral network.</p>
                        <div class="level-benefits">
                            <span class="fade-in-up">2% Commission</span>
                            <span class="fade-in-up">Long-term Rewards</span>
                            <span class="fade-in-up">Sustainable Income</span>
                        </div>
                    </div>
                </div>
                
                <div class="referral-example fade-in-up">
                    <h3 class="fade-in-up">Example: Your Earning Potential</h3>
                    <p class="fade-in-up">If you refer 5 people, and each of them refers 5 people, and so on:</p>
                    <div class="example-calculation">
                        <div class="calculation-item stagger-item">
                            <span class="level">Level 1:</span>
                            <span class="count">5 direct referrals</span>
                            <span class="earnings">$500/month</span>
                        </div>
                        <div class="calculation-item stagger-item">
                            <span class="level">Level 2:</span>
                            <span class="count">25 indirect referrals</span>
                            <span class="earnings">$375/month</span>
                        </div>
                        <div class="calculation-item stagger-item">
                            <span class="level">Level 3:</span>
                            <span class="count">125 network members</span>
                            <span class="earnings">$500/month</span>
                        </div>
                        <div class="calculation-total fade-in-up">
                            <span class="total-label">Total Monthly Income:</span>
                            <span class="total-amount">$1,375</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2 class="fade-in-up">Start Your Journey to Financial Freedom Today</h2>
            <p class="fade-in-up">Join thousands of members who are already earning daily through Cash Linkify</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-cta fade-in-up">Access Your Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-cta fade-in-up">Get Started Now</a>
            @endauth
        </div>
    </section>
@endsection
