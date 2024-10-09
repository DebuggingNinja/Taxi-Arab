<div class="collapse navbar-collapse" id="navbar-menu">
    <div class="d-flex flex-column flex-md-row flex-fill align-items-stretch align-items-md-center">
        <ul class="navbar-nav">
            @can('Show.Dashboard')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('home') }}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                            <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                            <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        الرئيسية
                    </span>
                </a>
            </li>
            @endcan
            @can('List.Driver')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-steering-wheel"
                         width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                         fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                        <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path d="M12 14l0 7" />
                        <path d="M10 12l-6.75 -2" />
                        <path d="M14 12l6.75 -2" />
                    </svg>
                </span>
                    <span class="nav-link-title">
                  السائقين
                </span>
                </a>
                <div class="dropdown-menu">
                    <div class="dropdown-menu-columns">
                        <div class="dropdown-menu-column">
                            <a class="dropdown-item" href="{{ route('dashboard.drivers.index') }}">
                                عرض السائقين
                            </a>
                            <a class="dropdown-item" href="{{ route('dashboard.drivers.statuses') }}">
                                حالات السائقين
                            </a>
                        </div>
                    </div>
                </div>
            </li>
            @endcan
            @can('List.User')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.users.index') }}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        المستخدمين
                    </span>
                </a>
            </li>
            @endcan
            @can('List.CarType')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.car-types.index') }}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-car-suv" width="44"
                            height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M5 17a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M16 17a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M5 9l2 -4h7.438a2 2 0 0 1 1.94 1.515l.622 2.485h3a2 2 0 0 1 2 2v3" />
                            <path d="M10 9v-4" />
                            <path d="M2 7v4" />
                            <path
                                d="M22.001 14.001a4.992 4.992 0 0 0 -4.001 -2.001a4.992 4.992 0 0 0 -4 2h-3a4.998 4.998 0 0 0 -8.003 .003" />
                            <path d="M5 12v-3h13" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        انواع المركبات
                    </span>
                </a>
            </li>
            @endcan
            @can('List.Ride')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.rides.index') }}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-car" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                            <path d="M5 17h-2v-6l2 -5h9l4 5h1a2 2 0 0 1 2 2v4h-2m-4 0h-6m-6 -6h15m-6 0v-5" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        الرحلات
                    </span>
                </a>
            </li>
            @endcan
            @can('List.Zone')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.zones.index') }}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="icon icon-tabler icon-tabler-chart-area-line-filled" width="24" height="24"
                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M15.22 9.375a1 1 0 0 1 1.393 -.165l.094 .083l4 4a1 1 0 0 1 .284 .576l.009 .131v5a1 1 0 0 1 -.883 .993l-.117 .007h-16.022l-.11 -.009l-.11 -.02l-.107 -.034l-.105 -.046l-.1 -.059l-.094 -.07l-.06 -.055l-.072 -.082l-.064 -.089l-.054 -.096l-.016 -.035l-.04 -.103l-.027 -.106l-.015 -.108l-.004 -.11l.009 -.11l.019 -.105c.01 -.04 .022 -.077 .035 -.112l.046 -.105l.059 -.1l4 -6a1 1 0 0 1 1.165 -.39l.114 .05l3.277 1.638l3.495 -4.369z"
                                stroke-width="0" fill="currentColor" />
                            <path
                                d="M15.232 3.36a1 1 0 0 1 1.382 -.15l.093 .083l4 4a1 1 0 0 1 -1.32 1.497l-.094 -.083l-3.226 -3.225l-4.299 5.158a1 1 0 0 1 -1.1 .303l-.115 -.049l-3.254 -1.626l-2.499 3.332a1 1 0 0 1 -1.295 .269l-.105 -.069a1 1 0 0 1 -.269 -1.295l.069 -.105l3 -4a1 1 0 0 1 1.137 -.341l.11 .047l3.291 1.645l4.494 -5.391z"
                                stroke-width="0" fill="currentColor" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        المناطق
                    </span>
                </a>
            </li>
            @endcan
            @canany(['Create.Card', 'List.Card', 'Balance.Charge', 'Balance.Review'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cards" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M3.604 7.197l7.138 -3.109a.96 .96 0 0 1 1.27 .527l4.924 11.902a1 1 0 0 1 -.514 1.304l-7.137 3.109a.96 .96 0 0 1 -1.271 -.527l-4.924 -11.903a1 1 0 0 1 .514 -1.304z" />
                            <path d="M15 4h1a1 1 0 0 1 1 1v3.5" />
                            <path d="M20 6c.264 .112 .52 .217 .768 .315a1 1 0 0 1 .53 1.311l-2.298 5.374" />
                        </svg>
                    </span>
                        <span class="nav-link-title">
                           الشحن
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-columns">
                            @canany(['Create.Card', 'List.Card'])
                            <div class="dropdown-menu-column">
                                @can('Create.Card')
                                    <a class="dropdown-item" href="{{ route('dashboard.cards.create') }}">
                                        إنشاء بطاقة شحن
                                    </a>
                                @endcan
                                @can('List.Card')
                                    <a class="dropdown-item" href="{{ route('dashboard.cards.index') }}">
                                        سجلات شحن البطاقات
                                    </a>
                                @endcan
                            </div>
                            @endcanany
                            @canany(['Balance.Charge', 'Balance.Review'])
                            <div class="dropdown-menu-column">
                                @can('Balance.Charge')
                                    <a class="dropdown-item" href="{{ route('dashboard.charge.create') }}">
                                        شحن يدوي
                                    </a>
                                @endcan
                                @can('Balance.Review')
                                    <a class="dropdown-item" href="{{ route('dashboard.charges') }}">
                                        سجلات الشحن اليدوي
                                    </a>
                                @endcan
                            </div>
                            @endcanany
                        </div>
                    </div>
                </li>
            @endcanany

            @canany(['Create.DiscountCard', 'List.DiscountCard'])
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-cards" width="24"
                             height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M3.604 7.197l7.138 -3.109a.96 .96 0 0 1 1.27 .527l4.924 11.902a1 1 0 0 1 -.514 1.304l-7.137 3.109a.96 .96 0 0 1 -1.271 -.527l-4.924 -11.903a1 1 0 0 1 .514 -1.304z" />
                            <path d="M15 4h1a1 1 0 0 1 1 1v3.5" />
                            <path d="M20 6c.264 .112 .52 .217 .768 .315a1 1 0 0 1 .53 1.311l-2.298 5.374" />
                        </svg>
                    </span>
                        <span class="nav-link-title">
                      بطاقات الخصم
                    </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                @can('Create.DiscountCard')
                                    <a class="dropdown-item" href="{{ route('dashboard.discount_cards.create') }}">
                                        إنشاء بطاقة
                                    </a>
                                @endcan
                                @can('List.DiscountCard')
                                    <a class="dropdown-item" href="{{ route('dashboard.discount_cards.index') }}">
                                        سجلات الشحن
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </li>
            @endcanany

            @can('List.Notification')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.notifications.send') }}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-notification"
                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 6h-3a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-3" />
                            <path d="M17 7m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        الاشعارات
                    </span>
                </a>
            </li>
            @endcan
            @can('List.Complaint')

            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.complaints.index') }}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-message" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M8 9h8" />
                            <path d="M8 13h6" />
                            <path
                                d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        الشكاوى
                    </span>
                </a>
            </li>
            @endcan
            @can('Show.Setting')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('dashboard.configuration.show') }}">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24"
                            height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                        </svg>
                    </span>
                    <span class="nav-link-title">
                        الاعدادات
                    </span>
                </a>
            </li>
            @endcan
            @can('List.Role')
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-playlist-x"
                                 width="44" height="44" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9e9e9e" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M19 8h-14"></path>
                                <path d="M5 12h7"></path>
                                <path d="M12 16h-7"></path>
                                <path d="M16 14l4 4"></path>
                                <path d="M20 14l-4 4"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                          الادوار
                        </span>
                    </a>
                    <div class="dropdown-menu">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item" href="{{ route('dashboard.roles.index') }}">
                                    الادوار
                                </a>
                                <a class="dropdown-item" href="{{ route('dashboard.admins.index') }}">
                                    الادمن
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            @endcan
        </ul>
    </div>
</div>
