@extends('dashboard.layouts.indexMaster')
@section('tableTitle','المستخدمين')
@can('Create.User')
    @php
        $createRoute = route('dashboard.users.create');
    @endphp
@endcan
@section('createRoute', $createRoute??'' )

@section('table')
    <div class="card-body py-3 d-flex justify-content-between row">
        <div class="d-flex col-auto  mb-2">
            <div class="text-muted">
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

                        <td class="text-end">
                            <div class="btn-group">
                                @if($record->is_blocked)
                                    @can('Unblock.User')
                                        @component('components.dashboard.buttons.button', [
                                        'data_id' => null,
                                        'form' =>true,
                                        'route' => route('dashboard.users.unblock', $record->id),
                                        'cssClass' => 'btn-success',
                                        'disabled' => false,
                                        'text' => 'فك حظر'
                                        ])
                                        @endcomponent
                                    @endcan
                                @else @can('Block.User')
                                    @component('components.dashboard.buttons.button', ['data_id' =>

                                    null,
                                    'form' =>true,
                                    'route'=>route('dashboard.users.block',$record->id), 'cssClass' =>
                                    'btn-warning', 'disabled' => false, 'text' => 'حظر']) @endcomponent @endcan
                                @endif

                                @can('Notify.User')
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
                                @can('Show.User')
                                    @component('components.dashboard.buttons.button', ['data_id' =>
                                    null,'route'=>route('dashboard.users.show',$record->id), 'cssClass' =>
                                    'btn-dark', 'disabled' => false, 'text' => 'عرض']) @endcomponent
                                @endcan
                                @can('Update.User')
                                    @component('components.dashboard.buttons.update-button', ['route' =>
                                    route('dashboard.users.edit',$record->id)]) @endcomponent
                                @endcan
                                @can('Delete.User')
                                    @component('components.dashboard.buttons.delete-button', ['id' => $record->id, 'route' =>
                                    route('dashboard.users.destroy',$record->id)])
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
{{--        @can('Notify.User')--}}
{{--            @component('components.dashboard.modals.text-modal',[--}}
{{--            'modal_id'=>'notification-modal',--}}
{{--            'primary_button_text'=>'ارسل',--}}
{{--            'close_button_text'=>'اغلق',--}}
{{--            'title'=>'ارسال اشعار للمستخدم',--}}
{{--            'modal_body'=>'--}}
{{--            <div>--}}
{{--                <form method="post" action="' . route('dashboard.notifications.store') . '">--}}
{{--                <label class="form-label">عنوان الاشعار</label>--}}
{{--                <input class="form-control" name="name">--}}
{{--                <input class="form-control" type="hidden" name="user_id">--}}
{{--                <label class="form-label">رسالة الاشعار</label>--}}
{{--                <textarea class="form-control" name="text"></textarea>--}}
{{--            </div>--}}
{{--            ',--}}
{{--            ])--}}
{{--            @endcomponent--}}
{{--        @endcan--}}
    </div>
@endsection
