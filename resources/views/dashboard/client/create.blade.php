@extends('dashboard.layouts.master')
@section('title','عملائنا')
@section('master')
<div class="page-wrapper">
    <script src="https://cdn.tiny.cloud/1/y2u5jj6xi0vwy5nz8c4oo7oa75vyiqpird0407inyl1m5362/tinymce/6/tinymce.min.js">
    </script>

    <div class="page-body">
        <div class="container">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">اضافة عميل جديدة</h3>
                        </div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{ route('clients.store') }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">اسم العميل (عربي)
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{ old('ar_name') }}"
                                            name="ar_name" placeholder="ادخل اسم العميل بالعربية">
                                        <small class="form-hint">
                                            اسم العميل يجب ان يكون بالعربيه و
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
                                    <label class="form-label col-3 col-form-label">اسم العميل (انجليزي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="en_name"
                                            value="{{ old('en_name') }}" placeholder="ادخل اسم العميل بالانجليزية">
                                        <small class="form-hint">
                                            اسم العميل يجب ان يكون بالانجليزية و
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
                                    <label class="form-label col-3 col-form-label">لوجو العميل
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="file" value="" class="form-control" name="images"
                                            accept=".png,.jpg,.jpeg,.gif">
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