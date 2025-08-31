@extends('layouts.landing')

@section('title', 'FAQs - Cash Linkify')
@section('description', 'Find answers to frequently asked questions about Cash Linkify, our services, investment packages, and how to get started with earning opportunities.')
@section('keywords', 'FAQs, frequently asked questions, Cash Linkify help, support, questions and answers, how to earn, investment guide')
@section('og_image', secure_url('assets/img/logo-512.png'))

@section('content')
    <!-- Hero Section -->
    <section class="hero-simple">
        <div class="container">
            <div class="hero-content">
                <h1>Frequently Asked <span class="highlight">Questions</span></h1>
                <p>Find answers to common questions about Cash Linkify and our services.</p>
            </div>
        </div>
    </section>

    <!-- FAQs Section -->
    <section class="section">
        <div class="container">
            <h2 class="section-title">Common Questions</h2>
            <p class="section-subtitle">Everything you need to know about our platform and services</p>
            
            <div class="faq-container">
                <!-- General Questions -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What is Cash Linkify?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Cash Linkify is a leading platform that provides legitimate earning opportunities for people across Libya. We offer daily video tasks and a multi-level referral system to help members build sustainable income.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Is Cash Linkify legitimate?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, Cash Linkify is a legitimate platform with over 10,000 active members and millions in earnings distributed. We operate with full transparency and comply with all local regulations.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do I get started?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Getting started is easy! Simply register for an account, complete your profile verification, and you can immediately start earning through daily video tasks and our referral program.</p>
                    </div>
                </div>
                
                <!-- Video Tasks -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What are daily video tasks?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Daily video tasks are simple, engaging activities that you can complete each day to earn rewards. These tasks are designed to be easy to complete and provide consistent earning opportunities.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How much can I earn from video tasks?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Earnings from video tasks vary based on your package level and task completion. Members typically earn between $5-50 per day from completing their daily tasks.</p>
                    </div>
                </div>
                
                <!-- Referral System -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How does the referral system work?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Our referral system works on 3 levels. You earn 10% commission on direct referrals, 3% on second-level referrals, and 2% on third-level referrals. This creates a sustainable passive income stream.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What are the commission rates?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Commission rates vary by package: Starter Package (5%), Professional Package (10%), and Premium Package (15%). These rates apply to all levels of your referral network.</p>
                    </div>
                </div>
                
                <!-- Investment Plans -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What investment plans do you offer?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>We offer three investment plans: Starter Package ($100/month), Professional Package ($500/month), and Premium Package ($1000/month). Each plan offers different returns and features based on your investment goals.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What are the expected returns?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Expected returns vary by package: Starter (5-8% monthly), Professional (8-12% monthly), and Premium (12-18% monthly). These are historical averages and actual returns may vary.</p>
                    </div>
                </div>
                
                <!-- Payments & Withdrawals -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How do I withdraw my earnings?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>You can withdraw your earnings through multiple methods including bank transfer, mobile money, and digital wallets. Withdrawal processing times vary by method and package level.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What are the withdrawal fees?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Withdrawal fees vary by method and package level. Premium package members enjoy reduced or waived fees. Standard fees range from 1-3% depending on the withdrawal method.</p>
                    </div>
                </div>
                
                <!-- Security -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Is my account secure?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Yes, we use advanced security measures including SSL encryption, two-factor authentication, and secure payment processing to protect your account and personal information.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What happens if I forget my password?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>You can reset your password using the "Forgot Password" link on the login page. We'll send a secure reset link to your registered email address.</p>
                    </div>
                </div>
                
                <!-- Support -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How can I get support?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>We offer multiple support channels including email, live chat, and phone support. Premium package members receive priority support with faster response times.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What are your support hours?</span>
                        <span class="faq-toggle">+</span>
                    </div>
                    <div class="faq-answer">
                        <p>Our support team is available 24/7 for Premium package members. Standard support is available Monday-Friday, 9 AM to 6 PM Libya time.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="section section-gray">
        <div class="container">
            <div class="faq-support">
                <h3>Still Have Questions?</h3>
                <p>Can't find what you're looking for? Our support team is here to help.</p>
                <a href="{{ route('contact') }}" class="btn">Contact Support</a>
            </div>
        </div>
    </section>
@endsection

@section('extra_js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqQuestions = document.querySelectorAll('.faq-question');
    
    // FAQ Toggle Functionality
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
});
</script>
@endsection
