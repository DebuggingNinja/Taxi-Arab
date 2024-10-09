@extends('dashboard.layouts.createMaster')
@section('mode', 'update')

@section('title', 'تعديل الادمن')
@section('tableTitle', 'ادمن')
@section('createRoute', route('dashboard.admins.update', $record->id))

@section('formContent')
@method('PATCH')
<!-- Admin Name -->
@component('components.dashboard.input', [
'label' => 'اسم الادمن',
'name' => 'name',
'type' => 'text',
'value' => $record->name,
'is_mandatory' => true,
'placeholder' => 'اسم الادمن',
'min' => 3,
'max' => 200,
'hint' => 'اسم الادمن'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'البريد الالكتروني',
'name' => 'email',
'type' => 'email',
'value' => $record->email,
'is_mandatory' => true,
'placeholder' =>'example@example.com',
'min' => 5,
'max' => 255,
'hint' => 'ايميل الادمن'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'كلمه المرور',
'name' => 'password',
'type' => 'password',
'value' => null, // Do not pre-fill the password for security reasons
'is_mandatory' => false, // Not mandatory for editing
'placeholder' =>'pwd',
'min' => 8,
'max' => 50,
'hint' => 'ترك هذا الحقل فارغاً إذا لم ترد تغيير كلمة المرور'
])
@endcomponent

@endsection

@section('formButtons')
<button type="submit" class="btn btn-primary">تعديل</button>
@endsection