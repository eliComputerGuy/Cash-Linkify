<!-- Navigation -->
<nav class="navbar">
    <div class="container">
        <div class="nav-content">
            <a href="{{ route('index') }}" class="logo">
                <img src="{{ asset('assets/img/logo-512.png') }}" alt="Cash Linkify Logo">
                <span class="logo-text">Cash Linkify</span>
            </a>
            
            <ul class="nav-menu">
                <li><a href="{{ route('index') }}">Home</a></li>
                <li><a href="{{ route('about') }}">About Us</a></li>
                <li><a href="{{ route('packages') }}">Packages</a></li>
                <li><a href="{{ route('faqs') }}">FAQs</a></li>
                <li><a href="{{ route('contact') }}">Contact Us</a></li>
            </ul>
            
            <div class="nav-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
                    @endif
                @endauth
            </div>
            
            <div class="mobile-menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</nav>
