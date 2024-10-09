@extends('dashboard.layouts.master')
@section('title','مشاريعنا')
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
                            <h3 class="card-title">التعديل علي المشروع</h3>
                        </div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{ route('blog.update',$Blog) }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">عنوان التدوينة (عربي)
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{ $Blog->ar_title }}"
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
                                            value="{{ $Blog->en_title }}" placeholder="ادخل عنوان التدوينة بالانجليزية">
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
                                            placeholder="ادخل وصف التدوينة بالعربية">{{ $Blog->ar_description }}</textarea>
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
                                            placeholder="ادخل وصف التدوينة بالانجليزية"> {{ $Blog->en_description }} </textarea>
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
                                            placeholder="الفراعنة, فن العمارة, اللغة المصرية, البناء"> {{ $Blog->tags }} </textarea>
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
                                        <small class="form-hint">الصور الي هتختارها هتضاف علي الصور الحاليه لو مش عايز
                                            تضيف متحطش صوره</small>
                                        <small class="form-hint">اختار صيغة من الصيغ الاتية
                                            <strong>Jpg,png او gif</strong>
                                            ,وحجم الصوره يجب ان لا تتعدي ال
                                            <strong>5 ميجا بايت</strong></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">صور التدوينة الحالية
                                        <span class="text-danger fw-bold"></span>
                                    </label>
                                    <div class="col">
                                        <div class="d-flex flex-row flex-wrap ">
                                            @foreach ($Blog->images as $image)


                                            <div class="p-1 m-1 position-relative">
                                                <a href="{{ route('blog.imagedestroy',$image->id) }}"
                                                    class="badge bg-red badge-notification badge-pill m-2">X</a>
                                                <img src="{{ asset($image->thumb) }}" class="rounded"
                                                    style="max-height:100px" />
                                            </div>


                                            @endforeach

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