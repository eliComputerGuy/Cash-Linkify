@extends('layouts.landing')

@section('title', 'Contact Us - Cash Linkify')
@section('description', 'Get in touch with Cash Linkify. Contact our support team for assistance with your account, investment questions, or general inquiries.')
@section('keywords', 'contact Cash Linkify, support, customer service, help desk, contact information, get help, customer support')
@section('og_image', secure_url('assets/img/logo-512.png'))

@section('content')
    <!-- Hero Section -->
    <section class="hero-simple">
        <div class="container">
            <div class="hero-content">
                <h1>Get in <span class="highlight">Touch</span></h1>
                <p>Have questions? We're here to help. Contact our support team for assistance.</p>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title fade-in-up">Contact Us</h2>
            <p class="section-subtitle fade-in-up">We'd love to hear from you. Send us a message and we'll respond as soon as possible.</p>
            
            <div class="contact-grid">
                <div class="contact-info fade-in-left">
                    <h3>Get in Touch</h3>
                    <p>Our support team is available to help you with any questions or concerns you may have about our platform.</p>
                    
                    <div class="contact-methods">
                        <div class="contact-method">
                            <div class="contact-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="contact-details">
                                <h4>Email</h4>
                                <p>support@libyafuturetrust.com</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="contact-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div class="contact-details">
                                <h4>Phone</h4>
                                <p>+218 XXX XXX XXX</p>
                            </div>
                        </div>
                        
                        <div class="contact-method">
                            <div class="contact-icon">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="contact-details">
                                <h4>Address</h4>
                                <p>Cash Linkify<br>Benghazi, Libya</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="support-hours">
                        <h4>Support Hours</h4>
                        <p><strong>Standard Support:</strong> Monday - Friday, 9 AM - 6 PM (Libya Time)</p>
                        <p><strong>Premium Support:</strong> 24/7 Available</p>
                    </div>
                </div>
                
                <div class="contact-form-container fade-in-right">
                    <form class="contact-form" action="#" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Full Name *</label>
                            <input type="text" id="name" name="name" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Email Address *</label>
                            <input type="email" id="email" name="email" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone">
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject *</label>
                            <select id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="general">General Inquiry</option>
                                <option value="support">Technical Support</option>
                                <option value="billing">Billing Question</option>
                                <option value="partnership">Partnership</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea id="message" name="message" rows="5" required placeholder="Please describe your inquiry in detail..."></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Preview Section -->
    <section class="section section-gray">
        <div class="container">
            <h2 class="section-title fade-in-up">Frequently Asked Questions</h2>
            <p class="section-subtitle fade-in-up">Find quick answers to common questions</p>
            
            <div class="faq-preview">
                <div class="faq-item stagger-item">
                    <div class="faq-question">
                        <span>How do I get started?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Getting started is easy! Simply register for an account, complete your profile verification, and you can immediately start earning through daily video tasks and our referral program.</p>
                    </div>
                </div>
                
                <div class="faq-item stagger-item">
                    <div class="faq-question">
                        <span>How much can I earn?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Earnings vary based on your package level and activity. Members typically earn between $5-50 per day from video tasks, plus additional income from referrals.</p>
                    </div>
                </div>
                
                <div class="faq-item stagger-item">
                    <div class="faq-question">
                        <span>Is the platform secure?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we use advanced security measures including SSL encryption, two-factor authentication, and secure payment processing to protect your account and personal information.</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center">
                <a href="{{ route('faqs') }}" class="btn btn-secondary">View All FAQs</a>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="container">
            <h2>Ready to Start Earning?</h2>
            <p>Join thousands of members who are already earning daily through Cash Linkify</p>
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-cta">Access Your Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="btn-cta">Get Started Now</a>
            @endauth
        </div>
    </section>
@endsection

@section('extra_js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // FAQ toggle functionality
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    faqQuestions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const toggle = this.querySelector('.faq-toggle');
            
            // Close other open FAQs
            document.querySelectorAll('.faq-answer.active').forEach(openAnswer => {
                if (openAnswer !== answer) {
                    openAnswer.classList.remove('active');
                    openAnswer.previousElementSibling.querySelector('.faq-toggle').classList.remove('active');
                }
            });
            
            // Toggle current FAQ
            answer.classList.toggle('active');
            toggle.classList.toggle('active');
        });
    });
    
    // Form validation
    const contactForm = document.querySelector('.contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic form validation
            const requiredFields = this.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#ef4444';
                } else {
                    field.style.borderColor = '';
                }
            });
            
            if (isValid) {
                // Show success message (in real implementation, this would submit to server)
                alert('Thank you for your message! We will get back to you soon.');
                this.reset();
            } else {
                alert('Please fill in all required fields.');
            }
        });
    }
});
</script>
@endsection