@extends('dashboard.layouts.indexMaster')
@section('tableTitle','انواع المركبات')
@can('Create.CarType')
@php
$createRoute = route('dashboard.car-types.create');
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
                    <th>الاسم</th>
                    <th>الحالة</th>
                    <th>وضع المرأه</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>{{ $record->enabled ? 'متاح':'غير متاح' }}</td>
                    <td>{{ $record->is_female_type ? 'نعم':'لا' }}</td>
                    <td class="text-end">
                        <div class="btn-group">
                            @if($record->enabled)
                            @can('Disable.CarType')
                            @component('components.dashboard.buttons.button', [
                            'data_id' => null,
                            'form' =>true,
                            'route' => route('dashboard.car-types.disable', $record->id),
                            'cssClass' => 'btn-warning',
                            'disabled' => false,
                            'text' => 'ايقاف'
                            ])
                            @endcomponent
                            @endcan
                            @else
                            @can('Enable.CarType')
                            @component('components.dashboard.buttons.button', ['data_id' =>

                            null,
                            'form' =>true,
                            'route'=>route('dashboard.car-types.enable',$record->id), 'cssClass' =>
                            'btn-success', 'disabled' => false, 'text' => 'تشغيل']) @endcomponent
                            @endcan
                            @endif

                            @can('Show.CarType')
                            @component('components.dashboard.buttons.button', ['data_id' =>
                            null,'route'=>route('dashboard.car-types.show',$record->id), 'cssClass' =>
                            'btn-dark', 'disabled' => false, 'text' => 'عرض']) @endcomponent
                            @endcan @can('Update.CarType')
                            @component('components.dashboard.buttons.update-button', ['route' =>
                            route('dashboard.car-types.edit',$record->id)]) @endcomponent
                            @endcan @can('Disable.CarType')
                            <form class="d-none" id="DELETE_{{ $record->id }}" method="POST"
                                  action="{{ route('dashboard.car-types.destroy', $record) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" data-id="DELETE_{{ $record->id }}"
                                    data-bs-target="#modal-danger" data-bs-toggle="modal"
                                    class="btn btn-danger delete-btn">حذف</button>
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


    @component('components.dashboard.modals.text-modal',[
    'modal_id'=>'add-money-modal',
    'primary_button_text'=>'اضافة',
    'close_button_text'=>'اغلق',
    'title'=>'اضافة رصيد للسائق',
    'modal_body'=>'
    <div>
        <label class="form-label">الرصيد المضاف</label>
        <input type="number" class="form-control rtl" min="0" value="0" />
    </div>
    ',
    ])
    @endcomponent
    @include('dashboard.components.deleteModal')
@endsection
