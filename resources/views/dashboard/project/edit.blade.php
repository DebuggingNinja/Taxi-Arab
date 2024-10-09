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
                            <form accept-charset="utf-8" action="{{ route('projects.update',$Project) }}"
                                enctype="multipart/form-data" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group mb-3 row">
                                    <label class="form-label col-3 col-form-label">اسم المشروع (عربي)
                                        <span class="text-danger fw-bold">(اجباري)</span>
                                    </label>
                                    <div class="col">
                                        <input type="text" class="form-control" value="{{ $Project->ar_title }}"
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
                                            value="{{ $Project->en_title }}" placeholder="ادخل اسم المشروع بالانجليزية">
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
                                            placeholder="ادخل وصف المشروع بالعربية">{{ $Project->ar_description }}</textarea>
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
                                            placeholder="ادخل وصف المشروع بالانجليزية"> {{ $Project->en_description }} </textarea>
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
                                        <input type="text" class="form-control" value="{{ $Project->ar_location }}"
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
                                            value="{{ $Project->en_location }}"
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
                                        <input type="text" class="form-control" value="{{ $Project->ar_duration }}"
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
                                            value="{{ $Project->en_duration }}"
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
                                            value="{{ $Project->deployed_at }}" placeholder="ادخل تاريخ انتهاء المشروع">
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
                                            value="{{ $Project->youtube_link }}"
                                            placeholder="https://www.youtube.com/watch?v=xxxxxxx">
                                        <small class="form-hint">
                                            ادخل رابط الفيديو
                                            مثل
                                            <span class="text-muted">https://www.youtube.com/watch?v=xxxxxxx</span>
                                        </small>
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
                                            <option {{ $service->id == $Project->service_id?'selected':'' }} value="{{
                                                $service->id }}">{{ $service->ar_title }}</option>
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
                                            <option {{ $client->id == $Project->client_id?'selected':'' }} value="{{
                                                $client->id }}">{{ $client->ar_name }}</option>
                                            @endforeach
                                        </select>
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
                                    <label class="form-label col-3 col-form-label">صور الخدمة الحالية
                                        <span class="text-danger fw-bold"></span>
                                    </label>
                                    <div class="col">
                                        <div class="d-flex flex-row flex-wrap ">
                                            @foreach ($Project->images as $image)


                                            <div class="p-1 m-1 position-relative">
                                                <a href="{{ route('projects.imagedestroy',$image->id) }}"
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