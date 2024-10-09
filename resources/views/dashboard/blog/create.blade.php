@extends('dashboard.layouts.master')
@section('title','اضافة مدونة')
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
                            <h3 class="card-title">انشئ تدوينة جديد</h3>
                        </div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{ route('blog.store') }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">عنوان التدوينة (عربي)
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{ old('ar_title') }}"
                                            name="ar_title" placeholder="ادخل عنوان التدوينة بالعربية">
                                        <small class="form-hint">
                                            عنوان التدوينة يجب ان يكون بالعربيه و
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
                                    <label class="form-label col-3 col-form-label">عنوان التدوينة (انجليزي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="en_title"
                                            value="{{ old('en_title') }}" placeholder="ادخل عنوان التدوينة بالانجليزية">
                                        <small class="form-hint">
                                            عنوان التدوينة يجب ان يكون بالانجليزية و
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
                                    <label class="form-label col-3 col-form-label">وصف التدوينة (عربي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <textarea type="text" class="form-control" name="ar_description"
                                            placeholder="ادخل وصف التدوينة بالعربية">{{ old('ar_description') }}</textarea>
                                        <small class="form-hint">
                                            وصف التدوينة يجب ان يكون بالعربية و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">وصف التدوينة (انجليزي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <textarea type="text" class="form-control" name="en_description"
                                            placeholder="ادخل وصف التدوينة بالانجليزية"> {{ old('en_description') }} </textarea>
                                        <small class="form-hint">
                                            وصف التدوينة يجب ان يكون بالانجليزية و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">كلمات مفتاحية<span
                                            class="text-primary fw-bold">(اختياري)</span></label>
                                    <div class="col">
                                        <textarea type="text" class="form-control" name="tags"
                                            placeholder="الفراعنة, فن العمارة, اللغة المصرية, البناء"> {{ old('tags') }} </textarea>
                                        <small class="form-hint">
                                            حقل اختياري , افصل بين الكلمة والاخرى ب
                                            ","

                                        </small>
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">صور التدوينة
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
@endsection