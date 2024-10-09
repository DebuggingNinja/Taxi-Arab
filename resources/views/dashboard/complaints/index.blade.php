@extends('dashboard.layouts.indexMaster')
@section('tableTitle','الشكاوى')
@section('createRoute', '' )

@section('table')
    <div class="card-body py-3 d-flex justify-content-between row">
        <div class="d-flex col-auto  mb-2">
            {{--        <div class="text-muted">--}}
            {{--            حالة الشكوى:--}}
            {{--            <div class="mx-2 d-inline-block">--}}
            {{--                @component('components.dashboard.select.advanced-select-filter',[--}}
            {{--                'data'=>[--}}
            {{--                [--}}
            {{--                'key'=>'',--}}
            {{--                'value'=>'الجميع'--}}
            {{--                ],--}}
            {{--                [--}}
            {{--                'key'=>'ongoing',--}}
            {{--                'value'=>'قيد العمل'--}}
            {{--                ],--}}
            {{--                [--}}
            {{--                'key'=>'resolved',--}}
            {{--                'value'=>'تم المعالجة'--}}
            {{--                ]--}}
            {{--                ],--}}
            {{--                'name'=>'test',--}}
            {{--                'keyKey'=>'key',--}}
            {{--                'value'=> '',--}}
            {{--                'nameKey'=>'value',--}}
            {{--                ])--}}
            {{--                @endcomponent--}}
            {{--            </div>--}}
            {{--            نوع الشكوي:--}}
            {{--            <div class="mx-2 d-inline-block">--}}
            {{--                @component('components.dashboard.select.advanced-select-filter',[--}}
            {{--                'data'=>[--}}
            {{--                [--}}
            {{--                'key'=>'',--}}
            {{--                'value'=>'سائقين/مستخدمين'--}}
            {{--                ],--}}
            {{--                [--}}
            {{--                'key'=>'drivers',--}}
            {{--                'value'=>'سائقين'--}}
            {{--                ],--}}
            {{--                [--}}
            {{--                'key'=>'users',--}}
            {{--                'value'=>'مستخدمين'--}}
            {{--                ]--}}
            {{--                ],--}}
            {{--                'name'=>'test',--}}
            {{--                'keyKey'=>'key',--}}
            {{--                'value'=> '',--}}
            {{--                'nameKey'=>'value',--}}
            {{--                ])--}}
            {{--                @endcomponent--}}
            {{--            </div>--}}
            {{--        </div>--}}
            <div class="d-flex col-auto">

            </div>
        </div>
        <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable" id="users-table">
                <thead>
                <tr>
                    <th class="w-1">رقم تعريفي</th>
                    <th>المرسل</th>
                    <th>رقم الهاتف</th>
                    <th>الشكوى</th>
                    <th>تاريخ الشكوى</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <!-- Record 1 -->

                @forelse ($records as $record)
                    <tr>
                        <td>{{ $record->id }}</td>
                        <td>{{ $record->driver?->name ?? $record->user?->name ?? $record->name}}</td>
                        <td>
                            <div class="d-flex gap-4">
                                @if($record->driver?->phone_number ?? $record->user?->phone_number)
                                <a href="tel:{{ $record->driver?->phone_number ?? $record->user?->phone_number}}">
                                    {{ $record->driver?->phone_number ?? $record->user?->phone_number}}
                                </a>
                                <a target="_blank" class="text-sm"
                                   href="https://api.whatsapp.com/send?phone={{ $record->driver?->phone_number ?? $record->user?->phone_number}}">
                                    واتساب
                                </a>
                                @else
                                    <span>Support message</span>
                                    <a href="mailto:{{ $record->email }}">
                                        {{ $record->driver?->email }}
                                    </a>
                                @endif
                            </div>
                        </td>
                        <td>{{ $record->content }}</td>
                        <td>{{ $record->created_at?->format('Y/m/d h:i A') }}</td>
                        <td>
                            <form id="DELETE_{{ $record->id }}" method="POST"
                                  action="{{ route('dashboard.complaints.destroy', $record) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-id="DELETE_{{ $record->id }}"
                                        class="btn btn-danger delete-btn">حذف</button>
                            </form>
                        </td>
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
