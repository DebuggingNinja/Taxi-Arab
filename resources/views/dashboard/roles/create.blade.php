@extends('dashboard.layouts.master')
@section('title', 'انشاء دور جديد')
@section('master')
<div class="page-wrapper">
    <div class="page-body">
        <div class="container-fluid">
            <div class="row row-cards">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">انشاء دور جديد</h3>
                        </div>
                        <div class="card-body">
                            <form accept-charset="utf-8" enctype="multipart/form-data"
                                action="{{ route('dashboard.roles.store') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card mb-3 border-none" style="border: none;">
                                            <div class="card-header" style="border: none;background: #f0f5f9;">
                                                <h3 class="card-title">اسم الدور</h3>
                                            </div>
                                            <div class="card-body ">
                                                <div class="form-group mb-3 row">
                                                    <label class="form-label col-3 col-form-label">اسم الدور</label>
                                                    <div class="col">
                                                        <input type="text" class="form-control" name="role_name"
                                                            placeholder="مدير">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="card mb-3 border-none" style="border: none;">
                                            <div class="card-header" style="border: none;background: #f0f5f9;">
                                                <h3 class="card-title">اوامر سريعه</h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <button type="button" class="btn btn-danger" id="uncheck-all">إلغاء
                                                    تحديد الكل</button>
                                                <button type="button" class="btn btn-success" id="check-all">
                                                    تحديد الكل</button>
                                            </div>
                                        </div>
                                        @foreach ([
                                        'لوحة التحكم'
                                        =>[
                                        'Show.Dashboard' => 'عرض لوحة التحكم',
                                        ],
                                        'إدارة المستخدمين'
                                        =>[
                                        'List.User' => 'عرض المستخدمين',
                                        'Show.User' => 'تفاصيل المستخدم',
                                        'Update.User' => 'تحديث المستخدم',
                                        'Delete.User' => 'حذف المستخدم',
                                        'Create.User' => 'إنشاء المستخدم',
                                        'Block.User' => 'حظر المستخدم',
                                        'Unblock.User' => 'إلغاء حظر المستخدم',
                                        'Notify.User' => 'إشعار المستخدم'
                                        ],

                                        'إدارة الأدوار'
                                        =>[
                                        'List.Role' => 'عرض الأدوار',
                                        'Update.Role' => 'تحديث الدور',
                                        'Delete.Role' => 'حذف الدور',
                                        'Create.Role' => 'إنشاء الدور',
                                        ],
                                        'إدارة السائقين'
                                        =>[ 'List.Driver' => 'عرض السائقين',
                                        'Show.Driver' => 'تفاصيل السائق',
                                        'Update.Driver' => 'تحديث السائق',
                                        'Delete.Driver' => 'حذف السائق',
                                        'Create.Driver' => 'إنشاء السائق',
                                        'Block.Driver' => 'حظر السائق',
                                        'Unblock.Driver' => 'إلغاء حظر السائق',
                                        'Notify.Driver' => 'إشعار السائق',
                                        'Accept.Driver' => 'قبول السائق',
                                        'Reject.Driver' => 'رفض السائق',
                                        ],
                                        'إدارة الرحلات'
                                        =>[
                                        'List.Ride' => 'عرض الرحلات',
                                        'Show.Ride' => 'تفاصيل الرحلة',
                                        ],
                                        'إدارة انواع السيارات'
                                        =>[
                                        'Enable.CarType' => 'تشغيل نوع مركبه',
                                        'Disable.CarType' => 'تعطيل نوع مركبه',
                                        'Show.CarType' => 'تفاصيل نوع مركبه',
                                        'List.CarType' => 'عرض انواع المركبات',
                                        'Create.CarType' => 'انشاء نوع مركبه',
                                        'Update.CarType' => 'تحديث نوع مركبه',

                                        ],
                                        'إدارة الشكاوي'
                                        =>[
                                        'List.Complaint' => 'عرض الشكاوي',
                                        'Show.Complaint' => 'تفاصيل الشكوى',
                                        'Approve.Complaint' => 'موافقة على الشكوى',
                                        ],
                                        'إدارة المناطق'
                                        =>[
                                        'List.Zone' => 'عرض المناطق',
                                        'Delete.Zone' => 'حذف المنطقة',
                                        'Create.Zone' => 'إنشاء المنطقة',
                                        ],
                                        'إدارة الإعدادات'
                                        =>[
                                        'Show.Setting' => 'عرض الإعدادات',
                                        'Update.Setting' => 'تحديث الإعدادات',
                                        ],
                                        'إدارة البطاقات'
                                        =>[
                                        'Create.Card' => 'إنشاء البطاقة',
                                        'List.Card' => 'عرض سجلات الشحن',

                                        ],
                                        'إدارة الاشعارات'
                                        =>[
                                        'Send.Notification' => 'إرسال الإشعار',
                                        ],

                                        ] as $section=>$permissions)
                                        <!-- User Management Permissions -->
                                        <div class="col-12">
                                            <div class="card mb-3 border-none" style="border: none;">
                                                <div class="card-header" style="border: none;background: #f0f5f9;">
                                                    <h3 class="card-title">{{ $section }}</h3>
                                                </div>
                                                <div class="card-body ">
                                                    <div class="form-group mb-3 row">
                                                        @foreach ($permissions as $key => $permission)
                                                        <div class="col-lg-2 col-md-4 col-6">
                                                            <label class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="{{ $key }}">
                                                                <span class="form-check-label">{{ $permission }}</span>
                                                            </label>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @endforeach


                                        <!-- Add more permissions for other modules as needed -->
                                        <div class="form-footer text-right">
                                            <button type="submit" class="btn btn-primary">حفظ</button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('uncheck-all').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = false;
        });
    });
</script>
<script>
    document.getElementById('check-all').addEventListener('click', function() {
        var checkboxes = document.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = true;
        });
    });
</script>

@endsection
