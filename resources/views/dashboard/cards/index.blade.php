@extends('dashboard.layouts.indexMaster')
@section('tableTitle','سجلات الشحن')
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
                    <th>المستخدم</th>
                    <th>القيمة</th>
                    <th>وقت الشحن</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($records as $record)
                    <tr>
                        <td>{{ $record->creator?->name }}</td>
                        <td>{{ $record->driver?->name ?? $record->user?->name }}</td>
                        <td>{{ $record->amount }}</td>
                        <td>{{ $record->used_at?->format('Y/m/d h:i A') }}</td>
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
