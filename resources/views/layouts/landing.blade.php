<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Primary Meta Tags -->
    <title>@yield('title', 'Cash Linkify – Your Partner in Growth and Opportunity')</title>
    <meta name="title" content="@yield('title', 'Cash Linkify – Your Partner in Growth and Opportunity')">
    <meta name="description" content="@yield('description', 'Join Cash Linkify and start earning through daily video tasks and referrals. Build sustainable income with our legitimate platform. Register now and unlock your financial potential.')">
    <meta name="keywords" content="@yield('keywords', 'Cash Linkify, earn money online, video tasks, referral program, passive income, Libya, financial opportunities, investment platform, daily earnings')">
    <meta name="author" content="Cash Linkify">
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <meta name="revisit-after" content="7 days">
    <meta name="distribution" content="global">
    <meta name="rating" content="general">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Cash Linkify – Your Partner in Growth and Opportunity')">
    <meta property="og:description" content="@yield('description', 'Join Cash Linkify and start earning through daily video tasks and referrals. Build sustainable income with our legitimate platform. Register now and unlock your financial potential.')">
    <meta property="og:image" content="@yield('og_image', asset('assets/img/logo-512.png'))">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:site_name" content="Cash Linkify">
    <meta property="og:locale" content="en_US">
    
    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Cash Linkify – Your Partner in Growth and Opportunity')">
    <meta property="twitter:description" content="@yield('description', 'Join Cash Linkify and start earning through daily video tasks and referrals. Build sustainable income with our legitimate platform. Register now and unlock your financial potential.')">
    <meta property="twitter:image" content="@yield('og_image', asset('assets/img/logo-512.png'))">
    <meta property="twitter:site" content="@cashlinkify">
    <meta property="twitter:creator" content="@cashlinkify">
    
    <!-- Additional SEO Meta Tags -->
    <meta name="theme-color" content="#0E5665">
    <meta name="msapplication-TileColor" content="#0E5665">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
    
    <!-- Schema.org Microdata -->
    <div itemscope itemtype="https://schema.org/Organization" style="display: none;">
        <span itemprop="name">Cash Linkify</span>
        <span itemprop="description">Cash Linkify is a leading platform that provides legitimate earning opportunities for people across Libya through daily video tasks and referral programs.</span>
        <span itemprop="url">{{ url('/') }}</span>
        <img itemprop="logo" src="{{ asset('assets/img/logo-512.png') }}" alt="Cash Linkify Logo" style="display: none;">
        <div itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
            <span itemprop="addressCountry">Libya</span>
        </div>
        <div itemprop="contactPoint" itemscope itemtype="https://schema.org/ContactPoint">
            <span itemprop="contactType">customer service</span>
            <span itemprop="availableLanguage">English</span>
            <span itemprop="availableLanguage">Arabic</span>
        </div>
        <div itemprop="sameAs">
            <a href="https://facebook.com/cashlinkify" itemprop="url">Facebook</a>
            <a href="https://twitter.com/cashlinkify" itemprop="url">Twitter</a>
            <a href="https://instagram.com/cashlinkify" itemprop="url">Instagram</a>
        </div>
    </div>
    
    <!-- Preconnect to external domains for performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Fonts and Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}">
    
    @yield('extra_css')
</head>
<body>
    @include('includes.landing-header')
    
    @yield('content')
    
    @include('includes.landing-footer')
    
    <script src="{{ asset('assets/js/landing.js') }}"></script>
    @yield('extra_js')
    
    <!-- Go to Top Button -->
    <button class="go-to-top" id="goToTop" title="Go to top">
        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M7.41 15.41L12 10.83l4.59 4.58L18 14l-6-6-6 6z"/>
        </svg>
    </button>
</body>
</html>
