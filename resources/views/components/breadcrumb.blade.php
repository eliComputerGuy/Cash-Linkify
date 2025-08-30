<!-- breadcrumb -->
<div class="container-fluid mt-4">
    <div class="row gx-3 align-items-center">
        <div class="col-12 col-sm">
            <nav aria-label="breadcrumb" class="mb-2">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item bi"><a href="{{ route('dashboard') }}">Dashboard</a></li>

                    @foreach ($breadcrumbs as $label => $url)
                        @if ($loop->last)
                            <li class="breadcrumb-item active bi" aria-current="page">{{ $label }}</li>
                        @else
                            <li class="breadcrumb-item bi"><a href="{{ $url }}">{{ $label }}</a></li>
                        @endif
                    @endforeach
                </ol>
            </nav>
            <h5>{{ $title ?? $breadcrumbs[array_key_last($breadcrumbs)] ?? 'Page' }}</h5>
        </div>
    </div>
</div>
