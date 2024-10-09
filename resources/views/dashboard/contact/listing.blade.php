@extends('dashboard.layouts.master')
@section('title','تواصل معنا')
@section('master')
<div class="page-wrapper">

    <div class="page-body">
        <div class="container-fluid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">الرسائل الخاصه بالتواصل</h3>
                    </div>
                    <div class="card-body  border-bottom py-3 d-flex justify-content-between row">
                        <div class="d-flex col-auto  mb-2">
                            <div class="text-muted">
                                اعرض
                                <div class="mx-2 d-inline-block">

                                    {{ Form::open(['route' => ['contacts.index'], 'method' => 'get', 'id' =>
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
                                رسالة
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
                        </div>
                    </div>
                    <div class="card-body  border-bottom py-3 d-flex  row">
                        <div class="d-flex col-auto">
                            <a href="?read=1" class="btn btn-primary">
                                اعرض المقروء فقط
                            </a>

                        </div>
                        <div class="d-flex col-auto">
                            <a href="?read=0" class="btn btn-danger ">
                                اعرض الغير مقروء فقط
                            </a>

                        </div>

                    </div>
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap datatable" id="users-table">
                            <thead>
                                <tr>
                                    <th class="w-1">رقم تعريفي
                                    </th>
                                    <th>الاسم</th>
                                    <th>الايميل</th>
                                    <th>الشركة</th>
                                    <th>الحالة</th>
                                    <th>عنوان الرسالة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                <tr>
                                    <td>
                                        {{ $contact->id }}
                                    </td>

                                    <td>
                                        {{ $contact->first_name }}
                                    </td>

                                    <td>
                                        {{ $contact->email }}
                                    </td>

                                    <td>
                                        {{ $contact->company??'-' }}
                                    </td>
                                    <td>
                                        @if($contact->read)
                                        <span class="badge badge-outline text-blue">مقروء</span>
                                        @else
                                        <span class="badge badge-outline text-red">غير مقروء</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ Str::limit($contact->title, 50) }}
                                    </td>
                                    <td class="text-end">

                                        <form class="d-none" id="DELETE_{{ $contact->id }}" method="POST"
                                            action="{{ route('contacts.destroy',$contact) }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <div class="btn-group">
                                            @if($contact->read)
                                            <a href="{{ route('contacts.unread',$contact) }}" type="button"
                                                class="btn bg-blue-lt ">تحديد كغير مقروء</a>
                                            @else
                                            <a href="{{ route('contacts.read',$contact) }}" type="button"
                                                class="btn bg-blue-lt ">تحديد كمقروء</a>
                                            @endif


                                            <a href="{{ route('contacts.show',$contact) }}" type="button"
                                                class="btn bg-orange-lt ">اقرأ</a>

                                            <button type="button" data-id="DELETE_{{ $contact->id }}"
                                                data-bs-target="#modal-danger" data-bs-toggle="modal"
                                                class="btn btn-danger delete-btn">حذف</button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </form>
                    <div class="card-footer d-flex align-items-center">
                        {{ $contacts->appends(Arr::except(request()->query(),
                        ['page']))->links('vendor.pagination.adminPaginating') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('dashboard.components.deleteModal')
@endsection