@extends('dashboard.layouts.indexMaster')
@section('tableTitle','المستخدمين المحظورين')
@section('createRoute', '' )

@section('table')
<div class="card-body py-3 d-flex justify-content-between row">
    <div class="d-flex col-auto  mb-2">
        <div class="text-muted">

        </div>
        <div class="d-flex col-auto">

        </div>
    </div>
    <div class="table-responsive">
        <table class="table card-table table-vcenter text-nowrap datatable" id="users-table">
            <thead>
                <tr>
                    <th class="w-1">رقم تعريفي</th>
                    <th>اسم المستخدم</th>
                    <th>تاريخ الحظر</th>
                    <th>سبب الحظر</th>

                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- Record 1 -->
                <tr>
                    <td>1</td>
                    <td>محمد عبد الجواد</td>
                    <td>17/08/2023 05:46 PM</td>
                    <td>عدم دفع الاجره بالقوه</td>
                    <td class="text-end">
                        <div class="btn-group">
                            @component('components.dashboard.buttons.button', ['data_id' => null, 'cssClass' =>
                            'btn-primary', 'disabled' => false, 'text' => 'فك الحظر']) @endcomponent
                        </div>
                    </td>
                </tr>


            </tbody>
        </table>
    </div>
    <div class="card-footer d-flex align-items-center">
        <!-- Additional content for the card footer if needed -->
    </div>

    @endsection