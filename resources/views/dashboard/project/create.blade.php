@extends('dashboard.layouts.master')
@section('title','مشاريعنا')
@section('master')
<div class="page-wrapper">
    <script src="https://cdn.tiny.cloud/1/y2u5jj6xi0vwy5nz8c4oo7oa75vyiqpird0407inyl1m5362/tinymce/6/tinymce.min.js">
    </script>
    <link href="{{ asset('dist/css/tabler-vendors.rtl.min.css') }}" rel="stylesheet" />
    <div class="page-body">
        <div class="container">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">انشئ مشروع جديد</h3>
                        </div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{ route('projects.store') }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">اسم المشروع (عربي)
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{ old('ar_title') }}"
                                            name="ar_title" placeholder="ادخل اسم المشروع بالعربية">
                                        <small class="form-hint">
                                            اسم المشروع يجب ان يكون بالعربيه و
                                            <strong>مميز </strong>
                                            ليس مكرراََ,
                                            <strong>
                                                حرف واحد علي الاقل و 255 حرف علي الاكثر
                                            </strong>
                                            و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">اسم المشروع (انجليزي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="en_title"
                                            value="{{ old('en_title') }}" placeholder="ادخل اسم المشروع بالانجليزية">
                                        <small class="form-hint">
                                            اسم المشروع يجب ان يكون بالانجليزية و
                                            <strong>مميز </strong>
                                            ليس مكرراََ,
                                            <strong>
                                                حرف واحد علي الاقل و 255 حرف علي الاكثر
                                            </strong>
                                            و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">وصف المشروع (عربي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <textarea type="text" class="form-control" name="ar_description"
                                            placeholder="ادخل وصف المشروع بالعربية">{{ old('ar_description') }}</textarea>
                                        <small class="form-hint">
                                            وصف المشروع يجب ان يكون بالعربية و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">وصف المشروع (انجليزي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <textarea type="text" class="form-control" name="en_description"
                                            placeholder="ادخل وصف المشروع بالانجليزية"> {{ old('en_description') }} </textarea>
                                        <small class="form-hint">
                                            وصف المشروع يجب ان يكون بالانجليزية و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">موقع المشروع (عربي)
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{ old('ar_location') }}"
                                            name="ar_location" placeholder="ادخل موقع المشروع بالعربية">
                                        <small class="form-hint">
                                            موقع المشروع يجب ان يكون بالعربيه و
                                            <strong>مميز </strong>
                                            ليس مكرراََ,
                                            <strong>
                                                حرف واحد علي الاقل و 255 حرف علي الاكثر
                                            </strong>
                                            و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">موقع المشروع (انجليزي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="en_location"
                                            value="{{ old('en_location') }}"
                                            placeholder="ادخل موقع المشروع بالانجليزية">
                                        <small class="form-hint">
                                            موقع المشروع يجب ان يكون بالانجليزية و
                                            <strong>مميز </strong>
                                            ليس مكرراََ,
                                            <strong>
                                                حرف واحد علي الاقل و 255 حرف علي الاكثر
                                            </strong>
                                            و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">مدة تنفيذ المشروع (عربي)
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{ old('ar_duration') }}"
                                            name="ar_duration" placeholder="ادخل مدة تنفيذ المشروع بالعربية">
                                        <small class="form-hint">
                                            مدة تنفيذ المشروع يجب ان يكون بالعربيه و
                                            <strong>مميز </strong>
                                            ليس مكرراََ,
                                            <strong>
                                                حرف واحد علي الاقل و 255 حرف علي الاكثر
                                            </strong>
                                            و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">مدة تنفيذ المشروع (انجليزي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="en_duration"
                                            value="{{ old('en_duration') }}"
                                            placeholder="ادخل مدة تنفيذ المشروع بالانجليزية">
                                        <small class="form-hint">
                                            مدة تنفيذ المشروع يجب ان يكون بالانجليزية و
                                            <strong>مميز </strong>
                                            ليس مكرراََ,
                                            <strong>
                                                حرف واحد علي الاقل و 255 حرف علي الاكثر
                                            </strong>
                                            و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">تاريخ انتهاء المشروع <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <input type="date" class="form-control" name="deployed_at"
                                            value="{{ old('deployed_at') }}" placeholder="ادخل تاريخ انتهاء المشروع">
                                        <small class="form-hint">
                                            ادخل تاريخ
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">رابط فيديو يوتيوب
                                        <span class="text-primary fw-bold">(اختياري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="youtube_link"
                                            value="{{ old('youtube_link') }}"
                                            placeholder="https://www.youtube.com/watch?v=xxxxxxx">
                                        <small class="form-hint">
                                            ادخل رابط الفيديو
                                            مثل
                                            <span class="text-muted">https://www.youtube.com/watch?v=xxxxxxx</span>
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">صور المشروع
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="file" value="" class="form-control" name="images[]"
                                            accept=".png,.jpg,.jpeg,.gif" multiple>
                                        <small class="form-hint">اختار صيغة من الصيغ الاتية
                                            <strong>Jpg,png او gif</strong>
                                            ,وحجم الصوره يجب ان لا تتعدي ال
                                            <strong>5 ميجا بايت</strong></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">اختار الخدمة المقدمة
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <select type="text" class="form-select" name="service_id"
                                            placeholder="اختار الخدمة" id="select-service" value="">
                                            @foreach ($services as $service)
                                            <option value="{{ $service->id }}">{{ $service->ar_title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">اختار العميل<span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <select type="text" class="form-select" name="client_id"
                                            placeholder="اختار العميل" id="select-client" value="">
                                            @foreach ($clients as $client)
                                            <option value="{{ $client->id }}">{{ $client->ar_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-footer text-right">
                                    <button type="submit" class="btn btn-primary">انشاء</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('dist/libs/tom-select/dist/js/tom-select.base.min.js?1674944402') }} " defer=""></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
    	var el;
    	window.TomSelect && (new TomSelect(el = document.getElementById('select-service'), {
    		copyClassesToDropdown: false,
    		dropdownClass: 'dropdown-menu ts-dropdown',
    		optionClass:'dropdown-item',
    		controlInput: '<input>',
    		render:{
    			item: function(data,escape) {
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    			option: function(data,escape){
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    		},
    	}));
    });
    // @formatter:on
</script>

<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function () {
    	var el;
    	window.TomSelect && (new TomSelect(el = document.getElementById('select-client'), {
    		copyClassesToDropdown: false,
    		dropdownClass: 'dropdown-menu ts-dropdown',
    		optionClass:'dropdown-item',
    		controlInput: '<input>',
    		render:{
    			item: function(data,escape) {
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    			option: function(data,escape){
    				if( data.customProperties ){
    					return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
    				}
    				return '<div>' + escape(data.text) + '</div>';
    			},
    		},
    	}));
    });
    // @formatter:on
</script>
@endsection