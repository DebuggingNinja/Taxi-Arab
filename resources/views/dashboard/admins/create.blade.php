@extends('dashboard.layouts.createMaster')
@section('title', 'اضافة ادمن جديد')
@section('tableTitle', 'ادمن جديد')
@section('createRoute', route('dashboard.admins.store'))

@section('formContent')
<!-- User Name -->
@component('components.dashboard.input', [
'label' => 'اسم الادمن',
'name' => 'name',
'type' => 'text',
'value' => old('name'),
'is_mandatory' => true,
'placeholder' => 'اسم الادمن',
'min' => 3,
'max' => 200, // Updated maximum length
'hint' => 'اسم الادمن'
])
@endcomponent


@component('components.dashboard.input', [
'label' => 'البريد الالكتروني',
'name' => 'email',
'type' => 'email',
'value' => old('email'),
'is_mandatory' => true,
'placeholder' =>'example@example.com',
'min' => 5,
'max' => 255, // Updated maximum length
'hint' => 'ايميل الادمن'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'كلمه المرور',
'name' => 'password',
'type' => 'password',
'value' => old('password'),
'is_mandatory' => true,
'placeholder' =>'pwd',
'min' => 8,
'max' => 50, // Updated maximum length
'hint' => 'كلمه مرور الادمن'
])
@endcomponent

@endsection


@section('formButtons')
<button type="submit" class="btn btn-primary">انشاء</button>
@endsection