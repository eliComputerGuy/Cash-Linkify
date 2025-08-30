@extends('layouts.landing')

@section('title', 'About Us - Cash Linkify')
@section('description', 'Learn about Cash Linkify, our mission, values, and commitment to providing legitimate earning opportunities through daily video tasks and referral programs.')
@section('keywords', 'about Cash Linkify, company mission, values, team, history, legitimate platform, earning opportunities, Libya')
@section('og_image', asset('assets/img/logo-512.png'))

@section('content')
    <!-- Hero Section -->
    <section class="hero-simple">
        <div class="container">
            <div class="hero-content">
                <h1>About <span class="highlight">Cash Linkify</span></h1>
                <p>Learn about our mission, values, and commitment to empowering Libyans through innovative earning opportunities.</p>
            </div>
        </div>
    </section>

    <!-- About Content -->
    <section class="section">
        <div class="container">
            <div class="about-grid">
                <div class="about-text">
                    <h3>Our Mission</h3>
                    <p>Cash Linkify was founded with a clear mission: to provide accessible, legitimate earning opportunities for people across Libya. We believe that financial empowerment is the foundation of a prosperous society, and we're committed to helping our members build sustainable wealth through our innovative video task system and referral program.</p>
                    
                    <h3>Our Vision</h3>
                    <p>We envision a Libya where every individual has the opportunity to achieve financial independence while contributing to the nation's economic growth. Through our platform, we're creating a community of empowered individuals who support each other's success.</p>
                    
                    <h3>Our Values</h3>
                    <ul>
                        <li><strong>Trust:</strong> We build lasting relationships based on transparency and reliability</li>
                        <li><strong>Innovation:</strong> We continuously improve our platform to provide the best earning opportunities</li>
                        <li><strong>Community:</strong> We foster a supportive environment where members help each other succeed</li>
                        <li><strong>Integrity:</strong> We operate with honesty and ethical business practices</li>
                        <li><strong>Empowerment:</strong> We believe in giving people the tools they need to achieve financial freedom</li>
                    </ul>
                    
                    <h3>Why Choose Us</h3>
                    <p>With over 10,000 active members and millions in earnings distributed, we've established ourselves as a trusted partner in financial success. Our platform combines cutting-edge technology with proven earning strategies to deliver consistent results for our members.</p>
                </div>
                
                <div class="about-stats">
                    <div class="stat-card">
                        <h3>10,000+</h3>
                        <p>Active Members</p>
                    </div>
                    <div class="stat-card">
                        <h3>$2M+</h3>
                        <p>Total Earnings Distributed</p>
                    </div>
                    <div class="stat-card">
                        <h3>98%</h3>
                        <p>Member Satisfaction Rate</p>
                    </div>
                    <div class="stat-card">
                        <h3>24/7</h3>
                        <p>Customer Support</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title">Our Leadership Team</h2>
            <p class="section-subtitle">Meet the dedicated professionals behind Cash Linkify</p>
            
            <div class="team-grid">
                <div class="team-member">
                    <div class="member-avatar">
                        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="CEO">
                    </div>
                    <h3>Ahmed Al-Mahmoud</h3>
                    <p class="member-role">Chief Executive Officer</p>
                    <p class="member-bio">With over 15 years of experience in financial technology and digital platforms, Ahmed leads our mission to empower Libyans through innovative earning opportunities.</p>
                </div>
                
                <div class="team-member">
                    <div class="member-avatar">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="CTO">
                    </div>
                    <h3>Fatima Al-Zahra</h3>
                    <p class="member-role">Chief Technology Officer</p>
                    <p class="member-bio">Fatima oversees our technical infrastructure, ensuring our platform remains secure, reliable, and user-friendly for all our members.</p>
                </div>
                
                <div class="team-member">
                    <div class="member-avatar">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80" alt="COO">
                    </div>
                    <h3>Omar Ben Ali</h3>
                    <p class="member-role">Chief Operations Officer</p>
                    <p class="member-bio">Omar manages our day-to-day operations, ensuring smooth service delivery and maintaining the high standards our members expect.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Join Our Growing Community</h2>
            <p>Start your journey to financial freedom with Cash Linkify</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-cta">Access Your Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-cta">Get Started Now</a>
            @endauth
        </div>
    </section>
@endsection

