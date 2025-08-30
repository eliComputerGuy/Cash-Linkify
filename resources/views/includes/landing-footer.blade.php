<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-section">
                <div class="footer-logo">
                    <img src="{{ asset('assets/img/logo-512.png') }}" alt="Cash Linkify Logo">
                    <span class="footer-logo-text">Cash Linkify</span>
                </div>
                <p>Your Partner in Growth and Opportunity. Join our platform to earn daily through video tasks and referrals.</p>
            </div>
            
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('index') }}">Home</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('packages') }}">Packages</a></li>
                    <li><a href="{{ route('faqs') }}">FAQs</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Services</h3>
                <ul class="footer-links">
                    <li><a href="#">Video Tasks</a></li>
                    <li><a href="#">Referral Program</a></li>
                    <li><a href="#">Daily Rewards</a></li>
                    <li><a href="#">Community</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h3>Support</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Terms of Service</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} Cash Linkify. All rights reserved.</p>
        </div>
    </div>
</footer>
