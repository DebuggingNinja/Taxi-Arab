<div class="card h-100">
    <div class="card-header">
        <h3 class="card-title">اكثر 5 تدوينات مشاهدة</h3>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>عنوان</th>
                    <th>مشاهدات</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dashboard['top5Posts'] as $blog)
                <tr>
                    <td>
                        <div>{{ $blog['title'] }}</div>
                    </td>
                    <td class="text-muted">
                        {{ $blog['views'] }}
                    </td>
                    <td>
                        <a href=" {{ route('blog.edit',$blog['id'])  }}"><svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l14 0"></path>
                                <path d="M5 12l6 6"></path>
                                <path d="M5 12l6 -6"></path>
                            </svg></a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    <div class="d-flex align-items-center items-center justify-content-center py-3">
        <a href="{{ route('blog.index') }}">جميع التدوينات</a>
    </div>
</div>