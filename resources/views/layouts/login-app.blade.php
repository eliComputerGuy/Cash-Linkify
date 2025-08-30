<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="icon" type="image/png" href="{{asset('assets/img/favicon.png')}}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&amp;family=Open+Sans:ital,wght@0,300..800;1,300..800&amp;display=swap" rel="stylesheet">
    <style>
        :root {
            --adminuiux-content-font: "Open Sans", sans-serif;
            --adminuiux-content-font-weight: 400;
            --adminuiux-title-font: "Lexend", sans-serif;
            --adminuiux-title-font-weight: 600;
        }
    </style>

    <script defer src="{{asset('assets/js/app435e.js?1096aad991449c8654b2')}}"></script>
    <link href="{{asset('assets/css/app435e.css?1096aad991449c8654b2')}}" rel="stylesheet">
</head>

<body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed  theme-teal roundedui" data-theme="theme-teal" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0">
    @include('components.loader')
    
    <main class="flex-shrink-0 pt-0 h-100">
        @yield('content')
    </main>


    <script src="{{asset('assets/js/investment/investment-auth.js')}}"></script>

    @foreach (['success', 'error', 'info'] as $msg)
            @if (session($msg))
                <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 9999;">
                    <div class="toast align-items-center text-white bg-{{ $msg === 'error' ? 'danger' : ($msg === 'info' ? 'info' : 'success') }} border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                {{ session($msg) }}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var toastElList = [].slice.call(document.querySelectorAll('.toast'));
                var toastList = toastElList.map(function (toastEl) {
                    return new bootstrap.Toast(toastEl);
                });
                toastList.forEach(toast => toast.show());
            });
        </script>
        <script src="{{asset('assets/js/component/component-toasts.js')}}"></script>
</body>
</html>
