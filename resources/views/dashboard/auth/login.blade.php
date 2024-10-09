<html lang="en" dir="rtl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>تسجيل الدخول | لوحة التحكم
    </title>
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
    <div class="row g-0 flex-fill">
        <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
            <div class="container container-tight my-5 px-lg-5">
                <div class="text-center mb-4">
                    <a href="." class="navbar-brand navbar-brand-autodark"><img
                            src="{{ asset('images/logo/logo-256x256.png') }}" height="70" alt=""></a>
                </div>
                <h2 class="h3 text-center mb-3">
                    سجل الدخول للوحة التحكم
                </h2>
                <form action="{{ route('dashboard.login.submit') }}" method="post" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">ايميل او رقم الهاتف او اسم المستخدم:</label>
                        <input type="text" class="form-control ltr" placeholder="your@email.com" autocomplete="off"
                            name="email" value="{{ old('email') }}">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-label">
                            كلمة المرور
                        </label>
                        <div class="input-group input-group-flat">
                            <input type="password" id="password" class="form-control ltr" placeholder="كلمة المرور"
                                name="password" autocomplete="off">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"
                                    onclick='var x=document.getElementById("password"); if (x.type==="password" ) {
                                    x.type="text" ; } else { x.type="password" ; }'>
                                    <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                        <path
                                            d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" name="remember" value="1" />

                            <span class="form-check-label">تذكرني دائما في هذا الجهاز</span>
                        </label>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">تسجيل دخول</button>
                    </div>
                </form>

            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
            <!-- Photo -->
            <div class="bg-cover h-100 min-vh-100" style="background-image: url({{ asset('images/admin-cover.jpg') }})">
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
