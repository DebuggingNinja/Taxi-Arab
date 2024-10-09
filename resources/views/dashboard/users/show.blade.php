@extends('dashboard.layouts.master')
@section('mode','show')
@section('title', 'بيانات المستخدم')
@section('tableTitle', 'مستخدم')
@section('createRoute', '')

@section('master')<style>
    /* Custom CSS to remove border on click */
    .form-control:focus {
        border-color: none;
        box-shadow: none;
    }
</style>
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">عرض بيانات السائق</h3>
                    </div>
                    <div class="card-body py-3 d-flex justify-content-between row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="col-md-6">
                                <!-- User Name -->
                                @component('components.dashboard.input', [
                                'label' => 'اسم المستخدم',
                                'name' => 'name',
                                'type' => 'text',
                                'value' => $record->name,
                                'is_mandatory' => false,
                                'placeholder' => 'اسم المستخدم',
                                'min' => 1,
                                'max' => 200, // Updated maximum length
                                'hint' => '',
                                'show'=>true

                                ])
                                @endcomponent

                            </div>
                            <div class="col-md-6">
                                @component('components.dashboard.advanced-select-input', [
                                'label' => 'النوع',
                                'name' => 'gender',
                                'value' => $record->gender,
                                'is_mandatory' => false,
                                'data' => [
                                ['key'=>'Male','value'=>'ذكر'],
                                ['key'=>'Female','value'=>'انثي']
                                ],
                                'nameKey' => 'value',
                                'keyKey' => 'key',
                                'hint' => '',
                                'show'=>true
                                ])
                                @endcomponent

                            </div>
                            <div class="col-md-6">
                                @component('components.dashboard.input', [
                                'label' => 'رقم الهاتف',
                                'name' => 'phone_number',
                                'type' => 'text',
                                'value' => $record->phone_number,
                                'is_mandatory' => false,
                                'placeholder' =>'+20 1554789945',
                                'min' => 5,
                                'max' => 15, // Updated maximum length
                                'hint' => '',
                                'show'=>true
                                ])
                                @endcomponent

                            </div>
                            <div class="col-md-6">
                                @component('components.dashboard.file-input', [
                                'label' => 'صورة شخصيه',
                                'multiple' => false,
                                'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
                                'name' => 'profile_image',
                                'is_mandatory' => false,
                                'current'=>$record->profile_image??null,
                                'hint' => '',
                                'show'=>true
                                ])
                                @endcomponent
                            </div>
                            <div class="col-md-6">
                                @component('components.dashboard.input', [
                                'label' => 'الرصيد الحالى',
                                'name' => 'current_balance',
                                'type' => 'text',
                                'value' => $record->current_credit_amount,
                                'placeholder' => '',
                                'input_class' => 'border-0 rtl',
                                'is_mandatory' => false,
                                'min' => 1,
                                'max' => 50, 'readonly' => true,
                                'hint' => ''
                                ])
                                @endcomponent
                                @component('components.dashboard.modals.input-modal',[
                                    'button_text'=>'إضافة رصيد',
                                    'input_name'=>'balance',
                                    'submit_route'=> route('dashboard.users.chargeBalance', $record),
                                    'save_button_text'=>'إضافة للرصيد',
                                    'close_button_text'=>'اغلق',
                                    'title'=>'إضافة رصيد للمستخدم'
                                ])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
