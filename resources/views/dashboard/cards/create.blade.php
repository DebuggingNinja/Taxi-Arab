@extends('dashboard.layouts.createMaster')
@section('title', 'انشاء كروت')
@section('tableTitle', 'انشاء كروت')
@section('createRoute', route('dashboard.cards.store'))

@section('formContent')
<!-- User Name -->

@component('components.dashboard.input', [
'label' => 'قيمة الكارد',
'name' => 'amount',
'type' => 'number',
'input_class'=>'rtl',
'value' => old('amount') ?? 1,
'is_mandatory' => true,
'placeholder' =>'1',
'min' => 1,
'max' => 1000, // Updated maximum length
'hint' => 'القيمه الي هيتم شحنها'
])
@endcomponent

@component('components.dashboard.advanced-select-input', [
'label' => 'نوع الكارد',
'name' => 'category',
'value' => old('category'),
'is_mandatory' => true,
'data' => [
['key'=>'Driver','value'=>'سائقين'],
['key'=>'User','value'=>'مستخدمين']
],
'nameKey' => 'value',
'keyKey' => 'key',
'hint' => 'الفئة الموجه لها الكارد'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'انشاء عدد من الكارد',
'name' => 'card_repeat',
'type' => 'number',
'input_class'=>'rtl',
'value' => old('card_repeat') ?? 1,
'is_mandatory' => true,
'placeholder' =>'1',
'min' => 1,
'max' => 1000, // Updated maximum length
'hint' => 'اذا كنت في حاجه الي انشاء 10 كروت اكتب 10'
])
@endcomponent


@section('formButtons')
<button type="submit" class="btn btn-primary">حفظ واستيراد</button>
@endsection

@endsection