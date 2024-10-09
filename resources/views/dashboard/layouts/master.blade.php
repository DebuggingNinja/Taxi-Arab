<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - لوحة التحكم</title>

    <!--Icon-->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/favico/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favico/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favico/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('images/favico/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('images/favico/safari-pinned-tab.svg') }}" color="#d9ae54">
    <meta name="msapplication-TileColor" content="#d9ae54">
    <meta name="theme-color" content="#d9ae54">

    <!-- CSS files -->

    <link href="{{ asset('dist/css/tabler.rtl.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/css/notyf.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/custom.css') }}">
    @stack('css')
    <!-- JS -->

    <!-- JQ -->
    <script src="{{ asset('dist/js/jquery-3.6.3.min.js') }}"></script>
    @stack('jsAfterJq')
</head>


<body class="theme-light">
    <div class="page">
        <header class="navbar navbar-expand-md navbar-light d-print-none">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <a href="#">
                        <img src="{{ asset('images/logo/logo-128x128.png') }}" width="110" height="32" alt="لوحة التحكم"
                            class="navbar-brand-image">
                    </a>
                </h1>
                @include('dashboard.layouts.menu')
                <div class="navbar-nav flex-row order-md-last">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                style="background-image: url('https://www.w3schools.com/howto/img_avatar.png')"></span>
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ auth()?->user()?->name }}</div>
                                <div class="mt-1 small text-muted">{{ auth()->user()?->roles?->first()?->name }}</div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow  px-2">
                            <form class="pt-1 pb-1 mb-0" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();this.closest('form').submit();" class="text-danger "
                                    class="dropdown-item">تسجيل الخروج</a>
                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </header>

        <div class="page-wrapper">
            @yield('master')
        </div>
    </div>


    <!-- Tabler Extra Libs -->
    @hasSection('lib')
    @include('dashboard.layouts.libs')
    @endif
    <!-- Tabler Core -->
    <script src="{{ asset('dist/js/tabler.min.js') }}"></script>
    <script src="{{ asset('dist/js/notyf.min.js') }}"></script>
    @stack('jsAtBottom')
    @include('dashboard.layouts.notyf')
    <script>
        function confirmDelete(){
            return confirm("Are you sure you want to delete this?");
        }
        function confirmRestore(){
            return confirm("Are you sure you want to Restore this?");
        }
    </script>
</body>

</html>