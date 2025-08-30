@extends('layouts.dashboard-app')

@section('content')

<div class="row">
    <!-- balance -->
    <div class="col-12 col-md-6 col-lg-4 mb-4">
        <div class="card adminuiux-card bg-theme-1">
            <div class="card-body z-index-1">
                <div class="row gx-2 align-items-center mb-4">
                    <div class="col-auto py-1">
                        <div class="avatar avatar-60 bg-white-opacity rounded"><i class="bi bi-wallet h2"></i></div>
                    </div>
                    <div class="col px-0">

                    </div>
                    <div class="col-auto py-2">
                        
                    </div>
                    <div class="col-auto py-2">
                        <a class="btn btn-lg btn-square btn-outline-light" data-bs-toggle="modal" data-bs-target="#withdrawmoneymodal" title="Withdraw Money"> &nbsp; &nbsp; Withdraw &nbsp; &nbsp;</a>
                    </div>
                </div>
                <h1>₦{{ number_format($totalWalletBalance, 2) }}</h1>
                <h5 class="opacity-75 fw-normal mb-1">Total balance</h5>
            </div>
        </div>
    </div>

    <!-- income expense -->
    <div class="col-12 col-md-6 col-lg-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-12">
                <div class="card adminuiux-card mb-4">
                    <div class="card-body z-index-1">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 bg-success-subtle text-success rounded"><i class="bi bi-cash h4"></i></div>
                            </div>
                            <div class="col">
                                <h4 class="fw-medium">₦{{ number_format($taskIncomeToday, 2) }}</h4>
                                <p class="text-secondary">Task Income Today</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-12">
                <div class="card adminuiux-card mb-4">
                    <div class="card-body z-index-1">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 bg-warning-subtle text-warning rounded"><i class="bi bi-cash h4"></i></div>
                            </div>
                            <div class="col">
                                <h4 class="fw-medium">₦{{ number_format($taskIncomeThisWeek, 2) }}</h4>
                                <p class="text-secondary">Task Income this Week</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- investment -->
    <div class="col-12 col-md-12 col-lg-4">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card adminuiux-card mb-4">
                    <div class="card-body z-index-1">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 bg-info-subtle text-info rounded"><i class="bi bi-cash h4"></i></div>
                            </div>
                            <div class="col">
                                <h4 class="fw-medium">₦{{ number_format($taskIncomeThisMonth, 2) }}</h4>
                                <p class="text-secondary">Task Income this Month</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-12">
                <div class="card adminuiux-card mb-4">
                    <div class="card-body z-index-1">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 bg-theme-1-subtle text-theme-1 rounded"><i class="bi bi-cash h4"></i></div>
                            </div>
                            <div class="col">
                                <h4 class="fw-medium">₦{{ number_format($allTaskIncome, 2) }}</h4>
                                <p class="text-secondary">All Task Income</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- recent transaction -->
    <div class="col-12 col-md-6 col-lg-12 mb-4">
        <div class="card adminuiux-card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h6>Recent Transaction</h6>
                    </div>
                    <div class="col-auto px-0">
                        <a href="{{ route('my.transactions') }}" class="btn btn-sm btn btn-link">See All</a>
                    </div>
                </div>
            </div>
            <!-- recent transaction list -->
            <ul class="list-group list-group-flush border-top bg-none">
                @forelse($recentTransactions as $tx)
                <li class="list-group-item {{ $tx['direction'] === 'credit' ? 'theme-green' : '' }}">
                    <div class="row gx-3 align-items-center">
                        <div class="col-auto">
                        <div class="avatar avatar-40 rounded-circle border {{ $tx['direction']==='credit' ? 'border-theme-1 bg-theme-1-subtle text-theme-1' : '' }}">
                            <i class="bi {{ $tx['icon'] }} h5"></i>
                        </div>
                        </div>
                        <div class="col">
                        <p class="mb-1 fw-medium">{{ $tx['title'] }}</p>
                        <p class="text-secondary small">{{ \Carbon\Carbon::parse($tx['date'])->format('d F Y, h:i A') }}</p>
                        <!-- @if(!empty($tx['subtitle'])) <p class="text-secondary small">{{ $tx['subtitle'] }}</p> @endif -->
                        </div>
                        <div class="col-auto">
                        @if($tx['direction'] === 'credit')
                            <h6 class="{{ $tx['class'] }}">+ ₦ {{ number_format($tx['amount'], 2) }}</h6>
                        @else
                            <h6 class="text-danger mb-0">- ₦ {{ number_format($tx['amount'], 2) }}</h6>
                        @endif
                        </div>
                    </div>
                </li>
                @empty
                    <li class="list-group-item text-center">
                        <div class="row mb-4 mt-4"><p class="text-muted">No recent transactions.</p></div>
                    </li>
                @endforelse
                
            </ul>
        </div>
    </div>
</div>


