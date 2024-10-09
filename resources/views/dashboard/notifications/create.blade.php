@extends('dashboard.layouts.createMaster')
@section('title', 'ارسال اشعار')
@section('tableTitle', 'ارسال اشعار')
@section('createRoute', route('dashboard.notifications.store'))

@section('formContent')
<!-- User Name -->
@component('components.dashboard.advanced-select-input', [
'label' => 'المعنيين بالاشعار',
'name' => 'target',
'value' => old('notification_filters'),
'is_mandatory' => true,
'data' => [
['key'=>'All Female Users','value'=>'المستخدمين الاناث'],
['key'=>'All Male Users','value'=>'المستخدمين الرجال'],
['key'=>'All Users','value'=>'جميع المستخدمين'],
['key'=>'All Female Drivers','value'=>'السائقين الاناث'],
['key'=>'All Male Drivers','value'=>'السائقين الرجال'],
['key'=>'All Drivers','value'=>'جميع السائقين'],
['key'=>'Not Used','value'=>'المستخدمين الذين لم يقومو باي رحلات'],
],
'nameKey' => 'value',
'keyKey' => 'key',
'hint' => 'اختار الفئة المعنيه بالاشعار'
])
@endcomponent

@component('components.dashboard.input', [
'label' => 'عنوان الاشعار',
'name' => 'title',
'type' => 'text',
'value' => old('name'),
'is_mandatory' => true,
'placeholder' => 'عنوان الاشعار',
'min' => 1,
'max' => 200, // Updated maximum length
'hint' => 'عنوان الاشعار'
])
@endcomponent

@component('components.dashboard.text-area', [
'label' => 'رسالة الاشعار',
'name' => 'msg_content',
'type' => 'text',
'input_class' => 'mceNoEditor',
'value' => old('meta_keywords'),
'is_mandatory' => true,
'placeholder' => 'اكتب هنا الرسالة',
'min' => 1,
'max' => 300, // Updated maximum length
'hint' => 'حد اقصي 300 حرف',
])
@endcomponent

@component('components.dashboard.file-input', [
'label' => 'إرفاق صورة',
'multiple' => false,
'accepts' => '.jpeg,.png,.jpg,.gif,.svg',
'name' => 'image',
'is_mandatory' => false,
'hint' => 'إختيارية'
])
@endcomponent

@section('formButtons')
<button type="submit" class="btn btn-primary">ارسال</button>
@endsection

@endsection
