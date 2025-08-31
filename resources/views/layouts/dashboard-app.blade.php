<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Required meta tags  -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
        <meta http-equiv="x-ua-compatible" content="ie=edge">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }}</title>
        
        <link rel="icon" type="image/png" href="{{secure_url('assets/img/favicon.png')}}">

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

        <script defer src="{{ secure_url('assets/js/app.js?1096aad991449c8654b2') }}"></script>
        <link href="{{ secure_url('assets/css/app.css?1096aad991449c8654b2') }}" rel="stylesheet">
    </head>

    <body class="main-bg main-bg-opac main-bg-blur adminuiux-sidebar-fill-white adminuiux-sidebar-boxed  theme-teal roundedui" data-theme="theme-teal" data-sidebarfill="adminuiux-sidebar-fill-white" data-bs-spy="scroll" data-bs-target="#list-example" data-bs-smooth-scroll="true" tabindex="0">
        <!-- Pageloader -->
        @include('components.loader')

        @include('includes.dashboard-header')


        <!-- page wrapper -->
        <div class="adminuiux-wrap">

            @include('includes.dashboard-sidebar')

            <main class="adminuiux-content has-sidebar" onclick="contentClick()">
                <!-- body content of pages -->
                @if (!empty($breadcrumbs))
                    @include('components.breadcrumb', ['breadcrumbs' => $breadcrumbs, 'title' => $title ?? null])
                @endif
                <!-- Content  -->
                <div class="container mt-4" id="main-content">
                    @yield('content')
                </div>
            </main>

        </div>
        
        <!-- Footer -->
        @include('includes.dashboard-footer')
        
        <!-- Page Level js -->
        <script src="{{secure_url('assets/js/investment/investment-dashboard.js')}}"></script>

        <!-- Stack for page-specific scripts -->
        @stack('scripts')


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
        <script src="{{secure_url('assets/js/component/component-toasts.js')}}"></script>

        <div id="toastContainer"
            class="toast-container position-fixed top-0 end-0 p-3"
            style="z-index:1080;">
        </div>

        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
        
    </body>

</html>