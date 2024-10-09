@extends('dashboard.layouts.master')
@section('title', $__env->yieldContent('tableTitle'))
@push('css')
<link href="{{ asset('dist/css/tabler-vendors.rtl.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('dist/css/tabler-flags.min.css') }}">
<link rel="stylesheet" href="{{ asset('dist/libs/dropzone/dist/dropzone.css') }}">

<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tiny.cloud/1/y2u5jj6xi0vwy5nz8c4oo7oa75vyiqpird0407inyl1m5362/tinymce/6/tinymce.min.js">

</script>
@endpush
@section('master')

<div class="page-body">
    <div class="container-fluid">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if($__env->yieldContent('mode') == 'update')
                        <h3 class="card-title">تعديل @yield('tableTitle') </h3>
                        @elseif ($__env->yieldContent('mode') == 'show')
                        <h3 class="card-title">بيانات @yield('tableTitle')</h3>
                        @else
                        <h3 class="card-title">اضافة @yield('tableTitle') جديده</h3>
                        @endif

                    </div>
                    <div class="card-body">
                        <form accept-charset="utf-8" id="translatableForm"
                            action="{{ app()->view->getSections()['createRoute'] }}" enctype="multipart/form-data"
                            method="POST">
                            @csrf
                            @yield('formContent')

                            <div class="form-footer text-right">
                                @yield('formButtons')
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@push('jsAtBottom')
<script src="{{ asset('dist/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
<script src="{{ asset('dist/js/country-selector.js') }}"></script>
<script>
    tinymce.init({
    selector: "textarea:not(.mceNoEditor):not(.select2-search__field)",

    plugins: 'advlist codesample fullscreen media pagebreak table',
    toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | codesample | fullscreen | media | pagebreak | table',

});
    $(function () {
$('[data-toggle="tooltip"]').tooltip()
})

</script>
<script>
    // @formatter:off
    $(document).ready(function () {
        $('.advanced-select').each(function () {
            var el = this;
            if (window.TomSelect) {
                new TomSelect(el, {
                    copyClassesToDropdown: false,
                    dropdownClass: 'dropdown-menu ts-dropdown',
                    optionClass: 'dropdown-item',
                    controlInput: '<input>',
                    render: {
                        item: function (data, escape) {
                            if (data.customProperties) {
                                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                        option: function (data, escape) {
                            if (data.customProperties) {
                                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                            }
                            return '<div>' + escape(data.text) + '</div>';
                        },
                    },
                });
            }
        });
    });
    // @formatter:on
</script>

@endpush
@endsection
