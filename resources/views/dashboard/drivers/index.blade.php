@extends('dashboard.layouts.indexMaster')
@section('tableTitle','السائقين')
@can('Create.Driver')
@php
$createRoute = route('dashboard.drivers.create');
@endphp
@endcan
@section('createRoute', $createRoute??'' )
@section('table')
<div class="card-body py-3 d-flex justify-content-between row">
    <div class="d-flex col-auto  mb-2">
        <div class="text-muted">
            النوع :
            <div class="mx-2 d-inline-block">
                {{ Form::open([ 'method' => 'get', 'id' =>
                'gender']) }}
                @foreach (Arr::except(request()->query(), ['gender']) as $key => $get)
                {{ Form::hidden($key, $get, ['type' => 'hidden']) }}
                @endforeach


                @component('components.dashboard.select.advanced-select-filter',[
                'data'=>[
                [
                'key'=>'All',
                'value'=>'ذكر/انثي'
                ],
                [
                'key'=>'Male',
                'value'=>'ذكر'
                ],
                [
                'key'=>'Female',
                'value'=>'انثي'
                ]
                ],
                'name'=>'gender',
                'keyKey'=>'key',
                'value'=> request()->gender,
                'nameKey'=>'value',
                'form_id'=>'gender'
                ])
                @endcomponent
                {{ Form::close() }}
            </div>
            الحالة :
            <div class="mx-2 d-inline-block">
                {{ Form::open([ 'method' => 'get', 'id' =>
                'acceptance']) }}
                @foreach (Arr::except(request()->query(), ['acceptance']) as $key => $get)
                {{ Form::hidden($key, $get, ['type' => 'hidden']) }}
                @endforeach
                @component('components.dashboard.select.advanced-select-filter',[
                'data'=>[
                [
                'key'=>'All',
                'value'=>'جميع الحالات'
                ],
                [
                'key'=>'pending',
                'value'=>'غير مفعل'
                ],
                [
                'key'=>'rejected',
                'value'=>'مرفوض'
                ],
                [
                'key'=>'accepted',
                'value'=>'مقبول'
                ]
                ],
                'name'=>'acceptance',
                'keyKey'=>'key',
                'value'=> request()->acceptance,
                'nameKey'=>'value',
                'form_id'=>'acceptance'
                ])
                @endcomponent
                {{ Form::close() }}
            </div>
            الحظر :
            <div class="mx-2 d-inline-block">
                {{ Form::open([ 'method' => 'get', 'id' =>
                'blocked']) }}
                @foreach (Arr::except(request()->query(), ['blocked']) as $key => $get)
                {{ Form::hidden($key, $get, ['blocked' => 'hidden']) }}
                @endforeach


                @component('components.dashboard.select.advanced-select-filter',[
                'data'=>[
                [
                'key'=>'All',
                'value'=>'الكل'
                ],
                [
                'key'=>'1',
                'value'=>'محظور'
                ],
                [
                'key'=>'0',
                'value'=>'غير محظور'
                ],

                ],
                'name'=>'blocked',
                'keyKey'=>'key',
                'value'=> request()->blocked,
                'nameKey'=>'value',
                'form_id'=>'blocked'
                ])
                @endcomponent
                {{ Form::close() }}
            </div>
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
                    <th>النوع</th>
                    <th>رقم الهاتف</th>
                    <th>الحالة</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->name }}</td>
                    <td>@component('components.dashboard.badges.badge',[
                        'class'=> $record->gender == 'Male'? 'bg-linkedin':'bg-pink',
                        'text'=>$record->gender == 'Male'? 'ذكر':'انثى'
                        ])
                        @endcomponent</td>
                    <td class="ltr text-start">{{ $record->phone_number }}</td>
                    <td>
                        @if($record->acceptance_status == 'pending')
                        @component('components.dashboard.badges.badge',[
                        'class'=>'bg-dark',
                        'text'=> 'غير مفعل'
                        ])
                        @endcomponent
                        @elseif($record->acceptance_status == 'accepted')
                        @component('components.dashboard.badges.badge',[
                        'class'=>'bg-success',
                        'text'=> 'مقبول'
                        ])
                        @endcomponent
                        @else
                        @component('components.dashboard.badges.badge',[
                        'class'=>'bg-danger',
                        'text'=> 'مرفوض'
                        ])
                        @endcomponent
                        @endif
                    </td>

                    <td class="text-end">
                        <div class="btn-group">
                            @if($record->is_blocked)
                            @can('Unblock.Driver')
                            @component('components.dashboard.buttons.button', [
                            'data_id' => null,
                            'form' =>true,
                            'route' => route('dashboard.drivers.unblock', $record->id),
                            'cssClass' => 'btn-success',
                            'disabled' => false,
                            'text' => 'فك حظر'
                            ])
                            @endcomponent
                            @endcan
                            @else
                            @can('Block.Driver')
                            @component('components.dashboard.buttons.button', ['data_id' =>

                            null,
                            'form' =>true,
                            'route'=>route('dashboard.drivers.block',$record->id), 'cssClass' =>
                            'btn-warning', 'disabled' => false, 'text' => 'حظر']) @endcomponent
                            @endcan
                            @endif

                            @if($record->acceptance_status == 'pending')
                            @can('Accept.Driver')
                            @component('components.dashboard.buttons.button', [
                            'form' => true,
                            'route' => route('dashboard.drivers.acceptance',$record->id),
                            'method' => 'POST',
                            'cssClass' => 'btn-success',
                            'text' => 'قبول',
                            'dataArray' => ['method' => 'accept']
                            ]) @endcomponent
                            @endcan
                            @can('Reject.Driver')
                            @component('components.dashboard.buttons.button', [
                            'form' => true,
                            'route' => route('dashboard.drivers.acceptance',$record->id),
                            'method' => 'POST',
                            'cssClass' => 'btn-instagram me-4',
                            'text' => 'رفض',
                            'dataArray' => ['method' => 'reject']
                            ]) @endcomponent
                            @endcan


                            @endif

                            @can('Show.Driver')
                            @component('components.dashboard.buttons.button', ['data_id' =>
                            null,'route'=>route('dashboard.drivers.show',$record->id), 'cssClass' =>
                            'btn-dark', 'disabled' => false, 'text' => 'عرض']) @endcomponent
                            @endcan
                            @can('Notify.Driver')
                                @if($record->device_token)
                                <div>
                                    @component('components.dashboard.modals.multi-input-modal',[
                                        'col_size'=>'12',
                                        'button_text'=>'إشعار',
                                        'button_class'=>'btn btn-cyan me-2',
                                        'inputs'=> [
                                            ['name' => 'title', 'label' => 'عنوان الإشعار'],
                                            ['name' => 'msg_content', 'type' => 'textarea', 'label' => 'محتوى الإشعار'],
                                            ['name' => 'user_token', 'type' => 'hidden', 'value' => $record->device_token],
                                        ],
                                        'submit_route'=> route('dashboard.notifications.store'),
                                        'save_button_text'=>'إرسال',
                                        'close_button_text'=>'اغلق',
                                        'title'=>'إرسال إشعار'
                                    ]) @endcomponent
                                </div>
                                @endif
                            @endcan
                            @can('Update.Driver')
                            @component('components.dashboard.buttons.update-button', ['route' =>
                            route('dashboard.drivers.edit',$record->id)]) @endcomponent
                            @endcan
                            @can('Delete.Driver')
                            @component('components.dashboard.buttons.delete-button', ['id' => $record->id, 'route' =>
                            route('dashboard.drivers.destroy',$record->id)])
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
    @endsection
