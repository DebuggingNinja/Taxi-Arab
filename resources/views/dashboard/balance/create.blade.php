@extends('dashboard.layouts.createMaster')
@section('title', 'شحن رصيد لسائق')
@section('tableTitle', 'شحن رصيد')
@section('createRoute', route('dashboard.drivers.chargeBalanceForAgents'))

@section('formContent')
    <!-- User Name -->

    @component('components.dashboard.input', [
    'label' => 'قيمة الشحن',
    'name' => 'balance',
    'type' => 'number',
    'input_class'=>'rtl',
    'value' => old('balance') ?? 1,
    'is_mandatory' => true,
    'placeholder' =>'1',
    'min' => 1,
    'max' => 1000, // Updated maximum length
    'hint' => 'قيمة الشحن (مبلغ)'
    ])
    @endcomponent

    @component('components.dashboard.input', [
    'label' => 'رقم هاتف السائق',
    'name' => 'driver_phone',
    'type' => 'text',
    'input_class'=>'rtl',
    'value' => time(),
    'is_mandatory' => true,
    'min' => 1,
    'max' => 20, // Updated maximum length
    'hint' => 'رقم هاتف السائق'
    ])
    @endcomponent

    @section('formButtons')
        <button type="submit" class="btn btn-primary">شحن </button>
    @endsection

@endsection
