@extends('dashboard.layouts.createMaster')
@section('mode','update') {{-- Added 'mode' for differentiation --}}
@section('title', 'تعديل نوع مركبة')
@section('tableTitle', 'نوع مركبة')

@section('createRoute', route('dashboard.car-types.update', $record->id))

@section('formContent')
@method('PATCH')
<!-- User Name -->
@component('components.dashboard.input', [
'label' => 'اسم النوع',
'name' => 'name',
'type' => 'text',
'value' => $record->name,
'is_mandatory' => true,
'placeholder' => 'اسم النوع',
'min' => 1,
'max' => 200,
'hint' => ''
])
@endcomponent

@component('components.dashboard.checkbox-input', [
'label' => 'تفعيل خاصية المرأه',
'name' => 'is_female_type',
'value' => $record->is_female_type,
])
@endcomponent

@component('components.dashboard.file-input', [
'label' => 'ايقونة النوع',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'icon',
'is_mandatory' => true,
'current' => $record->icon, {{-- Added current attribute --}}
'hint' => ''
])
@endcomponent

<hr>

@component('components.dashboard.input', [
'label' => 'سعر فتحة العداد',
'name' => 'setting[BASE_FARE]',
'type' => 'text',
'value' => $record->settings->where('key_name','BASE_FARE')->first()?->value,
'is_mandatory' => true,
'placeholder' => '1',
'min' => 1,
'max' => 200,
'hint' => 'سعر بداية الرحلة',
'input_class' => 'text-start'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'سعر الكيلو',
'name' => 'setting[KILOMETER_FARE]',
'type' => 'text',
'value' => $record->settings->where('key_name','KILOMETER_FARE')->first()?->value,
'is_mandatory' => true,
'placeholder' => '1',
'min' => 1,
'max' => 200,
'hint' => 'سعر الكيلو الواحد في الرحلة',
'input_class' => 'text-start'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'سعر دقيقة التأخير',
'name' => 'setting[LATE_MINUTE_FARE]',
'type' => 'text',
'value' => $record->settings->where('key_name','LATE_MINUTE_FARE')->first()?->value,
'is_mandatory' => true,
'placeholder' => '1',
'min' => 1,
'max' => 200,
'hint' => '',
'input_class' => 'text-start'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'اقل سعر للرحلة',
'name' => 'setting[MINIMUM_FARE]',
'type' => 'text',
'value' => $record->settings->where('key_name','MINIMUM_FARE')->first()?->value,
'is_mandatory' => true,
'placeholder' => '1',
'min' => 1,
'max' => 200,
'hint' => 'الحد الأدنى لسعر الرحلة',
'input_class' => 'text-start'
])
@endcomponent

@endsection

@section('formButtons')
<button type="submit" class="btn btn-primary">تحديث</button> {{-- Updated button text --}}
@endsection
