@extends('dashboard.layouts.master')
@section('title', 'عرض بيانات السائق')
@section('master')
<style>
    /* Custom CSS to remove border on click */
    .form-control:focus {
        border-color: none;
        box-shadow: none;
    }
</style>
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">عرض بيانات السائق</h3>
                    </div>
                    <div class="card-body py-3 d-flex justify-content-between row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'اسم السائق',
                            'name' => 'name',
                            'type' => 'text',
                            'value' => $driver->name,
                            'input_class' => 'border-0 ',
                            'is_mandatory' => false,
                            'readonly' => true,
                            'placeholder' => 'اسم السائق',
                            'min' => 1,
                            'max' => 200, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'النوع',
                            'name' => 'gender',
                            'type' => 'text',
                            'value' => $driver->gender,
                            'is_mandatory' => false,
                            'readonly' => true,
                            'input_class' => 'border-0',
                            'placeholder' =>'',
                            'min' => 1,
                            'max' => 20, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'تاريخ الانضمام',
                            'type' => 'text',
                            'name' => 'created_at',
                            'value' => $driver->created_at->format('Y-m-d'),
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'hint' => '',
                            'placeholder' => '',
                            'min' => 1,
                            'max' => 50, 'readonly' => true,
                            ])
                            @endcomponent
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'الرقم الوطني',
                            'name' => 'national_id',
                            'type' => 'text',
                            'value' => $driver->national_id,
                            'is_mandatory' => false,
                            'readonly' => true,
                            'input_class' => 'border-0',
                            'placeholder' =>'10000500060070',
                            'min' => 1,
                            'max' => 20, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'رقم الهاتف',
                            'name' => 'phone_number',
                            'type' => 'text',
                            'value' => $driver->phone_number,
                            'is_mandatory' => false,
                            'readonly' => true,
                            'input_class' => 'border-0 lrt',
                            'placeholder' =>'+20 1554789945',
                            'min' => 5,
                            'max' => 15, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'سنة صنع السيارة',
                            'name' => 'vehicle_manufacture_date',
                            'type' => 'number',
                            'value' => $driver->vehicle_manufacture_date,
                            'is_mandatory' => false,
                            'readonly' => true,
                            'input_class' => 'border-0 rtl',
                            'placeholder' =>'2021',
                            'min' => 2000,
                            'max' => 2100, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'لوحة تسجيل السيارة',
                            'name' => 'vehicle_registration_plate',
                            'type' => 'text',
                            'value' => $driver->vehicle_registration_plate,
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'placeholder' => 'رقم لوحة التسجيل',
                            'min' => 1,
                            'max' => 20, 'readonly' => true,
                            'hint' => ''

                            ])
                            @endcomponent

                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'لون السيارة',
                            'name' => 'vehicle_color',
                            'type' => 'text',
                            'value' => $driver->vehicle_color,
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'placeholder' => 'لون السيارة',
                            'min' => 1,
                            'max' => 50, 'readonly' => true,
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'موديل السيارة',
                            'name' => 'vehicle_model',
                            'type' => 'text',
                            'value' => $driver->vehicle_model,
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'placeholder' => 'موديل السيارة',
                            'min' => 1,
                            'max' => 50, 'readonly' => true,
                            'hint' => ''
                            ])
                            @endcomponent

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'حالة القبول',
                            'type' => 'text',
                            'name' => 'acceptance_status',
                            'value' => $driver->acceptance_status,
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'hint' => '',
                            'placeholder' => '',
                            'min' => 1,
                            'max' => 50, 'readonly' => true,
                            ])
                            @endcomponent
                            @if($driver->acceptance_status == 'pending')
                            <div class="d-flex">
                                @component('components.dashboard.buttons.button', [
                                'form' => true,
                                'route' => route('dashboard.drivers.acceptance',$driver->id),
                                'method' => 'POST',
                                'cssClass' => 'btn-success',
                                'text' => 'قبول',
                                'dataArray' => ['method' => 'accept']
                                ]) @endcomponent

                                @component('components.dashboard.buttons.button', [
                                'form' => true,
                                'route' => route('dashboard.drivers.acceptance',$driver->id),
                                'method' => 'POST',
                                'cssClass' => 'btn-instagram me-4',
                                'text' => 'رفض',
                                'dataArray' => ['method' => 'reject']
                                ]) @endcomponent
                            </div>
                            @endif
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'عدد الرحلات',
                            'name' => 'vehicle_model',
                            'type' => 'text',
                            'value' => $rides,
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'placeholder' => 'عدد الرحلات',
                            'min' => 1,
                            'max' => 50, 'readonly' => true,
                            'hint' => ''
                            ])
                            @endcomponent

                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'عدد الرحلات المقبولة',
                            'name' => 'vehicle_model',
                            'type' => 'text',
                            'value' => $accepted,
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'placeholder' => 'عدد الرحلات المقبولة',
                            'min' => 1,
                            'max' => 50, 'readonly' => true,
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'عدد الرحلات الملغية',
                            'name' => 'vehicle_model',
                            'type' => 'text',
                            'value' => $cancelled,
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'placeholder' => 'عدد الرحلات الملغية',
                            'min' => 1,
                            'max' => 50, 'readonly' => true,
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'نسبة القبول',
                            'name' => 'vehicle_model',
                            'type' => 'text',
                            'value' => ($accepted ? $accepted / ($rides / 100) : 0) . "%",
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'placeholder' => 'نسبة القبول',
                            'min' => 1,
                            'max' => 50, 'readonly' => true,
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'الرصيد الحالى',
                            'name' => 'current_balance',
                            'type' => 'text',
                            'value' => $driver->current_credit_amount,
                            'input_class' => 'border-0 rtl',
                            'is_mandatory' => false,
                            'placeholder' => '',
                            'min' => 1,
                            'max' => 50, 'readonly' => true,
                            'hint' => ''
                            ])
                            @endcomponent
                            @component('components.dashboard.modals.input-modal',[
                                'button_text'=>'إضافة رصيد',
                                'input_name'=>'balance',
                                'submit_route'=> route('dashboard.drivers.chargeBalance', $driver),
                                'save_button_text'=>'إضافة للرصيد',
                                'close_button_text'=>'اغلق',
                                'title'=>'إضافة رصيد للمستخدم'
                            ])
                            @endcomponent
                        </div>

                    </div>
                    <div class="card-body py-3 d-flex justify-content-between row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            @component('components.dashboard.images.image-card-with-title',
                            [
                            'title' => 'بطاقه الرقم الوطني',
                            'image_url' =>
                            Storage::url($driver->personal_identification_card_image) ,
                            'url' =>
                            Storage::url($driver->personal_identification_card_image) ,
                            ])

                            @endcomponent
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            @component('components.dashboard.images.image-card-with-title',
                            [
                            'title' => 'شهادة عدم محكوميه',
                            'createdAt' => '23/12/2023 04:51 PM',
                            'image_url' =>
                            Storage::url($driver->personal_criminal_records_certificate_image) ,
                            'url' =>
                            Storage::url($driver->personal_criminal_records_certificate_image) ,
                            ])

                            @endcomponent
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            @component('components.dashboard.images.image-card-with-title',
                            [
                            'title' => 'صورة السيارة',
                            'createdAt' => '23/12/2023 01:46 PM',
                            'image_url' =>
                            Storage::url($driver->vehicle_image) ,
                            'url' =>
                            Storage::url($driver->vehicle_image) ,
                            ])

                            @endcomponent
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            @component('components.dashboard.images.image-card-with-title',
                            [
                            'title' => 'رخصة قيادة',
                            'createdAt' => '23/12/2023 01:46 PM',
                            'image_url' =>
                            Storage::url($driver->personal_license_image) ,
                            'url' =>
                            Storage::url($driver->personal_license_image) ,
                            ])

                            @endcomponent
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            @component('components.dashboard.images.image-card-with-title',
                            [
                            'title' => 'صورة شخصيه',
                            'createdAt' => '23/12/2023 01:46 PM',
                            'image_url' =>
                            Storage::url($driver->personal_image) ,
                            'url' =>
                            Storage::url($driver->personal_image) ,
                            ])

                            @endcomponent
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            @component('components.dashboard.images.image-card-with-title',
                            [
                            'title' => 'رخصة السياره',
                            'createdAt' => '23/12/2023 01:46 PM',

                            'image_url' =>
                            Storage::url($driver->vehicle_license_image) ,
                            'url' =>
                            Storage::url($driver->vehicle_license_image) ,
                            ])

                            @endcomponent
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
