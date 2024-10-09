@extends('dashboard.layouts.createMaster')
@section('title', 'اضافة نوع مركبه جديد')
@section('tableTitle', 'نوع مركبه ')
@section('createRoute', route('dashboard.car-types.store'))

@section('formContent')
<!-- User Name -->
@component('components.dashboard.input', [
'label' => 'اسم النوع',
'name' => 'name',
'type' => 'text',
'value' => old('name'),
'is_mandatory' => true,
'placeholder' => 'اسم النوع',
'min' => 1,
'max' => 200, // Updated maximum length
'hint' => ''
])
@endcomponent

@component('components.dashboard.checkbox-input', [
'label' => 'تفعيل خاصية المرأه',
'name' => 'is_female_type',
'value' => 0,
])
@endcomponent

@component('components.dashboard.file-input', [
'label' => 'ايقونة النوع',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'icon',
'is_mandatory' => true,
'hint' => ''
])
@endcomponent
<hr>
@component('components.dashboard.input', [
'label' => 'سعر فتحه العداد',
'name' => 'setting[BASE_FARE]',
'type' => 'text',
'value' => old('setting[BASE_FARE]'),
'is_mandatory' => true,
'placeholder' => '1',
'min' => 1,
'max' => 200, // Updated maximum length
'hint' => 'سعر بدايه الرحله',
'input_class'=>'text-start'
])
@endcomponent
@component('components.dashboard.input', [
'label' => 'سعر الكيلو',
'name' => 'setting[KILOMETER_FARE]',
'type' => 'text',
'value' => old('setting[KILOMETER_FARE]'),
'is_mandatory' => true,
'placeholder' => '1',
'min' => 1,
'max' => 200, // Updated maximum length
'hint' => 'سعر الكيلو الواحد في الرحله',
'input_class'=>'text-start'
])
@endcomponent
@component('components.dashboard.input', [
'label' => 'سعر دقيقة التاخير',
'name' => 'setting[LATE_MINUTE_FARE]',
'type' => 'text',
'value' => old('setting[LATE_MINUTE_FARE]'),
'is_mandatory' => true,

'placeholder' => '1',
'min' => 1,
'max' => 200, // Updated maximum length

'hint' => '',
'input_class'=>'text-start'
])
@endcomponent
@component('components.dashboard.input', [
'label' => 'اقل سعر للرحله',
'name' => 'setting[MINIMUM_FARE]',
'type' => 'text',
'value' => old('setting[MINIMUM_FARE]'),
'is_mandatory' => true,
'placeholder' => '1',
'min' => 1,
'max' => 200, // Updated maximum length
'hint' => 'الحد الادني لسعر الرحله',
'input_class'=>'text-start'
])
@endcomponent
@endsection


@section('formButtons')
<button type="submit" class="btn btn-primary">انشاء</button>
@endsection
