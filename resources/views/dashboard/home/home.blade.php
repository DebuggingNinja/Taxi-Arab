@extends('dashboard.layouts.master')
@section('title','الرئيسية')
@section('master')
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-fluid">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        لوحة التحكم
                    </h2>
                    <div class="page-pretitle">
                        نظرة عامة
                    </div>
                </div>
                <div class="col text-end">
                    <a class="btn btn-dark" href="{{ route('home.refresh') }}">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-reload"
                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747">
                                </path>
                                <path d="M20 4v5h-5"></path>
                            </svg>
                        </div>
                        <span id="cache_timer">--:--:--</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-fluid">
            <div class="row row-deck row-cards">
                <div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">رحلات اليوم</div>
                                <div class="ms-auto lh-1">

                                    <a class=" text-muted" aria-expanded="false">اليوم</a>
                                </div>
                            </div>
                            <div class="h1 mb-3">{{ number_format( $dashboardData['ridesCounts']['today_rides'] )}} رحلة
                            </div>
                            <div class="d-flex mb-2">
                                <div>نسبة من الاجمالي</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        {{
                                        getRatio($dashboardData['ridesCounts']['today_rides'],$dashboardData['ridesCounts']['total_rides'])
                                        ?? 0
                                        }}%

                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width:    {{
                                    getRatio($dashboardData['ridesCounts']['today_rides'],$dashboardData['ridesCounts']['total_rides'])
                                    ?? 0
                                    }}%" role="progressbar" aria-valuenow="  {{
                                        getRatio($dashboardData['ridesCounts']['today_rides'],$dashboardData['ridesCounts']['total_rides'])
                                        ?? 0
                                        }}" aria-valuemin="0" aria-valuemax="100" aria-label="   {{
                                            getRatio($dashboardData['ridesCounts']['today_rides'],$dashboardData['ridesCounts']['total_rides'])
                                            ?? 0
                                            }}%">
                                    <span class="visually-hidden"> {{
                                        getRatio($dashboardData['ridesCounts']['today_rides'],$dashboardData['ridesCounts']['total_rides'])
                                        ?? 0
                                        }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">اجمالي الرحلات</div>
                                <div class="ms-auto lh-1">

                                    <a class=" text-muted" aria-expanded="false">كل الاوقات</a>
                                </div>
                            </div>
                            <div class="h1 mb-3"> {{number_format( $dashboardData['ridesCounts']['total_rides'] )}}
                            </div>
                            <div class="d-flex mb-2">
                                <div>نسبه الرحلات المكتمله</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        {{
                                        getRatio($dashboardData['ridesCounts']['completed_rides'],$dashboardData['ridesCounts']['total_rides'])??0
                                        }}%

                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: {{
                                    getRatio($dashboardData['ridesCounts']['completed_rides'],$dashboardData['ridesCounts']['total_rides'])??0
                                    }}%" role="progressbar" aria-valuenow="{{
                                        getRatio($dashboardData['ridesCounts']['completed_rides'],$dashboardData['ridesCounts']['total_rides'])??0
                                        }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{
                                        getRatio($dashboardData['ridesCounts']['completed_rides'],$dashboardData['ridesCounts']['total_rides'])??0
                                        }}%">
                                    <span class="visually-hidden">{{
                                        getRatio($dashboardData['ridesCounts']['completed_rides'],$dashboardData['ridesCounts']['total_rides'])??0
                                        }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">عدد المستخدمين</div>
                                <div class="ms-auto lh-1">

                                    <a class=" text-muted" aria-expanded="false">كل الاوقات</a>
                                </div>
                            </div>
                            <div class="h1 mb-3">{{number_format( $dashboardData['usersCounts']['total_users'] )}}
                                مستخدم</div>
                            <div class="d-flex mb-2">
                                <div>المستخدمين الغير مفعلين</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        {{getRatio($dashboardData['usersCounts']['inactive_users'],$dashboardData['usersCounts']['total_users'])
                                        }}%

                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: {{getRatio($dashboardData['usersCounts']['inactive_users'],$dashboardData['usersCounts']['total_users'])
                            }}%" role="progressbar" aria-valuenow="{{getRatio($dashboardData['usersCounts']['inactive_users'],$dashboardData['usersCounts']['total_users'])
                                }}" aria-valuemin="0" aria-valuemax="100" aria-label="{{getRatio($dashboardData['usersCounts']['inactive_users'],$dashboardData['usersCounts']['total_users'])
                            }}%">
                                    <span
                                        class="visually-hidden">{{getRatio($dashboardData['usersCounts']['inactive_users'],$dashboardData['usersCounts']['total_users'])
                                        }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">عدد السائقين</div>
                                <div class="ms-auto lh-1">

                                    <a class=" text-muted" aria-expanded="false">كل الاوقات</a>
                                </div>
                            </div>
                            <div class="h1 mb-3">{{number_format( $dashboardData['driversCounts']['total_drivers'] )}}
                                سائق</div>
                            <div class="d-flex mb-2">
                                <div>نسبه المقبولين</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        {{getRatio( $dashboardData['driversCounts']['accepted_drivers'] ,
                                        $dashboardData['driversCounts']['total_drivers'] )}}%

                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: {{getRatio(
                                    $dashboardData['driversCounts']['accepted_drivers'] ,
                                    $dashboardData['driversCounts']['total_drivers'] )}}%" role="progressbar"
                                    aria-valuenow="{{getRatio( $dashboardData['driversCounts']['accepted_drivers'] ,
                                    $dashboardData['driversCounts']['total_drivers'] )}}" aria-valuemin="0"
                                    aria-valuemax="100" aria-label="{{getRatio( $dashboardData['driversCounts']['accepted_drivers'] ,
                                    $dashboardData['driversCounts']['total_drivers'] )}}%">
                                    <span class="visually-hidden">{{getRatio(
                                        $dashboardData['driversCounts']['accepted_drivers'] ,
                                        $dashboardData['driversCounts']['total_drivers'] )}}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">عدد الشكاوى</div>
                                <div class="ms-auto lh-1">

                                    <a class=" text-muted" aria-expanded="false">كل الاوقات</a>
                                </div>
                            </div>
                            <div class="h1 mb-3"> {{number_format(
                                $dashboardData['complaintsCounts']['total_complaints'] )}} شكوى</div>
                            <div class="d-flex mb-2">
                                <div>نسبه المحلول منها</div>
                                <div class="ms-auto">
                                    <span class="text-green d-inline-flex align-items-center lh-1">
                                        {{getRatio(
                                        $dashboardData['complaintsCounts']['solved_complaints'],$dashboardData['complaintsCounts']['total_complaints']
                                        )}}%

                                    </span>
                                </div>
                            </div>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-primary" style="width: {{getRatio(
                                    $dashboardData['complaintsCounts']['solved_complaints'],$dashboardData['complaintsCounts']['total_complaints']
                                    )}}%" role="progressbar" aria-valuenow="{{getRatio(
                                        $dashboardData['complaintsCounts']['solved_complaints'],$dashboardData['complaintsCounts']['total_complaints']
                                        )}}" aria-valuemin="0" aria-valuemax="100" aria-label="{{getRatio(
                                            $dashboardData['complaintsCounts']['solved_complaints'],$dashboardData['complaintsCounts']['total_complaints']
                                            )}}%">
                                    <span class="visually-hidden">{{getRatio(
                                        $dashboardData['complaintsCounts']['solved_complaints'],$dashboardData['complaintsCounts']['total_complaints']
                                        ) }}%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="subheader">عدد المناطق</div>
                                <div class="ms-auto lh-1">

                                    <a class=" text-muted" aria-expanded="false">كل الاوقات</a>
                                </div>
                            </div>
                            <div class="h1 mb-3">{{number_format( $dashboardData['zoneStatus']['total_zones'] )}} منطقه
                            </div>
                            <div class="d-flex mb-2">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="row row-cards my-3 justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">اختصارات</h3>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-lg-4 col-sm-6 col-md-6 col-4 py-3">
                                    <a href="#" class="text-black text-decoration-none">
                                        <div class=" text-center">
                                            <img style="max-width:35px; height:auto;"
                                                class="avatar avatar-xl mb-1 bg-white shadow-none"
                                                src="{{ asset('images/icons/house.png') }}">
                                            <h3 class="m-0 mb-1  h4">الرئيسية</h3>
                                        </div>
                                    </a>
                                </div>
                                @can('List.Driver')
                                <div class="col-lg-4 col-sm-6  col-md-6 col-4 py-3">
                                    <a href="{{ route('dashboard.drivers.index') }}"
                                        class="text-black text-decoration-none">
                                        <div class="  text-center">
                                            <img style="max-width:35px; height:auto;"
                                                class="avatar avatar-xl mb-1 bg-white shadow-none"
                                                src="{{ asset('images/icons/driver.png') }}">
                                            <h3 class="m-0 mb-1  h4">السائقين</h3>
                                        </div>
                                    </a>
                                </div>
                                @endcan @can('List.User')
                                <div class="col-lg-4 col-sm-6  col-md-6 col-4 py-3">
                                    <a href="{{ route('dashboard.users.index') }}"
                                        class="text-black text-decoration-none">
                                        <div class="  text-center">
                                            <img style="max-width:35px; height:auto;"
                                                class="avatar avatar-xl mb-1 bg-white shadow-none"
                                                src="{{ asset('images/icons/man.png') }}">
                                            <h3 class="m-0 mb-1  h4">المستخدمين</h3>
                                        </div>
                                    </a>
                                </div>
                                @endcan @can('List.Ride')
                                <div class="col-lg-4 col-sm-6  col-md-6 col-4 py-3">
                                    <a href="{{ route('dashboard.rides.index') }}"
                                        class="text-black text-decoration-none">
                                        <div class="  text-center">
                                            <img style="max-width:35px; height:auto;"
                                                class="avatar avatar-xl mb-1 bg-white shadow-none"
                                                src="{{ asset('images/icons/taxi.png') }}">
                                            <h3 class="m-0 mb-1  h4">الرحلات</h3>
                                        </div>
                                    </a>
                                </div>
                                @endcan @can('List.Role')
                                <div class="col-lg-4 col-sm-6  col-md-6 col-4 py-3">
                                    <a href="{{ route('dashboard.roles.index') }}"
                                        class="text-black text-decoration-none">
                                        <div class="  text-center">
                                            <img style="max-width:35px; height:auto;"
                                                class="avatar avatar-xl mb-1 bg-white shadow-none"
                                                src="{{ asset('images/icons/partners.png') }}">
                                            <h3 class="m-0 mb-1  h4">الادوار</h3>
                                        </div>
                                    </a>
                                </div>
                                @endcan @can('List.Notification')
                                <div class="col-lg-4 col-sm-6  col-md-6 col-4 py-3">
                                    <a href="{{ route('dashboard.notifications.send') }}"
                                        class="text-black text-decoration-none">
                                        <div class="  text-center">
                                            <img style="max-width:35px; height:auto;"
                                                class="avatar avatar-xl mb-1 bg-white shadow-none"
                                                src="{{ asset('images/icons/notification.png') }}">
                                            <h3 class="m-0 mb-1  h4">الاشعارات</h3>
                                        </div>
                                    </a>
                                </div>
                                @endcan @can('Create.Card')
                                <div class="col-lg-4 col-sm-6  col-md-6 col-4 py-3">
                                    <a href="{{ route('dashboard.cards.create') }}"
                                        class="text-black text-decoration-none">
                                        <div class="  text-center">
                                            <img style="max-width:35px; height:auto;"
                                                class="avatar avatar-xl mb-1 bg-white shadow-none"
                                                src="{{ asset('images/icons/card.png') }}">
                                            <h3 class="m-0 mb-1  h4">الكروت</h3>
                                        </div>
                                    </a>
                                </div>
                                @endcan @can('List.Complaint')
                                <div class="col-lg-4 col-sm-6  col-md-6 col-4 py-3">
                                    <a href="{{ route('dashboard.complaints.index') }}"
                                        class="text-black text-decoration-none">
                                        <div class="  text-center">
                                            <img style="max-width:35px; height:auto;"
                                                class="avatar avatar-xl mb-1 bg-white shadow-none"
                                                src="{{ asset('images/icons/contact.png') }}">
                                            <h3 class="m-0 mb-1  h4">الشكاوي</h3>
                                        </div>
                                    </a>
                                </div>
                                @endcan @can('Show.Setting')
                                <div class="col-lg-4 col-sm-6  col-md-6 col-4 py-3">
                                    <a href="{{ route('dashboard.configuration.show') }}"
                                        class="text-black text-decoration-none">
                                        <div class="  text-center">
                                            <img style="max-width:35px; height:auto;"
                                                class="avatar avatar-xl mb-1 bg-white shadow-none"
                                                src="{{ asset('images/icons/settings.png') }}">
                                            <h3 class="m-0 mb-1  h4">الاعدادات</h3>
                                        </div>
                                    </a>
                                </div>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">اكثر السائقين للرحلات</h3>
                            <table class="table table-sm table-borderless">
                                <thead>
                                    <tr>
                                        <th>اسم السائق</th>
                                        <th class="text-end">الرحلات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dashboardData['topDrivers'] as $record)
                                    <tr>
                                        <td>
                                            <div class="progressbg">
                                                <div class="progress progressbg-progress">
                                                    <div class="progress-bar bg-primary-lt"
                                                        style="width: {{ $record['ratio'] }}%" role="progressbar"
                                                        aria-valuenow="{{ $record['ratio'] }}" aria-valuemin="0"
                                                        aria-valuemax="100" aria-label="{{ $record['ratio'] }}%">
                                                        <span class="visually-hidden">{{ $record['ratio'] }}%</span>
                                                    </div>
                                                </div>
                                                <div class="progressbg-text">{{ $record['name'] }}</div>
                                            </div>
                                        </td>
                                        <td class="w-1 fw-bold text-end">{{ $record['rides_count'] }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">اكثر المستخدمين للرحلات</h3>
                            <table class="table table-sm table-borderless">
                                <thead>
                                    <tr>
                                        <th>اسم المستخدم</th>
                                        <th class="text-end">الرحلات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dashboardData['topUsers'] as $record)
                                    <tr>
                                        <td>
                                            <div class="progressbg">
                                                <div class="progress progressbg-progress">
                                                    <div class="progress-bar bg-primary-lt"
                                                        style="width: {{ $record['ratio'] }}%" role="progressbar"
                                                        aria-valuenow="{{ $record['ratio'] }}" aria-valuemin="0"
                                                        aria-valuemax="100" aria-label="{{ $record['ratio'] }}%">
                                                        <span class="visually-hidden">{{ $record['ratio'] }}%</span>
                                                    </div>
                                                </div>
                                                <div class="progressbg-text">{{ $record['name'] }}</div>
                                            </div>
                                        </td>
                                        <td class="w-1 fw-bold text-end">{{ $record['rides_count'] }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">اكثر السائقين (الذكور) للرحلات</h3>
                            <table class="table table-sm table-borderless">
                                <thead>
                                <tr>
                                    <th>اسم السائق</th>
                                    <th class="text-end">الرحلات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($dashboardData['topMaleDrivers'] as $record)
                                    <tr>
                                        <td>
                                            <div class="progressbg">
                                                <div class="progress progressbg-progress">
                                                    <div class="progress-bar bg-primary-lt"
                                                         style="width: {{ $record['ratio'] }}%" role="progressbar"
                                                         aria-valuenow="{{ $record['ratio'] }}" aria-valuemin="0"
                                                         aria-valuemax="100" aria-label="{{ $record['ratio'] }}%">
                                                        <span class="visually-hidden">{{ $record['ratio'] }}%</span>
                                                    </div>
                                                </div>
                                                <div class="progressbg-text">{{ $record['name'] }}</div>
                                            </div>
                                        </td>
                                        <td class="w-1 fw-bold text-end">{{ $record['rides_count'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">اكثر السائقين (الإناث) للرحلات</h3>
                            <table class="table table-sm table-borderless">
                                <thead>
                                <tr>
                                    <th>اسم السائقة</th>
                                    <th class="text-end">الرحلات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($dashboardData['topFemaleDrivers'] as $record)
                                    <tr>
                                        <td>
                                            <div class="progressbg">
                                                <div class="progress progressbg-progress">
                                                    <div class="progress-bar bg-primary-lt"
                                                         style="width: {{ $record['ratio'] }}%" role="progressbar"
                                                         aria-valuenow="{{ $record['ratio'] }}" aria-valuemin="0"
                                                         aria-valuemax="100" aria-label="{{ $record['ratio'] }}%">
                                                        <span class="visually-hidden">{{ $record['ratio'] }}%</span>
                                                    </div>
                                                </div>
                                                <div class="progressbg-text">{{ $record['name'] }}</div>
                                            </div>
                                        </td>
                                        <td class="w-1 fw-bold text-end">{{ $record['rides_count'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        // Calculate the remaining time until cache expiration
        var cacheExpiresAt = new Date('{{ $cacheExpiresAt }}').getTime();
        var now = new Date('{{ now() }}').getTime();
        // Update the countdown timer every second
        var x = setInterval(function() {
            now = now + 1000; // Convert seconds to milliseconds

            var distance = cacheExpiresAt - now;

            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
            var seconds = Math.floor((distance % (1000 * 60)) / 1000).toString().padStart(2, '0');


            // Display the remaining time in the 'cache_timer' span
            document.getElementById('cache_timer').innerHTML = hours + ':' + minutes + ':' + seconds;

            // If the countdown is over, display a message or take some action
            if (distance < 0) {
                clearInterval(x);
                document.getElementById('cache_timer').innerHTML = 'EXPIRED';
            }
        }, 1000);
    </script>




    @endsection
