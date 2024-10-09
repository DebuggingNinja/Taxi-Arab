@extends('dashboard.layouts.createMaster')
@section('mode', 'show')

@section('title', 'بيانات نوع المركبة')
@section('tableTitle', 'نوع المركبة')
@section('createRoute', '')

@section('formContent')

<!-- Name -->
@component('components.dashboard.input', [
'label' => 'اسم النوع',
'name' => 'name',
'type' => 'text',
'value' => $record->name,
'is_mandatory' => false,
'placeholder' => 'اسم النوع',
'min' => 1,
'max' => 200,
'hint' => '',
'show' => true
])
@endcomponent

@component('components.dashboard.file-input', [
'label' => 'ايقونة النوع',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'icon',
'is_mandatory' => false,
'current' => $record->icon ?? null,
'hint' => '',
'show' => true
])
@endcomponent

<hr>

@component('components.dashboard.input', [
'label' => 'سعر فتحة العداد',
'name' => 'setting[BASE_FARE]',
'type' => 'number',
'value' => $record->settings->where('key_name', 'BASE_FARE')->first()?->value,
'is_mandatory' => false,
'placeholder' => '1',
'min' => 1,
'max' => 200,
'hint' => '',
'input_class' => 'text-start',
'show' => true
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'سعر الكيلو',
'name' => 'setting[KILOMETER_FARE]',
'type' => 'number',
'value' => $record->settings->where('key_name', 'KILOMETER_FARE')->first()?->value,
'is_mandatory' => false,
'placeholder' => '1',
'min' => 1,
'max' => 200,
'hint' => '',
'input_class' => 'text-start',
'show' => true
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'سعر دقيقة التأخير',
'name' => 'setting[LATE_MINUTE_FARE]',
'type' => 'number',
'value' => $record->settings->where('key_name', 'LATE_MINUTE_FARE')->first()?->value,
'is_mandatory' => false,
'placeholder' => '1',
'min' => 1,
'max' => 200,
'hint' => '',
'input_class' => 'text-start',
'show' => true
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'اقل سعر للرحلة',
'name' => 'setting[MINIMUM_FARE]',
'type' => 'number',
'value' => $record->settings->where('key_name', 'MINIMUM_FARE')->first()?->value,
'is_mandatory' => false,
'placeholder' => '1',
'min' => 1,
'max' => 200,
'hint' => '',
'input_class' => 'text-start',
'show' => true
])
@endcomponent

@endsection

@section('formButtons')
{{-- No buttons for show view --}}
@endsection