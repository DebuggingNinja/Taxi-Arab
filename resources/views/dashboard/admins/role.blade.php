@extends('dashboard.layouts.createMaster')
@section('title', 'اضافه رول لادمن')
@section('tableTitle', 'رول لادمن')
@section('createRoute', route('dashboard.admins.role.assign',request()->route('admin')))

@section('formContent')
@component('components.dashboard.advanced-select-input', [
'label' => 'دور الادمن',
'name' => 'role_id',
'value' => $role_id??null,
'is_mandatory' => true,
'data' => $roles, // Assuming $carTypes is an array with car type data
'nameKey' => 'name',
'keyKey' => 'name',
'hint' => 'اختار دور الادمن'
])
@endcomponent

@endsection


@section('formButtons')
<button type="submit" class="btn btn-primary">تعديل</button>
@endsection