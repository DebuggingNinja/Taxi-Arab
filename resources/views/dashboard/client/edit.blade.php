@extends('dashboard.layouts.master')
@section('title','خدماتنا')
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
                            <h3 class="card-title">التعديل علي العميل</h3>
                        </div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{ route('clients.update',$Client) }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">اسم العميل (عربي)
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{ $Client->ar_name }}"
                                            name="ar_name" placeholder="ادخل اسم العميل بالعربية" required>
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
                                            value="{{ $Client->en_name }}" placeholder="ادخل اسم العميل بالانجليزية"
                                            required>
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
                                        <small class="form-hint">لتغيير الصورة ارفع صورة جديدة لو مش عايز تغير سيبها
                                            فاضية</small>
                                        <small class="form-hint">اختار صيغة من الصيغ الاتية
                                            <strong>Jpg,png او gif</strong>
                                            ,وحجم الصوره يجب ان لا تتعدي ال
                                            <strong>3 ميجا بايت</strong></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">صورة العميل الحالية
                                        <span class="text-danger fw-bold"></span>
                                    </label>
                                    <div class="col">
                                        <div class="d-flex flex-row flex-wrap ">



                                            <div class="p-1 m-1 position-relative">

                                                <img src="{{ asset($Client->image) }}" class="rounded"
                                                    style="max-height:100px" />
                                            </div>



                                        </div>
                                    </div>
                                </div>
                                <div class="form-footer text-right">
                                    <button type="submit" class="btn btn-primary">تعديل</button>
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