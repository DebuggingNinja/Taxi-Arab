@extends('dashboard.layouts.createMaster')
@section('mode','update')
@section('title', 'تعديل سائق')
@section('tableTitle', 'سائق')

@section('createRoute', route('dashboard.drivers.update',$record->id))

@section('formContent')
@method('PATCH')
<!-- User Name -->
@component('components.dashboard.input', [
'label' => 'اسم السائق',
'name' => 'name',
'type' => 'text',
'value' => $record->name,
'is_mandatory' => true,
'placeholder' => 'اسم السائق',
'min' => 1,
'max' => 200, // Updated maximum length
'hint' => 'الاسم رباعي كما في رخصة القياده'
])
@endcomponent


@component('components.dashboard.advanced-select-input', [
'label' => 'النوع',
'name' => 'gender',
'value' => $record->gender,
'is_mandatory' => true,
'data' => [
['key'=>'Male','value'=>'ذكر'],
['key'=>'Female','value'=>'انثي']
],
'nameKey' => 'value',
'keyKey' => 'key',
'hint' => 'النوع ذكر او انثي'
])
@endcomponent
@component('components.dashboard.input', [
'label' => 'الرقم الوطني',
'name' => 'national_id',
'type' => 'text',
'value' => $record->national_id,
'is_mandatory' => true,
'placeholder' =>'10000500060070',
'min' => 1,
'max' => 20, // Updated maximum length
'hint' => 'الرقم القومي بالبطاقه'
])
@endcomponent
@component('components.dashboard.input', [
'label' => 'رقم الهاتف',
'name' => 'phone_number',
'type' => 'text',
'value' => $record->phone_number,
'is_mandatory' => true,
'placeholder' =>'+20 1554789945',
'min' => 5,
'max' => 15, // Updated maximum length
'hint' => 'رقم الهاتف الخاص بالسائق'
])
@endcomponent

@component('components.dashboard.checkbox-input', [
'label' => 'سائق متميز',
'name' => 'is_asset',
'value'=> $record->is_asset,
'hint' => 'تحديد كسائق متميز'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'سنة صنع السيارة',
'name' => 'vehicle_manufacture_date',
'type' => 'number',
'value' => $record->vehicle_manufacture_date,

'is_mandatory' => true,
'placeholder' =>'2021',
'min' => 1900,
'max' => 2100, // Updated maximum length
'hint' => 'موديل السياره بعد 2000'
])
@endcomponent
@component('components.dashboard.input', [
'label' => 'لوحة تسجيل السيارة',
'name' => 'vehicle_registration_plate',
'type' => 'text',
'value' => $record->vehicle_registration_plate,
'is_mandatory' => true,
'placeholder' => 'رقم لوحة التسجيل',
'min' => 1,
'max' => 20,
'hint' => 'رقم لوحة تسجيل السيارة'
])
@endcomponent
@component('components.dashboard.input', [
'label' => 'لون السيارة',
'name' => 'vehicle_color',
'type' => 'text',
'value' => $record->vehicle_color,
'is_mandatory' => true,
'placeholder' => 'لون السيارة',
'min' => 1,
'max' => 50,
'hint' => 'لون السيارة'
])
@endcomponent
@component('components.dashboard.input', [
'label' => 'موديل السيارة',
'name' => 'vehicle_model',
'type' => 'text',
'value' => $record->vehicle_model,
'is_mandatory' => true,
'placeholder' => 'موديل السيارة',
'min' => 1,
'max' => 50,
'hint' => 'موديل السيارة'
])
@endcomponent
@component('components.dashboard.advanced-select-input', [
'label' => 'حالة القبول',
'name' => 'acceptance_status',
'value' => $record->acceptance_status,
'is_mandatory' => true,
'data' => [
['key' => 'accepted', 'value' => 'مقبول'],
['key' => 'rejected', 'value' => 'مرفوض'],
['key' => 'pending', 'value' => 'قيد الانتظار'],
],
'nameKey' => 'value',
'keyKey' => 'key',
'hint' => 'حالة قبول السائق'
])
@endcomponent
@component('components.dashboard.multi-select-input', [
'label' => 'نوع السيارة',
'name' => 'car_types',
'value' => $record->driver_car_types?->pluck('car_type_id')->toArray(),
'is_mandatory' => true,
'data' => $carTypes, // Assuming $carTypes is an array with car type data
'nameKey' => 'name',
'keyKey' => 'id',
'hint' => 'نوع السيارة'
])
@endcomponent
@component('components.dashboard.file-input', [
'label' => 'صورة رخصة السيارة',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'vehicle_license_image',
'is_mandatory' => true,
'current'=>$record->vehicle_license_image,
'hint' => 'الصورة تكون واضحة | لو مش عايز تعدل الصورة متحطش حاجه هنا'
])
@endcomponent
@component('components.dashboard.file-input', [
'label' => 'صورة الهويه',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'personal_identification_card_image',
'is_mandatory' => true,
'current'=>$record->personal_identification_card_image,
'hint' => 'الصورة تكون واضحة | لو مش عايز تعدل الصورة متحطش حاجه هنا'
])
@endcomponent

@component('components.dashboard.file-input', [
'label' => 'صورة السيارة',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'vehicle_image',
'is_mandatory' => true,
'current'=>$record->vehicle_image,
'hint' => 'الصورة تكون واضحة | لو مش عايز تعدل الصورة متحطش حاجه هنا'
])
@endcomponent
@component('components.dashboard.file-input', [
'label' => 'شهادة عدم محكوميه',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'personal_criminal_records_certificate_image',
'is_mandatory' => true,
'current'=>$record->personal_criminal_records_certificate_image,
'hint' => 'الصورة تكون واضحة | لو مش عايز تعدل الصورة متحطش حاجه هنا'
])
@endcomponent

@component('components.dashboard.file-input', [
'label' => 'صورة رخصة القياده',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'personal_license_image',
'current'=>$record->personal_license_image,
'is_mandatory' => true,
'hint' => 'الصورة تكون واضحة | لو مش عايز تعدل الصورة متحطش حاجه هنا'
])
@endcomponent
@component('components.dashboard.file-input', [
'label' => 'صورة شخصيه',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'personal_image',
'is_mandatory' => true,
'current'=>$record->personal_image,
'hint' => 'الصورة تكون واضحة | لو مش عايز تعدل الصورة متحطش حاجه هنا'
])
@endcomponent
@endsection

@section('formButtons')
<button type="submit" class="btn btn-primary">تعديل</button>
@endsection
