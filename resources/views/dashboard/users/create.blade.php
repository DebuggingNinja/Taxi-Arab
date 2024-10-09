@extends('dashboard.layouts.createMaster')
@section('title', 'اضافة مستخدم جديد')
@section('tableTitle', 'مستخدم جديد')
@section('createRoute', route('dashboard.users.store'))

@section('formContent')
<!-- User Name -->
@component('components.dashboard.input', [
'label' => 'اسم المستخدم',
'name' => 'name',
'type' => 'text',
'value' => old('name'),
'is_mandatory' => true,
'placeholder' => 'اسم المستخدم',
'min' => 1,
'max' => 200, // Updated maximum length
'hint' => 'اسم المستخدم'
])
@endcomponent


@component('components.dashboard.advanced-select-input', [
'label' => 'النوع',
'name' => 'gender',
'value' => old('gender'),
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
'label' => 'رقم الهاتف',
'name' => 'phone_number',
'type' => 'text',
'value' => old('phone_number'),
'is_mandatory' => true,
'placeholder' =>'+20 1554789945',
'min' => 5,
'max' => 15, // Updated maximum length
'hint' => 'رقم الهاتف الخاص بالسائق'
])
@endcomponent

@component('components.dashboard.file-input', [
'label' => 'صورة شخصيه',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'profile_image',
'is_mandatory' => true,

'hint' => 'الصورة تكون واضحة'
])
@endcomponent
@endsection


@section('formButtons')
<button type="submit" class="btn btn-primary">انشاء</button>
@endsection