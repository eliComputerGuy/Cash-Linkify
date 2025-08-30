@extends('layouts.dashboard-app')

@section('content')

<div class="row">
    <!-- income expense -->
    <div class="col-12 col-md-6 col-lg-12">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card adminuiux-card mb-4">
                    <div class="card-body z-index-1">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 bg-success-subtle text-success rounded"><i class="bi bi-cash h4"></i></div>
                            </div>
                            <div class="col">
                                <h4 class="fw-medium">₦{{ number_format($approvedTotal, 2) }}</h4>
                                <p class="text-secondary">Approved Withdrawal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card adminuiux-card mb-4">
                    <div class="card-body z-index-1">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 bg-warning-subtle text-warning rounded"><i class="bi bi-cash h4"></i></div>
                            </div>
                            <div class="col">
                                <h4 class="fw-medium">₦{{ number_format($pendingTotal, 2) }}</h4>
                                <p class="text-secondary">Pending Withdrawal</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card adminuiux-card mb-4">
                    <div class="card-body z-index-1">
                        <div class="row">
                            <div class="col-auto">
                                <div class="avatar avatar-60 bg-danger-subtle text-danger rounded"><i class="bi bi-cash h4"></i></div>
                            </div>
                            <div class="col">
                                <h4 class="fw-medium">₦{{ number_format($rejectedTotal, 2) }}</h4>
                                <p class="text-secondary">Rejected Withdrawal</p>
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
                        <h6>Withdrawal History</h6>
                    </div>
                    <div class="col-auto px-0">
                        <a class="btn btn-sm btn btn-link"></a>
                    </div>
                </div>
            </div>
            <!-- recent transaction list -->
            <ul class="list-group list-group-flush border-top bg-none">
                @forelse($withdrawals as $w)
                    @php
                    $status = strtolower($w->status ?? '');

                    // pick visual styles and icons per status
                    $themeClass = '';                    // list item background accent (optional)
                    $avatarClass = 'border';             // avatar border/bg/text
                    $icon = 'bi-arrow-up-right';         // default "debit" arrow
                    $badge = 'text-bg-secondary';        // status badge color

                    if (in_array($status, ['approved','paid','completed','success','successful'])) {
                        $themeClass  = 'theme-green';
                        $avatarClass = 'border-theme-1 bg-theme-1-subtle text-theme-1';
                        $icon        = 'bi-check2-circle';
                        $badge       = 'text-bg-success';
                    } elseif (in_array($status, ['pending','processing','in_progress','queued'])) {
                        // keep neutral theme; just show hourglass icon + warning badge
                        $icon  = 'bi-hourglass-split';
                        $badge = 'text-bg-warning';
                    } elseif (in_array($status, ['rejected','failed','declined','cancelled','error'])) {
                        $themeClass  = 'theme-red';
                        $avatarClass = 'border border-danger-subtle text-danger';
                        $icon        = 'bi-x-circle';
                        $badge       = 'text-bg-danger';
                    }

                    // Build a friendly description (use your columns if you track them)
                    $descParts = ['Withdrawal Request'];
                    if (!empty($w->method))    $descParts[] = "Method: {$w->method}";
                    if (!empty($w->reference)) $descParts[] = "Ref: {$w->reference}";
                    $desc = implode(' • ', $descParts);

                    $dt = \Carbon\Carbon::parse($w->created_at);
                    @endphp

                    <li class="list-group-item {{ $themeClass }}">
                    <div class="row gx-3 align-items-center">
                        <div class="col-auto">
                        <div class="avatar avatar-40 rounded-circle {{ $avatarClass }}">
                            <i class="bi {{ $icon }} h5"></i>
                        </div>
                        </div>

                        <div class="col">
                        <p class="mb-1 fw-medium">{{ $desc }}</p>
                        <p class="text-secondary small mb-1">
                            {{ $dt->format('d/m/Y') }}
                            <span class="ms-2">{{ $dt->format('h:i A') }}</span>
                        </p>
                        <span class="badge badge-light rounded-pill {{ $badge }}">
                            {{ \Illuminate\Support\Str::headline($status ?: 'Unknown') }}
                        </span>
                        </div>

                        <div class="col-auto text-end">
                        <h6 class="text-danger mb-0">- ₦ {{ number_format((float)$w->amount, 2) }}</h6>
                        </div>
                    </div>
                    </li>
                @empty
                    <li class="list-group-item text-center">
                    <p class="text-muted mb-0">No withdrawals yet.</p>
                    </li>
                @endforelse
                </ul>

                {{-- Pagination (optional) --}}
                @if(method_exists($withdrawals, 'links'))
                <div class="mt-3">
                    {{ $withdrawals->links() }}
                </div>
                @endif
        </div>
    </div>
</div>
@endsection