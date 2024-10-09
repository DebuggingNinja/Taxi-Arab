@extends('dashboard.layouts.indexMaster')
@section('tableTitle','بطاقات الخصم')
@section('createRoute', '')

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
                    <th class="w-1">منشئ البطاقة</th>
                    <th>القيمة</th>
                    <th>الرقم</th>
                    <th>تاريخ البداية</th>
                    <th>تاريخ النهاية</th>
                    <th>عدد مرات الشحن المسموح بها</th>
                    <th>عدد مرات الشحن</th>
                    <th>إمكانية التكرار</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td>{{ $record->creator?->name }}</td>
                        <td>{{ $record->percentage_amount }}</td>
                        <td>{{ $record->card_number }}</td>
                        <td>{{ $record->valid_from }}</td>
                        <td>{{ $record->valid_to }}</td>
                        <td>{{ $record->repeat_limit }}</td>
                        <td>{{ $record->charge_count }}</td>
                        <td>{{ $record->allow_user_to_reuse ? "نعم" : "لا" }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">لا توجد سجلات</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer d-flex align-items-center">
            {{ $records->appends(Arr::except(request()->query(),
            ['page']))->links('vendor.pagination.adminPaginating') }}
        </div>

@endsection
