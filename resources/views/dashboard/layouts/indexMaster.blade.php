@extends('dashboard.layouts.master')
@section('title', $__env->yieldContent('tableTitle'))
@section('master')


<div class="page-wrapper">

    <div class="page-body">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@yield('tableTitle')</h3>
                    </div>
                    <div class="card-body py-3 d-flex justify-content-between row">
                        <div class="d-flex col-auto  mb-2">
                            <div class="text-muted">
                                اعرض
                                <div class="mx-2 d-inline-block">

                                    {{ Form::open([ 'method' => 'get', 'id' =>
                                    'entry']) }}
                                    @foreach (Arr::except(request()->query(), ['limit']) as $key => $get)
                                    {{ Form::hidden($key, $get, ['type' => 'hidden']) }}
                                    @endforeach
                                    {{ Form::select(
                                    'limit',
                                    [
                                    '8' => '8',
                                    '25' => '25',
                                    '50' => '50',
                                    '100' => '100',
                                    '500' => '500',
                                    '10000' => 'الكل',
                                    ],
                                    request('limit') ? request('limit') : '8',
                                    ['class' => 'form-select', 'onchange' =>
                                    'document.getElementById("entry").submit();'],
                                    ) }}
                                    {{ Form::close() }}
                                </div>
                                @yield('tableTitle')
                            </div>

                        </div>
                        <div class="d-flex col-auto">

                            <form action="" class="d-inline-block w-9 h-4 me-3" method="GET">
                                @if(Request::get('limit'))
                                {{ Form::hidden('limit',Request::get('limit'), ['type' => 'hidden']) }}
                                @endif

                                <input type="search" name="search" class="form-control "
                                    value="{{ Request::get('search') }}" placeholder="بحث ..">
                            </form>

                            @if(app()->view->getSections()['createRoute'] != '')

                            @component('components.dashboard.buttons.add-button', [
                            'route' => app()->view->getSections()['createRoute'],
                            'text' => app()->view->getSections()['tableTitle'],
                            ])
                            @endcomponent

                            @endif


                        </div>
                    </div>

                    @if (View::hasSection('buttons'))
                    <div class="card-body border-top-none border-bottom py-3 d-flex justify-content-between row">
                        <div class="d-flex col-auto  mb-2">

                            @yield('buttons')
                        </div>

                    </div>
                    @endif


                    @yield('table')





                </div>
            </div>
        </div>
    </div>

</div>

@include('dashboard.components.deleteModal')
@include('dashboard.components.restoreModal')
@endsection