<!-- withdraw money modal -->
<div class="modal adminuiux-modal fade" id="withdrawmoneymodal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title h5">Withdraw Money</p>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="withdrawForm">
        <div class="modal-body">
          <div class="form-floating mb-4">
                <input
                    type="text"
                    class="form-control"
                    id="withdrawContact"
                    name="contact"
                    placeholder="Enter contact..."
                    value="{{ $bankContactString }}"
                    {{ $bankOk ? 'readonly' : 'disabled' }}
                    required
                >
                <label for="withdrawContact">Withdraw money to</label>
            </div>

                @if(!$bankOk)
                <div class="alert alert-warning d-flex align-items-start" role="alert">
                    <i class="bi bi-exclamation-triangle me-2 mt-1"></i>
                    <div>
                    <strong>Bank details required.</strong><br>
                    Please update your bank information (Account Name, Account Number, Bank) in your profile before requesting a withdrawal.
                    @if(Route::has('profile.edit'))
                        <div class="mt-1">
                        <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-link p-0">Go to Profile</a>
                        </div>
                    @endif
                    </div>
                </div>
                @endif

          <input type="number" step="0.01" min="0" class="form-control form-control-lg text-center mb-3"
                 id="withdrawAmount" name="amount" placeholder="Amount..." required>

          <div class="text-center">
            <h5 class="fw-normal"><b class="fw-bold">Great!</b> You are about to withdraw</h5>
            <h1 class="mb-0 text-theme-1">₦ <span id="withdrawPreviewAmount">0.00</span></h1>
          </div>

          <div class="text-center mt-2 text-secondary small">
            Minimum withdrawal for your level: <strong>₦ {{ number_format($minWithdrawalForUser, 2) }}</strong>
            </div>

          <div id="withdrawLowBalanceAlert"
               class="alert alert-danger alert-dismissible fade show mt-4 d-none" role="alert">
            <strong><i class="bi bi-exclamation-triangle me-1"></i> Low balance!</strong><br>
            <small>Your wallet account does not have enough money to send. Kindly add money or choose a different wallet account.</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
            <button id="withdrawSubmitBtn" class="btn btn-theme" type="submit" {{ $bankOk ? '' : 'disabled' }}>
                Withdraw Money
            </button>
          <button type="button" class="btn btn-link mx-2 theme-red" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- expose balance to JS --}}
<script>
  window.WALLET_BALANCE = @json($totalWalletBalance ?? auth()->user()->wallet_balance);
  window.BANK_OK = @json($bankOk);
  window.MIN_WITHDRAWAL   = @json($minWithdrawalForUser);
</script>







<script>
(function(){
  const amountInput   = document.getElementById('withdrawAmount');
  const contactInput  = document.getElementById('withdrawContact');
  const previewAmount = document.getElementById('withdrawPreviewAmount');
  const alertBox      = document.getElementById('withdrawLowBalanceAlert');
  const form          = document.getElementById('withdrawForm');
  const submitBtn     = document.getElementById('withdrawSubmitBtn');

  const fmt = (n) => (Number(n||0)).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
  const toast = (msg, type='info') => (typeof showToast === 'function' ? showToast(msg, type) : alert(msg));

  function setAlert(visible) {
    alertBox.classList.toggle('d-none', !visible);
  }

  function validateAmount() {
    const amt = parseFloat(amountInput.value || '0');
    const balance = parseFloat(window.WALLET_BALANCE || '0');

    previewAmount.textContent = fmt(amt);

    // Show alert and block when amount >= balance (your requirement)
    const bad = (amt >= balance) || (amt <= 0) || Number.isNaN(amt);
    setAlert(bad);
    return !bad;
  }

  amountInput.addEventListener('input', validateAmount);

  form.addEventListener('submit', function(e){
    e.preventDefault();

    if (!validateAmount()) {
      toast('❌ Low balance or invalid amount.', 'danger');
      return;
    }

    if (!window.BANK_OK) {
        (typeof showToast === 'function' ? showToast('❌ Please add your bank details first.', 'danger') : alert('Please add your bank details first.'));
        return;
    }

    // Build payload
    const payload = {
      contact: contactInput.value.trim(),
      amount:  parseFloat(amountInput.value || '0'),
    };

    if (!payload.contact) {
      toast('Please enter a contact / destination.', 'warning');
      return;
    }

    // Submit
    submitBtn.disabled = true;
    submitBtn.innerText = 'Sending...';

    fetch('{{ route('withdrawals.store') }}', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
      },
      body: JSON.stringify(payload)
    })
    .then(async (res) => {
      let data = null;
      try { data = await res.json(); } catch(e) {}
      if (!res.ok) {
        const msg = (data && (data.message || data.error)) || `HTTP ${res.status}`;
        throw new Error(msg);
      }
      return data;
    })
    .then((data) => {
      // close modal
      const modalEl = document.getElementById('withdrawmoneymodal');
        const instance = bootstrap?.Modal?.getOrCreateInstance(modalEl);
        instance && instance.hide();

        // update in-memory balance & any visible balance text
        if (typeof data.new_balance !== 'undefined') {
            window.WALLET_BALANCE = parseFloat(data.new_balance);

            // if you show balance somewhere, update it (adjust selector to your DOM)
            const balEl = document.querySelector('[data-wallet-balance]');
            if (balEl) balEl.textContent = window.WALLET_BALANCE.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
        }

      toast('✅ Withdrawal request submitted.', 'success');

      // Optionally refresh the page or list, or update WALLET_BALANCE if you reserve funds server-side.
      location.reload();
    })
    .catch((err) => {
      console.error('Withdraw submit failed:', err);
      toast(`❌ Could not submit withdrawal: ${err.message}`, 'danger');
    })
    .finally(() => {
      submitBtn.disabled = false;
      submitBtn.innerText = 'Send Money';
    });
  });

  // Initialize preview on open
  document.getElementById('withdrawmoneymodal')
    ?.addEventListener('shown.bs.modal', () => {
      validateAmount();
      amountInput?.focus();
    });
})();
</script>


@endsection