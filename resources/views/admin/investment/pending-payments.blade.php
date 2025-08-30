@extends('layouts.dashboard-app')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    <i class="bi bi-clock me-2"></i>
                    Pending Payment Verifications
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($pendingInvestments->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-check-circle display-1 text-success"></i>
                        <h4 class="mt-3">No Pending Payments</h4>
                        <p class="text-muted">All payment verifications are up to date.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Package</th>
                                    <th>Amount</th>
                                    <th>Payment Proof</th>
                                    <th>Submitted</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pendingInvestments as $investment)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $investment->user->name }}</strong><br>
                                            <small class="text-muted">{{ $investment->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <strong>{{ $investment->product->name }}</strong><br>
                                        <small class="text-muted">{{ $investment->product->daily_rate }}% daily</small>
                                    </td>
                                    <td>
                                        <strong>${{ number_format($investment->amount, 2) }}</strong><br>
                                        <small class="text-muted">{{ $investment->duration_days }} days</small>
                                    </td>
                                    <td>
                                        @if($investment->payment_proof)
                                            <a href="{{ asset('storage/' . $investment->payment_proof) }}" 
                                               target="_blank" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i>
                                                View Proof
                                            </a>
                                        @else
                                            <span class="text-muted">No proof uploaded</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $investment->created_at->format('M d, Y H:i') }}<br>
                                        <small class="text-muted">{{ $investment->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-sm btn-success" 
                                                    onclick="verifyPayment({{ $investment->id }}, 'verified')">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Verify
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    onclick="verifyPayment({{ $investment->id }}, 'rejected')">
                                                <i class="bi bi-x-circle me-1"></i>
                                                Reject
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Verification Modal -->
<div class="modal fade" id="verificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Verify Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="verificationForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="notes" class="form-label">Admin Notes (Optional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3" 
                                  placeholder="Add any notes about this verification..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function verifyPayment(investmentId, status) {
    const modal = new bootstrap.Modal(document.getElementById('verificationModal'));
    const form = document.getElementById('verificationForm');
    
    // Add hidden input for status
    let statusInput = form.querySelector('input[name="status"]');
    if (!statusInput) {
        statusInput = document.createElement('input');
        statusInput.type = 'hidden';
        statusInput.name = 'status';
        form.appendChild(statusInput);
    }
    statusInput.value = status;
    
    // Set form action
    form.action = `/admin/investment/${investmentId}/verify`;
    
    // Update modal title
    const modalTitle = document.querySelector('#verificationModal .modal-title');
    modalTitle.textContent = status === 'verified' ? 'Verify Payment' : 'Reject Payment';
    
    // Update submit button
    const submitBtn = form.querySelector('button[type="submit"]');
    submitBtn.textContent = status === 'verified' ? 'Verify Payment' : 'Reject Payment';
    submitBtn.className = status === 'verified' ? 'btn btn-success' : 'btn btn-danger';
    
    modal.show();
}
</script>
@endpush
