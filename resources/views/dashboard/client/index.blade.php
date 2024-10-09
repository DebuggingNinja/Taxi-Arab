@extends('dashboard.layouts.master')
@section('title','عملائنا')
@section('master')
<div class="page-wrapper">

    <div class="page-body">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">عملائنا</h3>
                    </div>
                    <div class="card-body  border-bottom py-3 d-flex justify-content-between row">
                        <div class="d-flex col-auto  mb-2">
                            <div class="text-muted">
                                اعرض
                                <div class="mx-2 d-inline-block">

                                    {{ Form::open(['route' => ['clients.index'], 'method' => 'get', 'id' =>
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
                                عميل
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
                            <a href="{{ route('clients.create') }}" class="btn btn-primary h-4 py-3">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                اضافة عميل جديد
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable" id="users-table">
                            <thead>
                                <tr>
                                    <th class="w-1">رقم تعريفي
                                    </th>
                                    <th>اسم العميل</th>
                                    <th>عدد مشاريع العميل</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $client)
                                <tr>
                                    <td>
                                        {{ $client->id }}
                                    </td>

                                    <td>
                                        {{ $client->ar_name }}
                                    </td>

                                    <td>
                                        {{ $client->projects->count() }}
                                    </td>

                                    <td class="text-end">
                                        @if($client->projects->count() == 0)
                                        <form class="d-none" id="DELETE_{{ $client->id }}" method="POST"
                                            action="{{ route('clients.destroy',$client) }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        @endif
                                        <div class="btn-group">
                                            <a href="{{ route('clients.edit',$client) }}" type="button"
                                                class="btn bg-orange-lt ">تعديل</a>
                                            @if($client->projects->count() == 0)
                                            <button type="button" data-id="DELETE_{{ $client->id }}"
                                                data-bs-target="#modal-danger" data-bs-toggle="modal"
                                                class="btn btn-danger delete-btn">حذف</button>
                                            @else
                                            <div tabindex="0" data-toggle="tooltip"
                                                title="يجب حذف المشاريع الخاصه بالعميل اولا ثم احذف العميل">
                                                <button type="button" class="disabled btn btn-danger ">الحذف غير
                                                    ممكن
                                                </button>
                                            </div>
                                            @endif
                                        </div>



                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </form>
                    <div class="card-footer d-flex align-items-center">
                        {{ $clients->appends(Arr::except(request()->query(),
                        ['page']))->links('vendor.pagination.adminPaginating') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('dashboard.components.deleteModal')
@endsection