@extends('dashboard.layouts.master')
@section('title','قراءه رسالة')
@section('master')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container" style="zoom:1.2">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">رسالة تواصل <span class="badge bg-{{
                                $Contact->read?'red':'green' }}">{{
                                    $Contact->read?'مقروءة':'غير مقروءه' }}</span></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">

                                <div class="card-body">
                                    <div class="datagrid mb-4">
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">اسم المرسل</div>
                                            <div class="datagrid-content">{{ $Contact->first_name }} {{
                                                $Contact->last_name }}</div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">الشركة</div>
                                            <div class="datagrid-content">{{ $Contact->company??'-' }}</div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">الايميل</div>
                                            <div class="datagrid-content">{{ $Contact->email }}</div>
                                        </div>
                                        <div class="datagrid-item">
                                            <div class="datagrid-title">تاريخ الارسال</div>
                                            <div class="datagrid-content">
                                                {{ $Contact->created_at->format('D d F Y - h:i A') }}</div>
                                        </div>
                                    </div>


                                    <div class="col-12 markdown">
                                        <h3>الرسالة</h3>
                                        <div class=" rounded p-3 my-3"
                                            style="border:1px solid #e7e7e7;     text-align: justify;">
                                            {{ $Contact->message }}
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <form class="d-none" id="DELETE_{{ $Contact->id }}" method="POST"
                                            action="{{ route('contacts.destroy',$Contact) }}">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a href="mailto:{{ $Contact->email }}" class="btn btn-primary">
                                            رد علي الرسالة
                                        </a>
                                        <a href="{{ route('contacts.unread',$Contact) }}" class="btn btn-warning">
                                            حدد كغير مقروء
                                        </a>
                                        <button type="button" data-id="DELETE_{{ $Contact->id }}"
                                            data-bs-target="#modal-danger" data-bs-toggle="modal"
                                            class="btn btn-danger delete-btn">حذف</button>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('dashboard.components.deleteModal')
    @endsection