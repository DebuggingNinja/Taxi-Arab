@extends('dashboard.layouts.master')
@section('title', 'عرض بيانات الشكوى')
@section('master')
<style>
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
                        <h3 class="card-title">عرض بيانات الشكوى</h3>
                    </div>
                    <div class="card-body py-3 d-flex justify-content-between row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'اسم المستخدم',
                            'name' => 'name',
                            'type' => 'text',
                            'value' => 'ابراهيم محمد عبدالمنعم',
                            'input_class' => 'border-0 ',
                            'is_mandatory' => false,
                            'readonly' => true,
                            'placeholder' => 'اسم المستخدم',
                            'min' => 1,
                            'max' => 200, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'النوع',
                            'name' => 'gender',
                            'type' => 'text',
                            'value' => 'سائق',
                            'is_mandatory' => false,
                            'readonly' => true,
                            'input_class' => 'border-0',
                            'placeholder' =>'',
                            'min' => 1,
                            'max' => 20, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'رقم الهاتف',
                            'name' => 'phone_number',
                            'type' => 'text',
                            'value' => '01554742781',
                            'is_mandatory' => false,
                            'readonly' => true,
                            'input_class' => 'border-0 lrt',
                            'placeholder' =>'+20 1554789945',
                            'min' => 5,
                            'max' => 15, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'تاريخ الشكوي',
                            'name' => 'phone_number',
                            'type' => 'text',
                            'value' => '23/12/2023 04:00 PM',
                            'is_mandatory' => false,
                            'readonly' => true,
                            'input_class' => 'border-0 lrt',
                            'placeholder' =>'+20 1554789945',
                            'min' => 5,
                            'max' => 15, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            @component('components.dashboard.input', [
                            'label' => 'حالة الشكوي',
                            'name' => 'phone_number',
                            'type' => 'text',
                            'value' => 'قيد العمل',
                            'is_mandatory' => false,
                            'readonly' => true,
                            'input_class' => 'border-0 lrt',
                            'placeholder' =>'+20 1554789945',
                            'min' => 5,
                            'max' => 15, // Updated maximum length
                            'hint' => ''
                            ])
                            @endcomponent
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-3 row">
                                <label class="form-label col-3 col-form-label">الشكوي<span class="text-danger fw-bold">
                                    </span></label>
                                <div class="col">
                                    <pre
                                        class="bg-white text-black h4 text-start ltr">قد واجهت تجربة سيئة أثناء رحلتي مع أوبر وأرغب في تقديم شكوى. في البداية، كانت المركبة في حالة غير نظيفة، مما أثر سلبًا على راحتي. علاوة على ذلك، كان السائق يقود بشكل متهور، مما جعل الرحلة غير آمنة.

                                        ثانيًا، كان هناك تأخير كبير في الوصول إلى وجهتي، مما تسبب في إزعاج وتأخير لي في مواعيدي. كما أن السائق لم يظهر احترافًا في التعامل مع الزبائن وكانت تصرفاته غير ملائمة.

                                        أرجو منكم النظر في هذه الشكوى واتخاذ الإجراءات اللازمة لتحسين جودة الخدمة المقدمة من قبل سائقي أوبر. أتمنى أن يتم التعامل مع هذا الأمر بجدية وشكرًا لتفهمكم.</pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            @component('components.dashboard.buttons.button',[

                            'cssClass'=>'btn-primary',
                            'data_id'=>null,
                            'text'=> 'تم المعالجه',
                            ])

                            @endcomponent
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection