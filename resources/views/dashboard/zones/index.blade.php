@extends('dashboard.layouts.indexMaster')
@section('tableTitle','المناطق')
@can('Create.Zone')
@php
$createRoute = route('dashboard.zones.create');
@endphp
@endcan
@section('createRoute', $createRoute??'' )
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
                    <th>اسم المنطقه</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>

                    <td class="text-end">
                        <div class="btn-group">
                            @component('components.dashboard.buttons.button', ['cssClass'=>'btn-dark','text'=>'اظهر
                            في الخريطه', 'route' =>
                            polygonToUrl($record->polygon) ])
                            @endcomponent
                            @can('Delete.Zone')
                            @component('components.dashboard.buttons.delete-button', ['id' => $record->id, 'route' =>
                            route('dashboard.zones.destroy',$record->id)])
                            @endcomponent
                            @endcan
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">لا توجد سجلات</td>
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