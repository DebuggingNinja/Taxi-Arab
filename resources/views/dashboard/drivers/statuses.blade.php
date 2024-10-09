@extends('dashboard.layouts.master')
@section('title','حالات السائقين')
@section('master')
    <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
            <div class="container-fluid">
                <div class="row g-2 align-items-center">
                    <div class="col">
                        <h2 class="page-title">
                            السائقين
                        </h2>
                        <div class="page-pretitle">
                            نظرة عامة
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
            <div class="container-fluid">
                <div class="row row-deck row-cards">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-success text-white">
                                في رحلة حاليا
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>السائق</th>
                                            <th>رقم الرحلة</th>
                                            <th>حالة الرحلة</th>
                                            <th>عرض</th>
                                        </tr>
                                        </thead>
                                        <tbody
                                            class="riding-ajax-loader"
                                            data-route="{{route('dashboard.rides.index')}}"
                                            data-url="{{route('dashboard.drivers.api.inRide')}}"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                متاح فى إنتظار رحلة
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>السائق</th>
                                            <th>النوع</th>
                                            <th>رقم الهاتف</th>
                                            <th>عرض</th>
                                        </tr>
                                        </thead>
                                        <tbody
                                            class="active-ajax-loader"
                                            data-route="{{route('dashboard.drivers.index')}}"
                                            data-url="{{route('dashboard.drivers.api.lookingForRide')}}"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                غير متاح
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-2">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>السائق</th>
                                            <th>النوع</th>
                                            <th>رقم الهاتف</th>
                                            <th>عرض</th>
                                        </tr>
                                        </thead>
                                        <tbody
                                            class="offline-ajax-loader"
                                            data-route="{{route('dashboard.drivers.index')}}"
                                            data-url="{{route('dashboard.drivers.api.offline')}}"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="module" src="{{ asset("js/ajax-loader.js") }}?ver={{date('z')}}"></script>
@endsection
