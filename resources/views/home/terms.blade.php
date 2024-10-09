<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title> الشروط والاحكام </title>
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
    <link href="{{ asset('dist/css/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('dist/css/notyf.min.css') }}">

    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" d-flex flex-column bg-white">
    <div class="bg-cover"
         style="background-image: url({{ asset('images/admin-cover.jpg') }}); background-attachment: fixed; background-size: cover">
        <div class="row g-0 flex-fill justify-content-center">
            <div class="col-md-8">
                <div class="container bg-white mt-md-5 mb-md-5 p-3">
                    <div class="text-center mb-4">
                        <a href="." class="navbar-brand navbar-brand-autodark"><img
                                src="{{ asset('images/logo/logo-256x256.png') }}" height="70" alt=""></a>
                    </div>
                    <h2 class="h3 text-center mb-3">
                        الشروط والاحكام
                    </h2>

                    <div>
                        <br>
                    </div>

                    <div style="font-size: 14px">
                        @php
                            echo nl2br(getSetting('APP_TERMS'));
                        @endphp
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('dist/js/tabler.min.js') }}"></script>
    <script src="{{ asset('dist/js/notyf.min.js') }}"></script>
    @include('dashboard.layouts.notyf')
</body>

</html>
