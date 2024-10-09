@extends('dashboard.layouts.indexMaster')
@section('tableTitle','الرحلات')
@section('createRoute', '' )

@section('table')
<div class="card-body py-3 d-flex justify-content-between row">
    <div class="d-flex col-auto  mb-2">
        <div class="text-muted">
            نوع الطلب :
            <div class="mx-2 d-inline-block">
                {{ Form::open([ 'method' => 'get', 'id' =>
                'type']) }}
                @foreach (Arr::except(request()->query(), ['type']) as $key => $get)
                {{ Form::hidden($key, $get, ['type' => 'hidden']) }}
                @endforeach


                @component('components.dashboard.select.advanced-select-filter',[
                'data'=>[
                [
                'key'=>'All',
                'value'=>'عام'
                ],
                [
                'key'=>'Female',
                'value'=>'إناث'
                ],

                ],
                'name'=>'type',
                'keyKey'=>'key',
                'value'=> request()->type,
                'nameKey'=>'value',
                'form_id'=>'type'
                ])
                @endcomponent
                {{ Form::close() }}
            </div>
            حالة الطلب :
            <div class="mx-2 d-inline-block">
                {{ Form::open([ 'method' => 'get', 'id' =>
                'status']) }}
                @foreach (Arr::except(request()->query(), ['status']) as $key => $get)
                {{ Form::hidden($key, $get, ['type' => 'hidden']) }}
                @endforeach


                @component('components.dashboard.select.advanced-select-filter',[
                'data'=>[
                [
                'key'=>'All',
                'value'=>'الجميع'
                ],
                [
                'key'=>'pending',
                'value'=>'قيد الانتظار'
                ],
                [
                'key'=>'accepted',
                'value'=>'مقبول'
                ],
                [
                'key'=>'at_pickup',
                'value'=>'في نقطه التجمع'
                ],
                [
                'key'=>'ongoing',
                'value'=>'في الطريق'
                ],
                [
                'key'=>'completed',
                'value'=>'مكتمل'
                ],
                [
                'key'=>'cancelled',
                'value'=>'ملغي'
                ],
                ],
                'name'=>'status',
                'keyKey'=>'key',
                'value'=> request()->status,
                'nameKey'=>'value',
                'form_id'=>'status'
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
                    <th>اسم السائق</th>
                    <th>اسم المستخدم</th>
                    <th>نوع الطلب</th>
                    <th>حالة الطلب</th>
                    <th>تاريخ ووقت الطلب</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <!-- Record 1 -->
                @forelse ($records as $record)
                <tr>
                    <td>{{ $record->id }}</td>
                    <td>{{ $record->driver?->name }}</td>
                    <td>{{ $record->user?->name }}</td>
                    <td>@component('components.dashboard.badges.badge',[
                        'class'=> $record->type == 'Female'? 'bg-linkedin':'bg-pink',
                        'text'=>$record->type != 'Female'? 'الجميع':'إناث'
                        ])
                        @endcomponent</td>
                    <td>
                        @php
                        $statusText = '';

                        switch ($record->status) {
                        case 'pending':
                        $statusText = 'قيد الانتظار';
                        $class = 'bg-dark';
                        break;

                        case 'accepted':
                        $statusText = 'مقبول';
                        $class = 'bg-success';
                        break;

                        case 'at_pickup':
                        $statusText = 'في مكان الالتقاط';
                        $class = 'bg-info';
                        break;

                        case 'ongoing':
                        $statusText = 'قيد التنفيذ';
                        $class = 'bg-primary';
                        break;

                        case 'completed':
                        $statusText = 'تم الانتهاء';
                        $class = 'bg-secondary';
                        break;

                        case 'cancelled':
                        $statusText = 'تم الإلغاء';
                        $class = 'bg-danger';
                        break;
                        }
                        @endphp

                        @component('components.dashboard.badges.badge', ['class' => $class, 'text' => $statusText])
                        @endcomponent

                    </td>
                    <td class="ltr text-start">{{ \Carbon\Carbon::parse($record->created_at)->format('Y/m/d - H:i:s A ')
                        }}
                    </td>


                    <td class="text-end">
                        <div class="btn-group">

                            @can('Show.Ride')
                            @if(!in_array($record->status, ['completed', 'cancelled']))
                                @component('components.dashboard.buttons.button', [
                                'form' => true,
                                'route' => route('dashboard.rides.cancel',$record->id),
                                'method' => 'POST',
                                'cssClass' => 'btn-danger',
                                'text' => 'إلغاء',
                                'dataArray' => ['method' => 'accept']
                                ])
                                @endcomponent
                            @endif
                            @component('components.dashboard.buttons.button', ['data_id' =>
                            null,'route'=>route('dashboard.rides.show',$record->id), 'cssClass' =>
                            'btn-dark', 'disabled' => false, 'text' => 'عرض']) @endcomponent
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
