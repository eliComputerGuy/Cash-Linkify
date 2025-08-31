@extends('layouts.dashboard-app')

@section('content')

<div class="text-center mb-4">
    <h2>Select Your Membership Package</h2>
    <p class="text-muted">Choose the level that best fits your investment plan.</p>
</div>

<div class="row">
    @forelse ($levels as $level)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card adminuiux-card mb-4">
                <div class="card-body px-xl-4">
                    <div class="row mb-4">
                        <div class="col">
                            <h4>{{ $level->name }}</h4>
                        </div>
                    </div>
                    <div class="row align-items-center mb-4">
                        <div class="col-auto">
                            <h1 class="display-6"><span class="text-secondary">₦</span>{{ number_format($level->entry_fee) }}</h1>
                        </div>
                        <div class="col">
                            <p class="text-secondary">membership fee</p>
                        </div>
                    </div>
                    <h6>Package includes:</h6>
                    <ul class="list-group adminuiux-list-group">
                        <li class="list-group-item text-secondary"><i class="bi bi-check-circle vm me-1"></i> <strong>Daily Task:</strong> {{ $level->daily_tasks }}</li>
                        <li class="list-group-item text-secondary"><i class="bi bi-check-circle vm me-1"></i> <strong>Reward Per Task:</strong> ₦{{ number_format($level->reward_per_video) }}</li>
                        <li class="list-group-item text-secondary"><i class="bi bi-check-circle vm me-1"></i> <strong>Withdrawable:</strong> ₦{{ number_format($level->max_withdrawal_weekly) }} weekly</li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <button 
                        type="button" 
                        class="btn btn-theme w-100 mt-3" 
                        data-bs-toggle="modal" 
                        data-bs-target="#paymentModal" 
                        data-level-id="{{ $level->id }}"
                        data-level-name="{{ $level->name }}"
                        data-level-price="{{ $level->entry_fee }}">
                        Select Package
                    </button>
                </div>
            </div>
        </div>
    @empty
        <p class="text-center text-muted">No membership packages available.</p>
    @endforelse
</div>


<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <form method="POST" action="{{ secure_url('/package-payment') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="level_id" id="modalLevelId">

        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Complete Your Payment</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
            <p class="mb-1"><strong>Package:</strong> <span id="modalLevelName"></span></p>
            <p><strong>Amount:</strong> ₦<span id="modalLevelPrice"></span></p>

            <hr>

            <div class="mb-3">
                <h6 class="fw-bold">Bank Transfer Details</h6>
                <ul class="list-unstyled">
                    <li><strong>Bank:</strong> Bank Name</li>
                    <li><strong>Account Name:</strong> Account Name</li>
                    <li><strong>Account Number:</strong> 1234567890</li>
                </ul>
            </div>

            <div class="alert alert-info small">
                <strong>Instructions:</strong>
                <ul class="mb-0">
                    <li>Transfer the exact amount shown above to the bank account.</li>
                    <li>Ensure you use your <strong>registered name</strong> in the payment description.</li>
                    <li>After payment, upload a clear screenshot or photo of your payment receipt below.</li>
                </ul>
            </div>

            <div class="mb-3 mt-3">
                <label for="payment_proof" class="form-label">Upload Payment Proof</label>
                <input type="file" class="form-control" name="payment_proof" id="payment_proof" required>
                <small class="text-muted">Accepted formats: JPG, JPEG, PNG (Max 2MB)</small>
            </div>

            <div class="alert alert-warning small">
                <strong>Note:</strong> Your membership will be activated after admin confirms your payment.
                This may take up to 4 hours.
            </div>
        </div>


        <div class="modal-footer">
          <button type="submit" class="btn btn-theme w-100">Submit for Verification</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
    const paymentModal = document.getElementById('paymentModal');
    paymentModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const levelId = button.getAttribute('data-level-id');
        const levelName = button.getAttribute('data-level-name');
        const levelPrice = button.getAttribute('data-level-price');

        document.getElementById('modalLevelId').value = levelId;
        document.getElementById('modalLevelName').textContent = levelName;
        document.getElementById('modalLevelPrice').textContent = Number(levelPrice).toLocaleString();
    });
</script>

@endsection