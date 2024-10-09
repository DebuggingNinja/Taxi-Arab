<div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">مشاهدات</div>
                <div class="ms-auto lh-1">

                    <a class=" text-muted" aria-expanded="false">اخر 30 يوم</a>
                </div>
            </div>
            <div class="h1 mb-3">{{ $dashboard['totalViews'] }} مشاهدة</div>
            <div class="d-flex mb-2">
                <div>نسبة الزوار</div>
                <div class="ms-auto">
                    <span class="text-green d-inline-flex align-items-center lh-1">
                        {{ $dashboard['uniqueViewsPercentage'] }}%

                    </span>
                </div>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-primary" style="width:   {{ $dashboard['uniqueViewsPercentage'] }}%"
                    role="progressbar" aria-valuenow="  {{ $dashboard['uniqueViewsPercentage'] }}" aria-valuemin="0"
                    aria-valuemax="100" aria-label="  {{ $dashboard['uniqueViewsPercentage'] }}%">
                    <span class="visually-hidden"> {{ $dashboard['uniqueViewsPercentage'] }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">عدد التدوينات</div>
                <div class="ms-auto lh-1">

                    <a class=" text-muted" aria-expanded="false">كل الاوقات</a>
                </div>
            </div>
            <div class="h1 mb-3">{{ $dashboard['totalBlogPosts']['total'] }} تدوينات</div>
            <div class="d-flex mb-2">
                <div>نسبة الزيارات من الاجمالي</div>
                <div class="ms-auto">
                    <span class="text-green d-inline-flex align-items-center lh-1">
                        {{ ceil($dashboard['totalBlogPosts']['visits'] * 100 / $dashboard['totalViews']) }}%

                    </span>
                </div>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-primary"
                    style="width: {{ ceil($dashboard['totalBlogPosts']['visits'] * 100 / $dashboard['totalViews']) }}%"
                    role="progressbar"
                    aria-valuenow="{{ ceil($dashboard['totalBlogPosts']['visits'] * 100 / $dashboard['totalViews']) }}"
                    aria-valuemin="0" aria-valuemax="100"
                    aria-label="{{ ceil($dashboard['totalBlogPosts']['visits'] * 100 / $dashboard['totalViews'])}}%">
                    <span class="visually-hidden">{{ $dashboard['totalBlogPosts']['visits'] * 100 /
                        $dashboard['totalViews'] }}%</span>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">عدد الخدمات</div>
                <div class="ms-auto lh-1">

                    <a class=" text-muted" aria-expanded="false">الكل</a>
                </div>
            </div>
            <div class="h1 mb-3">{{ $dashboard['totalServices'] }} خدمات</div>
            @include('dashboard.home.components.dummystats')
        </div>
    </div>
</div>

<div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">رسائل التواصل</div>
                <div class="ms-auto lh-1">

                    <a class=" text-muted" aria-expanded="false">الغير مقروءة</a>
                </div>
            </div>
            <div class="h1 mb-3">{{$dashboard['totalMessages']['unread']}} رسائل</div>
            <div class="d-flex mb-2">
                <div>الاجمالي</div>
                <div class="ms-auto">
                    <span class="text-green d-inline-flex align-items-center lh-1">
                        {{$dashboard['totalMessages']['total']}}
                    </span>
                </div>
            </div>
            <div class="progress progress-sm">
                <div class="progress-bar bg-primary" style="width: {{$dashboard['totalMessages']['percentage']}}%"
                    role="progressbar" aria-valuenow="{{$dashboard['totalMessages']['percentage']}}" aria-valuemin="0"
                    aria-valuemax="100" aria-label="{{$dashboard['totalMessages']['percentage']}}%">
                    <span class="visually-hidden"> {{$dashboard['totalMessages']['percentage']}}%</span>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">عدد المشاريع</div>
                <div class="ms-auto lh-1">

                    <a class=" text-muted" aria-expanded="false">الكل</a>
                </div>
            </div>
            <div class="h1 mb-3">{{ $dashboard['TotalProjects'] }} مشروع</div>
            @include('dashboard.home.components.dummystats')
        </div>
    </div>
</div>


<div class="col-sm-6 col-xl-2 col-lg-3 col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="subheader">عدد العملاء</div>
                <div class="ms-auto lh-1">

                    <a class=" text-muted" aria-expanded="false">الكل</a>
                </div>
            </div>
            <div class="h1 mb-3">{{ $dashboard['totalClients'] }} عميل</div>
            @include('dashboard.home.components.dummystats')
        </div>
    </div>
</div>