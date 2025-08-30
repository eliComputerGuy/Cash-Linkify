@extends('layouts.dashboard-app')

@section('content')

<div class="row align-items-center">
    <!-- Welcome box -->
    <div class="col-12 col-md-10 col-lg-8 mb-4">
        <h3 class="fw-normal mb-0 text-secondary">Get up to ₦50,000.00 per day</h3>
        <h1>Just by referring your friends to join us.</h1>
    </div>
    <div class="col-12 py-2"></div>
    <!-- copy code-->
    <div class="col-12 col-md-8 col-lg-6 col-xxl-5 mb-4">
        <p>Copy and Share your referral link with your network</p>
        <div class="input-group mb-3">
            <input type="text" id="referral-link" class="form-control form-control-lg border-theme-1" placeholder="Referral Code" aria-describedby="button-addon2" value="{{ url('?ref=' . Auth::user()->referral_code) }}" readonly>
            <button class="btn btn-lg btn-outline-theme" type="button" id="copy-referral-btn"><i class="bi bi-copy"></i></button>
        </div>
    </div>
    <div class="col-12 py-2"></div>
    <!-- registration -->
    <div class="col-6 col-sm-6 col-lg-3 mb-4">
        <div class="card adminuiux-card">
            <div class="card-body">
                <h2>{{ $totalRegistrations }}</h2>
                <p class="text-secondary small">Total Registration</p>
            </div>
        </div>
    </div>
    <!-- trial completed -->
    <div class="col-6 col-sm-6 col-lg-3 mb-4">
        <div class="card adminuiux-card">
            <div class="card-body">
                <h2>{{ $pendingPurchases }}</h2>
                <p class="text-secondary small">Pending Memberships</p>
            </div>
        </div>
    </div>
    <!-- purchased -->
    <div class="col-12 col-sm-6 col-lg-3 mb-4">
        <div class="card adminuiux-card">
            <div class="card-body">
                <h2>{{ $completedPurchases }}</h2>
                <p class="text-secondary small">Purchase Completed</p>
            </div>
        </div>
    </div>
    <!-- referral earnings -->
    <div class="col-12 col-sm-6 col-lg-3 mb-4">
        <div class="card adminuiux-card position-relative overflow-hidden bg-theme-1 h-100">
            <div class="position-absolute top-0 start-0 h-100 w-100 z-index-0 coverimg opacity-50">
                <img src="assets/img/modern-ai-image/flamingo-4.jpg" alt="">
            </div>
            <div class="card-body z-index-1">
                <div class="row gx-3 align-items-center h-100">
                    <div class="col-auto">
                        <span class="avatar avatar-60 text-bg-warning rounded">
                            <i class="bi bi-cash h4"></i>
                        </span>
                    </div>
                    <div class="col">
                        <h2>₦{{ number_format($totalEarnings, 2) }}</h2>
                        <p>Referral earning</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
<div class="row align-items-center jsutify-content-center">
    <div class="col-12 mb-4">
        <h5>Learn how it works!</h5>
    </div>
    <!-- step 1 -->
    <div class="col-12 col-sm-6 col-lg-3 mb-4">
        <i class="bi bi-link avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded h4 mb-3"></i>
        <br>
        <h6>1. Invite</h6>
        <p class="text-secondary">Invite unlimited network members by sharing referral link</p>
    </div>
    <!-- step 2 -->
    <div class="col-12 col-sm-6 col-lg-3 mb-4">
        <i class="bi bi-person avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded h4 mb-3"></i>
        <br>
        <h6>2. Registration</h6>
        <p class="text-secondary">Let your network member join our platform and start earning</p>
    </div>
    <!-- step 3 -->
    <div class="col-12 col-sm-6 col-lg-3 mb-4">
        <i class="bi bi-coin avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded h4 mb-3"></i>
        <br>
        <h6>3. Bonus Earning</h6>
        <p class="text-secondary">Earn 15% on successful completion of registration by your referring</p>
    </div>
    <!-- step 4 -->
    <div class="col-12 col-sm-6 col-lg-3 mb-4">
        <i class="bi bi-cash-stack avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded h4 mb-3"></i>
        <br>
        <h6>4. Purchase Membership</h6>
        <p class="text-secondary">Earn 15% on each task completed by your referral members in lifetime</p>
    </div>
</div>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.bootcdn.net/ajax/libs/bootbox.js/5.5.2/bootbox.min.js"></script>

<script>
$(document).ready(function() {
    $('#copy-referral-btn').on('click', function() {
        var copyText = $('#referral-link').val();

        if (navigator.clipboard) {
            navigator.clipboard.writeText(copyText).then(function() {
                bootbox.alert('Referral link copied to clipboard!');
            }, function() {
                bootbox.alert('Failed to copy referral link.');
            });
        } else {
            // Fallback for older browsers
            var input = document.getElementById('referral-link');
            input.select();
            input.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand('copy');
            bootbox.alert('Referral link copied to clipboard!');
        }
    });
});
</script>

@endsection