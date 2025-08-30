@extends('layouts.dashboard-app')

@section('content')

@php
  $txPrefix = 'L_';  // change if you like
  $padLen   = 3;      // 5-digit numeric part => LFT00001
@endphp

<!-- appointment grid view list datatable-->
<div class="card adminuiux-card mt-4 mb-0">
    <div class="card-body">
        <!-- data table -->
        <table id="dataTable" class="table w-100 nowrap">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date and Time</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @forelse($transactions as $row)
                    <tr>
                    {{-- Serial number --}}
                    <td>{{ $txPrefix . str_pad($loop->iteration, $padLen, '0', STR_PAD_LEFT) }}</td>

                    {{-- Date + Time --}}
                    <td>
                        <p class="mb-0">{{ \Carbon\Carbon::parse($row->happened_at)->format('d-m-Y') }}</p>
                        <p class="text-secondary small">{{ \Carbon\Carbon::parse($row->happened_at)->format('h:i A') }}</p>
                    </td>

                    {{-- Description --}}
                    <td>{{ $row->description }}</td>

                    {{-- Amount with + / - by direction --}}
                    <td>
                        @if($row->direction === 'credit')
                        <h6 class="text-theme-1">+ ₦ {{ number_format($row->amount, 2) }}</h6>
                        @else
                        <h6 class="text-danger">- ₦ {{ number_format($row->amount, 2) }}</h6>
                        @endif
                    </td>

                    {{-- Status badge --}}
                    <td>
                        @php
                        $status = strtolower($row->status_raw);
                        $badge  = 'text-bg-secondary';
                        if (in_array($status, ['completed','paid','approved','success','successful'])) $badge = 'text-bg-success';
                        elseif (in_array($status, ['pending','in_progress','processing'])) $badge = 'text-bg-warning';
                        elseif (in_array($status, ['failed','declined','rejected','error'])) $badge = 'text-bg-danger';
                        @endphp
                        <span class="badge badge-light rounded-pill {{ $badge }}">{{ $row->status }}</span>
                    </td>
                    </tr>
                @empty
                    <tr>
                    <td colspan="5" class="text-center text-muted py-4">No transactions yet.</td>
                    </tr>
                @endforelse
                </tbody>
        </table>
    </div>
</div>

@endsection