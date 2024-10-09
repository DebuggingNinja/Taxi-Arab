@extends('dashboard.layouts.createMaster')
@section('mode', 'show')

@section('title', 'بيانات الرحله')
@section('tableTitle', 'الرحلة')
@section('createRoute', '')

@section('formContent')

<!-- User ID -->
@component('components.dashboard.input', [
'label' => 'المستخدم',
'name' => 'user_id',
'type' => 'text',
'value' => $record->user?->name,
'is_mandatory' => false,
'placeholder' => 'معرف المستخدم',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true,
'url'=>route('dashboard.users.show',$record->user_id)
])
@endcomponent

<!-- Trip Cancelled At -->
@component('components.dashboard.input', [
'label' => 'إستلام النقدية',
'name' => 'is_paid',
'type' => 'text', // Change the type if needed
'value' => $record->is_paid ? "نعم" : "لا",
'is_mandatory' => false,
'placeholder' => '',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Trip Cancelled At -->
@component('components.dashboard.input', [
'label' => 'تفعيل بطاقة خصم',
'name' => 'discount_enabled',
'type' => 'text', // Change the type if needed
'value' => $record->discount_enabled ? "نعم" : "لا",
'is_mandatory' => false,
'placeholder' => '',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Trip Cancelled At -->
@component('components.dashboard.input', [
'label' => 'السعر قبل الخصم',
'name' => 'price_before_discount',
'type' => 'text', // Change the type if needed
'value' => $record->discount_enabled ? $record->price_before_discount : "لم يتم التفعيل",
'is_mandatory' => false,
'placeholder' => '',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Driver ID -->
@component('components.dashboard.input', [
'label' => 'السائق',
'name' => 'driver_id',
'type' => 'text',
'value' => $record->driver?->name ?? '-',
'is_mandatory' => false,
'placeholder' => '',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true,
'url'=>$record->driver?->id != null ? route('dashboard.drivers.show',$record->driver_id):'#'
])
@endcomponent

<!-- Driver Distance from Pickup -->
@component('components.dashboard.input', [
'label' => 'مسافة السائق من مكان الاتقاء',
'name' => 'driver_distance_from_pickup',
'type' => 'text',
'value' => $record->driver_distance_from_pickup,
'is_mandatory' => false,
'placeholder' => 'المسافة من مكان الالتقاط للسائق',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Expected Distance -->
@component('components.dashboard.input', [
'label' => 'المسافة المتوقعة',
'name' => 'expected_distance',
'type' => 'text',
'value' => $record->expected_distance,
'is_mandatory' => false,
'placeholder' => 'المسافة المتوقعة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent
<hr>
<!-- Pickup Location Name -->
@component('components.dashboard.input', [
'label' => 'اسم مكان الالتقاء',
'name' => 'pickup_location_name',
'type' => 'text',
'value' => $record->pickup_location_name,
'is_mandatory' => false,
'placeholder' => 'اسم مكان الالتقاط',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent
<!-- Pickup Location ID -->
@component('components.dashboard.input', [
'label' => 'نقطه الالتقاء',
'name' => 'pickup_location_id',
'type' => 'text',
'value' => $record->_pickup_location?->latitude.",".$record->_pickup_location?->latitude,
'is_mandatory' => false,
'placeholder' => 'معرف مكان الالتقاط',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true,
'url'=>"https://www.google.com/maps?q=".$record->_pickup_location?->latitude.",".$record->_pickup_location?->latitude
])
@endcomponent


<hr>

<!-- Dropoff Location Name -->
@component('components.dashboard.input', [
'label' => 'اسم مكان الوصول',
'name' => 'dropoff_location_name',
'type' => 'text',
'value' => $record->dropoff_location_name,
'is_mandatory' => false,
'placeholder' => 'اسم مكان التسليم',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent
<!-- Dropoff Location ID -->
@component('components.dashboard.input', [
'label' => 'نقطه الوصول',
'name' => 'dropoff_location_id',
'type' => 'text',
'value' => $record->_dropoff_location?->latitude.",".$record->_dropoff_location?->latitude,
'is_mandatory' => false,
'placeholder' => 'معرف مكان التسليم',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true,
'url'=>"https://www.google.com/maps?q=".$record->_dropoff_location?->latitude.",".$record->_dropoff_location?->latitude
])
@endcomponent


<hr>
<!-- Actual Distance -->
@component('components.dashboard.input', [
'label' => 'المسافة الفعلية',
'name' => 'actual_distance',
'type' => 'text',
'value' => $record->actual_distance,
'is_mandatory' => false,
'placeholder' => 'المسافة الفعلية',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Actual Ride Duration -->
@component('components.dashboard.input', [
'label' => 'مدة الرحلة الفعلية',
'name' => 'actual_ride_duration',
'type' => 'text',
'value' => $record->actual_ride_duration,
'is_mandatory' => false,
'placeholder' => 'مدة الرحلة الفعلية',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Actual Total Fare -->
@component('components.dashboard.input', [
'label' => 'الأجرة الإجمالية الفعلية',
'name' => 'actual_total_fare',
'type' => 'text',
'value' => $record->actual_total_fare,
'is_mandatory' => false,
'placeholder' => 'الأجرة الإجمالية الفعلية',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Actual Driver Fare -->
@component('components.dashboard.input', [
'label' => 'أجرة السائق الفعلية',
'name' => 'actual_driver_fare',
'type' => 'text',
'value' => $record->actual_driver_fare,
'is_mandatory' => false,
'placeholder' => 'أجرة السائق الفعلية',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Actual App Fare -->
@component('components.dashboard.input', [
'label' => 'أجرة التطبيق الفعلية',
'name' => 'actual_app_fare',
'type' => 'text',
'value' => $record->actual_app_fare,
'is_mandatory' => false,
'placeholder' => 'أجرة التطبيق الفعلية',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<hr>

<!-- Expected Ride Duration -->
@component('components.dashboard.input', [
'label' => 'مدة الرحلة المتوقعة',
'name' => 'expected_ride_duration',
'type' => 'text',
'value' => $record->expected_ride_duration,
'is_mandatory' => false,
'placeholder' => 'مدة الرحلة المتوقعة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Expected Total Fare -->
@component('components.dashboard.input', [
'label' => 'الأجرة الإجمالية المتوقعة',
'name' => 'expected_total_fare',
'type' => 'text',
'value' => $record->expected_total_fare,
'is_mandatory' => false,
'placeholder' => 'الأجرة الإجمالية المتوقعة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Expected Driver Fare -->
@component('components.dashboard.input', [
'label' => 'أجرة السائق المتوقعة',
'name' => 'expected_driver_fare',
'type' => 'text',
'value' => $record->expected_driver_fare,
'is_mandatory' => false,
'placeholder' => 'أجرة السائق المتوقعة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Expected App Fare -->
@component('components.dashboard.input', [
'label' => 'أجرة التطبيق المتوقعة',
'name' => 'expected_app_fare',
'type' => 'text',
'value' => $record->expected_app_fare,
'is_mandatory' => false,
'placeholder' => 'أجرة التطبيق المتوقعة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent
<hr>



<!-- Driver Pickup Location ID -->
@component('components.dashboard.input', [
'label' => 'مكان انتظار السائق',
'name' => 'driver_pickup_location_id',
'type' => 'text',
'value' => $record->driver_pickup_location?->latitude.",".$record->driver_pickup_location?->latitude,
'is_mandatory' => false,
'placeholder' => 'معرف مكان انتظار السائق',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true,
'url'=>"https://www.google.com/maps?q=".$record->driver_pickup_location?->latitude.",".$record->driver_pickup_location?->latitude

])
@endcomponent

<!-- Car Type ID -->
@component('components.dashboard.input', [
'label' => 'نوع السيارة',
'name' => 'car_type_id',
'type' => 'text',
'value' => $record->car_type?->name,
'is_mandatory' => false,
'placeholder' => 'معرف نوع السيارة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true,
'url'=>'#'//route('not_ready')
])
@endcomponent

<!-- Trip Type -->
@component('components.dashboard.input', [
'label' => 'نوع الرحلة',
'name' => 'type',
'type' => 'text',
'value' => $record->type == 'All'?'ذكر/انثي':'إناث',
'is_mandatory' => false,
'placeholder' => 'نوع الرحلة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Trip Status -->
@component('components.dashboard.input', [
'label' => 'حالة الرحلة',
'name' => 'status',
'type' => 'text',
'value' => $record->status,
'is_mandatory' => false,
'placeholder' => 'حالة الرحلة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent
<hr>
<!-- Trip Accepted At -->
@component('components.dashboard.input', [
'label' => 'تاريخ قبول الرحلة',
'name' => 'accepted_at',
'type' => 'text', // Change the type if needed
'value' => $record->accepted_at,
'is_mandatory' => false,
'placeholder' => 'تاريخ قبول الرحلة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent
<!-- Driver Pickup At -->
@component('components.dashboard.input', [
'label' => 'تاريخ وصول السائق الي نقطه التجمع',
'name' => 'driver_pickup_at',
'type' => 'text',
'value' => $record->driver_pickup_at,
'is_mandatory' => false,
'placeholder' => 'توقيت انتظار السائق',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent
<!-- Trip Started At -->
@component('components.dashboard.input', [
'label' => 'تاريخ بدء الرحلة',
'name' => 'started_at',
'type' => 'text', // Change the type if needed
'value' => $record->started_at,
'is_mandatory' => false,
'placeholder' => 'تاريخ بدء الرحلة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Trip Completed At -->
@component('components.dashboard.input', [
'label' => 'تاريخ انتهاء الرحلة',
'name' => 'completed_at',
'type' => 'text', // Change the type if needed
'value' => $record->completed_at,
'is_mandatory' => false,
'placeholder' => 'تاريخ انتهاء الرحلة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

<!-- Trip Cancelled At -->
@component('components.dashboard.input', [
'label' => 'تاريخ إلغاء الرحلة',
'name' => 'cancelled_at',
'type' => 'text', // Change the type if needed
'value' => $record->cancelled_at,
'is_mandatory' => false,
'placeholder' => 'تاريخ إلغاء الرحلة',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent
@if($record->ride_trackings && !$record->ride_trackings->isEmpty())
    @component('components.dashboard.buttons.button-with-properties', [
        'properties' => 'data-bs-toggle="modal" data-bs-target="#show-ride-tracking-modal"',
        'route' => '#',
        'cssClass' => 'btn-primary',
        'disabled' => false,
        'text' => 'عرض بيانات التتبع'
    ]) @endcomponent
    @component('components.dashboard.modals.table-modal',[
    'modal_id'=>'show-ride-tracking-modal',
    'primary_button_text'=>'عرض بيانات التتبع',
    'close_button_text'=>'اغلق',
    'title'=>'بيانات التتبع للرحلة',
    'table_head'=> [
        'الرقم',
        'الوقت',
        'السرعة',
        'الحالة',
    ],
    'table_body' => $record->ride_trackings->map(fn($tracking, $index) => [
            $index + 1,
            $tracking->timestamp->format('H:i:s'),
            $tracking->speed,
            $tracking->is_pre_ride ?
                  'قبل الرحلة' :
                   'أثناء الرحلة'
        ])->toArray()
    ])
    @endcomponent
@endif
@endsection

@section('formButtons')

@endsection
