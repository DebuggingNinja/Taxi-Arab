@extends('dashboard.layouts.master')
@section('title','الاعدادات')
@section('master')
<div class="page-wrapper">
    <script src="https://cdn.tiny.cloud/1/y2u5jj6xi0vwy5nz8c4oo7oa75vyiqpird0407inyl1m5362/tinymce/6/tinymce.min.js">
    </script>
    <link href="{{ asset('dist/css/tabler-vendors.rtl.min.css') }}" rel="stylesheet" />
    <div class="page-body">
        <div class="container-fluid">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">صفحة الاعدادات</h3>
                        </div>
                        <div class="card">
                            <div class="row g-0">
                                <form action="{{ route('dashboard.configuration.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="col-12  d-flex flex-column">
                                        <div class="card-body">
                                            <h2 class="mb-4">اعدادات عامه</h2>
                                            <h3 class="card-title mt-4 fw-bold">تسعير الرحلات</h3>
                                            <div class="row g-3">
                                                <div class="col-md">
                                                    <div class="form-label">غرامة الغاء الرحله</div>
                                                    <input type="text" class="text-start form-control my-3"
                                                        name="CANCELLATION_FEES"
                                                        value="{{ getSetting('CANCELLATION_FEES') }}">
                                                </div>
                                                <div class="col-md">
                                                    <div class="form-label">عامل وقت الذروه (اذا وضعتها ب 2 اذا السعر في
                                                        هذا
                                                        الوقت 200%)</div>
                                                    <input type="text" class="text-start form-control my-3"
                                                        name="RUSH_HOUR_MULTIPLIER"
                                                        value="{{ getSetting('RUSH_HOUR_MULTIPLIER') }}">
                                                </div>
                                            </div>
                                            <div class="row g-3">

                                                <div class="col-md">
                                                    <div class="form-label">اقل رصيد للسائق ليستطيع قبول رحلات</div>
                                                    <input type="text" class="text-start form-control my-3"
                                                        name="MINIMUM_CREDIT_TO_ACCEPT_RIDE"
                                                        value="{{ getSetting('MINIMUM_CREDIT_TO_ACCEPT_RIDE') }}">
                                                </div>
                                                <div class="col-md">
                                                    <div class="form-label">نسبة التطبيق من الرحلات</div>
                                                    <input type="text" class="text-start form-control my-3"
                                                        name="APP_TAX_PERCENTAGE"
                                                        value="{{ getSetting('APP_TAX_PERCENTAGE') * 100 }}">
                                                </div>
                                            </div>
                                            <div class="row g-3">

                                                <div class="col-md">
                                                    <div class="form-label">الرصيد الترحيبى للسائقين</div>
                                                    <input type="text" class="text-start form-control my-3"
                                                        name="DRIVER_INIT_BALANCE"
                                                        value="{{ getSetting('DRIVER_INIT_BALANCE') }}">
                                                </div>
                                            </div>
                                            <hr>
                                            <h3 class="card-title mt-4 fw-bold">اعدادات المستخدمين</h3>

                                            <div class="row g-3">
                                                <div class="col-md">
                                                    <div class="form-label">اقصي مدى بحث المستخدم عن سائقين بالكيلومتر
                                                    </div>
                                                    <input type="text" class="text-start form-control my-3"
                                                        name="DRIVER_SEARCH_RADIUS"
                                                        value="{{ getSetting('DRIVER_SEARCH_RADIUS') }}">
                                                </div>
                                                <div class="col-md">
                                                    <div class="form-label">الفاصل الزمني بالثانيه لاعاده البحث عن
                                                        سائقين في
                                                        حاله عدم
                                                        وجود اي سائق في المدي المحدد</div>
                                                    <input type="number" class="text-start form-control my-3"
                                                        name="DRIVER_SEARCH_RETRY_INTERVAL_SECONDS"
                                                        value="{{ getSetting('DRIVER_SEARCH_RETRY_INTERVAL_SECONDS') }}">
                                                </div>

                                                <div class="row g-3">

                                                    <div class="col-md">
                                                        <div class="form-label">الرصيد الترحيبى للمستخدمين</div>
                                                        <input type="text" class="text-start form-control my-3"
                                                               name="USER_INIT_BALANCE"
                                                               value="{{ getSetting('USER_INIT_BALANCE') }}">
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="form-label">نسبة الخصم من الرصيد الترحيبى</div>
                                                        <input type="text" class="text-start form-control my-3"
                                                               name="DISCOUNT_FROM_BALANCE"
                                                               value="{{ getSetting('DISCOUNT_FROM_BALANCE') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md">
                                                    <div class="form-label">الحد الاقصي لعدد العناوين المسجله للمستخدم
                                                        الواحد</div>
                                                    <input type="number" class="text-start form-control my-3"
                                                        name="MAX_ADDRESSES_LIMIT"
                                                        value="{{ getSetting('MAX_ADDRESSES_LIMIT') }}">
                                                </div>

                                            </div>

                                            <hr>
                                            <h3 class="card-title mt-4 fw-bold">نظام المكافئات</h3>
                                            <div class="row g-3">
                                                <div class="col-md">
                                                    <div class="form-label">مقابل كل دينار يتم دفعه يستطيع المستخدم
                                                        استرداد
                                                        نقاط
                                                        مقدارها</div>
                                                    <input type="number" class="text-start form-control my-3"
                                                        name="REWARD_POINT_RATIO"
                                                        value="{{ getSetting('REWARD_POINT_RATIO') }}">
                                                </div>

                                                <div class="col-md">
                                                    <div class="form-label"> الحد الادني لتحويل النقاط الي رصيد
                                                    </div>
                                                    <input type="number" class="text-start form-control my-3"
                                                        name="REWARD_MIN" value="{{ getSetting('REWARD_MIN') }}">
                                                </div>

                                            </div>
                                            <hr>
                                            <h3 class="card-title mt-4 fw-bold">اعدادات السائقين </h3>

                                            <div>
                                                <div class="row g-2">
                                                    <div class="form-label"> تسعير تعويض السائق الذي يبعد اكثر من 2 كيلو
                                                        من
                                                        المستخدم
                                                    </div>
                                                    <input type="text" class="text-start form-control my-3"
                                                        name="DRIVER_COMPANSATION_FOR_MORE_THAN_2KM"
                                                        value="{{ getSetting('DRIVER_COMPANSATION_FOR_MORE_THAN_2KM') }}">

                                                </div>
                                            </div>
                                            <div class="row g-3 mt-2">
                                                <div class="col-md">
                                                    <div class="form-label">
                                                        احتساب دقائق التاخير عندما يكون السائق علي السرعه
                                                        التاليه فما اقل (كيلو متر بالساعه) </div>
                                                    <input type="number" class="text-start form-control my-3"
                                                        name="MINIMUM_SPEED_FOR_DELAY_CALCULATION"
                                                        value="{{ getSetting('MINIMUM_SPEED_FOR_DELAY_CALCULATION') }}">
                                                </div>
                                                <div class="col-md">
                                                    <div class="form-label">المده بالثواني التي يستطيع فيها السائق قبول
                                                        الرحله</div>
                                                    <input type="number" class="text-start form-control my-3"
                                                        name="INVITE_EXPIRY_TIMEOUT"
                                                        value="{{ getSetting('INVITE_EXPIRY_TIMEOUT') }}">
                                                </div>
                                                <div class="col-md">
                                                    <div class="form-check form-switch">
                                                        <label class="form-check-label" for="AUTO_PICK_DRIVER">توزيع تلقائى للرحلات على السائقين حسب المسافة</label>
                                                        <input type="checkbox" id="AUTO_PICK_DRIVER" class="text-start form-check-input my-3"
                                                            name="AUTO_PICK_DRIVER" {{ getSetting('AUTO_PICK_DRIVER') ? "checked" : "" }}>
                                                    </div>
                                                </div>

                                                <div class="col-md">
                                                    <div class="form-check form-switch">
                                                        <label class="form-check-label" for="ACTIVATE_ASSET_DRIVER">تفعيل خاصية الكابتن المميز</label>
                                                        <input type="checkbox" id="ACTIVATE_ASSET_DRIVER" class="text-start form-check-input my-3"
                                                            name="ACTIVATE_ASSET_DRIVER" {{ getSetting('ACTIVATE_ASSET_DRIVER') ? "checked" : "" }}>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row g-3 mt-2">

                                                <div class="col-md">
                                                    <div class="form-check form-switch">
                                                        <label class="form-check-label" for="ALLOW_PANEL_CHARGE">تفعيل خاصية الشحن اليدوي</label>
                                                        <input type="checkbox" id="ALLOW_PANEL_CHARGE" class="text-start form-check-input my-3"
                                                            name="ALLOW_PANEL_CHARGE" {{ getSetting('ALLOW_PANEL_CHARGE') ? "checked" : "" }}>
                                                    </div>
                                                </div>

                                                <div class="col-md">
                                                    <div class="form-label"> الحد الاقصى للشحن (الشحن اليدوي)
                                                    </div>
                                                    <input type="number" class="text-start form-control my-3"
                                                           name="MAX_CHARGE_LIMIT" value="{{ getSetting('MAX_CHARGE_LIMIT') }}">
                                                </div>

                                            </div>

                                            <h3 class="card-title mt-4 fw-bold">نغمه تنبيه عند وصول الطلب</h3>
                                            <div class="row g-3">
                                                <div class="col-md">
                                                    <div class="form-label">
                                                        نغمه التنبيه للسائقين
                                                    </div>
                                                    @php($d_ringtone = getSetting('DRIVERS_RINGTONE'))
                                                    @if($d_ringtone && str_contains($d_ringtone, '.mp3'))
                                                        <audio controls>
                                                            <source src="{{asset('storage/' . $d_ringtone)}}" type="audio/mpeg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    @endif
                                                    <input type="file" class="form-control my-3 "
                                                        name="DRIVERS_RINGTONE" accept="audio/mp3">
                                                </div>

                                                <div class="col-md">
                                                    <div class="form-label">
                                                        نغمه التنبيه للمستخدمين
                                                    </div>
                                                    @php($ringtone = getSetting('USERS_RINGTONE'))
                                                    @if($ringtone && str_contains($ringtone, '.mp3'))
                                                        <audio controls>
                                                            <source src="{{asset('storage/' . $ringtone)}}" type="audio/mpeg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    @endif
                                                    <input type="file" class="form-control my-3" name="USERS_RINGTONE"
                                                        accept="audio/mp3">
                                                </div>

                                            </div>

                                            <h3 class="card-title mt-4 fw-bold">إعدادات الدعم الفنى</h3>
                                            <div class="row g-3">
                                                <div class="col-md">
                                                    <div class="form-label">
                                                        البريد الالكترونى
                                                    </div>
                                                    <input type="email" class="form-control my-3"
                                                        name="SUPPORT_EMAIL" value="{{ getSetting('SUPPORT_EMAIL') }}">
                                                </div>

                                                <div class="col-md">
                                                    <div class="form-label">
                                                        رقم الهاتف
                                                    </div>
                                                    <input type="text" class="form-control my-3" name="SUPPORT_PHONE"
                                                        value="{{ getSetting('SUPPORT_PHONE') }}">
                                                </div>

                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md">
                                                    <div class="form-label">
                                                        الشروط والاحكام
                                                    </div>
                                                    <textarea class="form-control my-3" rows="15"
                                                              name="APP_TERMS">{{getSetting('APP_TERMS')}}</textarea>
                                                </div>

                                            </div>

                                        </div>
                                        <div class="card-footer bg-transparent mt-auto">
                                            <div class="btn-list justify-content-end">

                                                <button type="submit" class="btn btn-primary">
                                                    حفظ
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
