@extends('dashboard.layouts.master')
@section('title','اضافة منطقه')
@section('master')
@push('jsAfterJq')
@include('dashboard.zones.components.mapStyling')
@endpush


<div class="container">
    <div id="toolbox-card" class="card">
        <div class="card-header justify-content-between m-0 py-0">
            <h3 class="card-title">الادوات</h3>
            <div class="card-actions btn-actions m-0">

                <a href="#" class="btn-action" id="toggleControlBox">
                    —
                </a>

            </div>
        </div>
        <div id="control-box" class="card-body">
            <button class="btn btn-primary" onclick="clearPolygon()">اعادة تعيين</button>
            <button class="btn btn-info" onclick="savePolygon()">حفظ المنطقه</button>
            <button class="btn btn-warning d-none" onclick="importPolygon()">استرداد منطقه</button>





        </div>
    </div>
</div>

<link href="{{ asset('dist/css/tabler-vendors.rtl.min.css') }}" rel="stylesheet" />
<div id="zone-card" class="page-body">
    <div class="container">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">انشئ منطقه جديد</h3>
                    </div>
                    <div class="card-body">
                        <form accept-charset="utf-8" action="{{ route('dashboard.zones.store') }}"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 col-form-label"> اسم المنطقه
                                    <span class="text-danger fw-bold">*</span>
                                </label>
                                <div class="col">
                                    <input type="text" class="form-control" value="{{ old('name') }}" name="name"
                                        placeholder="ادخل اسم المنطقه">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 col-form-label">مصفوفة الاحداثيات<span
                                        class="text-danger fw-bold">*</span></label>
                                <div class="col">
                                    <textarea type="text" id="polygon_array" readonly class="form-control disabled"
                                        name="polygon_array" placeholder="">{{ old('polygon_array') }}</textarea>
                                    <small class="form-hint">

                                        <strong>
                                            لا تقوم بتغيير البيانات
                                        </strong>.
                                    </small>
                                </div>
                            </div>



                            <div class="form-footer text-right">
                                <button type="submit" class="btn btn-primary">انشاء</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('jsAtBottom')
@include('dashboard.zones.components.mapScripts')
@endpush
@endsection