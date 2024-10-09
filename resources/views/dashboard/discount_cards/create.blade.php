@extends('dashboard.layouts.createMaster')
@section('title', 'انشاء كروت خصم')
@section('tableTitle', 'انشاء كروت خصم')
@section('createRoute', route('dashboard.discount_cards.store'))

@section('formContent')
<!-- User Name -->

@component('components.dashboard.input', [
'label' => 'قيمة الكارد',
'name' => 'percentage_amount',
'type' => 'number',
'input_class'=>'rtl',
'value' => old('amount') ?? 1,
'is_mandatory' => true,
'placeholder' =>'1',
'min' => 1,
'max' => 1000, // Updated maximum length
'hint' => 'قيمة الخصم (نسبة مئوية)'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'رقم الكارد',
'name' => 'card_number',
'type' => 'text',
'input_class'=>'rtl',
'value' => time(),
'is_mandatory' => true,
'min' => 1,
'max' => 20, // Updated maximum length
'hint' => 'رقم البطاقة'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'صالحة من',
'name' => 'valid_from',
'type' => 'date',
'input_class'=>'rtl',
'value' => date('Y-m-d'),
'is_mandatory' => true,
'hint' => 'إعتبار البطاقة صالحة بدء من تاريخ'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'صالحة إلى',
'name' => 'valid_to',
'type' => 'date',
'input_class'=>'rtl',
'value' => date('Y-m-d', strtotime('+ 1 week')),
'is_mandatory' => true,
'hint' => 'إعتبار البطاقة صالحة الى تاريخ'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'عدد مرات الإستخدام',
'name' => 'repeat_limit',
'type' => 'number',
'input_class'=>'rtl',
'value' => 1,
'is_mandatory' => true,
'hint' => 'عدد مرات إستخدام البطاقة المسموح بها',
'min' => 1,
'max' => 9999
])
@endcomponent

@component('components.dashboard.checkbox-input', [
'label' => 'السماح لنفس المستخدم باستخدام نفس البطاقة اكثر من مرة',
'name' => 'allow_user_to_reuse',
'value' => old('allow_user_to_reuse') ?? 0,
])
@endcomponent

@section('formButtons')
<button type="submit" class="btn btn-primary">حفظ </button>
@endsection

@endsection
