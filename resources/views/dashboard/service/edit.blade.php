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
                            <h3 class="card-title">التعديل علي الخدمة</h3>
                        </div>
                        <div class="card-body">
                            <form accept-charset="utf-8" action="{{ route('services.update',$service) }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">اسم الخدمة (عربي)
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{ $service->ar_title}}"
                                            name="ar_title" placeholder="ادخل اسم الخدمة بالعربية">
                                        <small class="form-hint">
                                            اسم الخدمة يجب ان يكون بالعربيه و
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
                                    <label class="form-label col-3 col-form-label">اسم الخدمة (انجليزي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="en_title"
                                            value="{{ $service->en_title}}" placeholder="ادخل اسم الخدمة بالانجليزية">
                                        <small class="form-hint">
                                            اسم الخدمة يجب ان يكون بالانجليزية و
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
                                    <label class="form-label col-3 col-form-label">وصف الخدمة (عربي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <textarea type="text" class="form-control" name="ar_description"
                                            placeholder="ادخل وصف الخدمة بالعربية">{{ $service->ar_description}}</textarea>
                                        <small class="form-hint">
                                            وصف الخدمة يجب ان يكون بالعربية و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">وصف الخدمة (انجليزي) <span
                                            class="text-danger fw-bold">(اجباري)</span></label>
                                    <div class="col">
                                        <textarea type="text" class="form-control" name="en_description"
                                            placeholder="ادخل وصف الخدمة بالانجليزية"> {{ $service->en_description}} </textarea>
                                        <small class="form-hint">
                                            وصف الخدمة يجب ان يكون بالانجليزية و
                                            <strong>
                                                يمكنك استخدام المسافات
                                            </strong>.
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">رابط فيديو يوتيوب
                                        <span class="text-primary fw-bold">(اختياري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" name="youtube_link"
                                            value="{{ $service->youtube_link}}"
                                            placeholder="https://www.youtube.com/watch?v=xxxxxxx">
                                        <small class="form-hint">
                                            ادخل رابط الفيديو
                                            مثل
                                            <span class="text-muted">https://www.youtube.com/watch?v=xxxxxxx</span>
                                        </small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">صور الخدمة
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="file" value="" class="form-control" name="images[]"
                                            accept=".png,.jpg,.jpeg,.gif" multiple>
                                        <small class="form-hint">الي هتحطه هنا هيتضاف علي الصور الحالية وبامكانك حذف
                                            الصور الحالية من الجالري تحت</small>
                                        <small class="form-hint">اختار صيغة من الصيغ الاتية
                                            <strong>Jpg,png او gif</strong>
                                            ,وحجم الصوره يجب ان لا تتعدي ال
                                            <strong>5 ميجا بايت</strong></small>
                                    </div>
                                </div>
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">صور الخدمة الحالية
                                        <span class="text-danger fw-bold"></span>
                                    </label>
                                    <div class="col">
                                        <div class="d-flex flex-row flex-wrap ">
                                            @foreach ($service->images as $image)


                                            <div class="p-1 m-1 position-relative">
                                                <a href="{{ route('service.image.delete',$image) }}"
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