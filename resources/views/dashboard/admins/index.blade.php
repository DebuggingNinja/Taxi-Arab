@extends('dashboard.layouts.indexMaster')
@section('tableTitle','الادمن')
@section('createRoute', route('dashboard.admins.create') )

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
                    <th>البريد</th>
                    <th>الدور</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td class="ltr text-start">{{ $record->email }}</td>
                    <td class="ltr text-start">
                        @foreach ($record->roles as $role)
                        @component('components.dashboard.badges.badge',[
                        'class'=> 'bg-primary',
                        'text'=>$role->name
                        ])
                        @endcomponent
                        @endforeach
                    </td>
                    <td class="text-end">
                        <div class="btn-group">



                            @component('components.dashboard.buttons.button', [
                            'route'=> route('dashboard.admins.role',$record->id),
                            'cssClass' => 'bg-info-lt',
                            'data_id' => null,
                            'text' =>'تعديل الدور'
                            ])
                            @endcomponent

                            @component('components.dashboard.buttons.update-button', ['route' =>
                            route('dashboard.admins.edit',$record->id)]) @endcomponent

                            @component('components.dashboard.buttons.delete-button', ['id' => $record->id, 'route' =>
                            route('dashboard.admins.destroy',$record->id)])
                            @endcomponent

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
