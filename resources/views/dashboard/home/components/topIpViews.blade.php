<div class="card">
    <div class="card-body">
        <h3 class="card-title">اكثر المصادر مشاهدة</h3>
        <table class="table table-sm table-borderless">
            <thead>
                <tr>
                    <th>المصدر</th>
                    <th class="text-end">مشاهدات</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dashboard['topIpVisits'] as $visit)
                <tr>
                    <td>
                        <div class="progressbg">
                            <div class="progress progressbg-progress">
                                <div class="progress-bar bg-primary-lt" style="width: {{ $visit['percent'] }}%"
                                    role="progressbar" aria-valuenow="{{ $visit['percent'] }}" aria-valuemin="0"
                                    aria-valuemax="100" aria-label="{{ $visit['percent'] }}%">
                                    <span class="visually-hidden">{{ $visit['percent'] }}%</span>
                                </div>
                            </div>
                            <div class="progressbg-text">{{ $visit['ip'] }}</div>
                        </div>
                    </td>
                    <td class="w-1 fw-bold text-end">{{ $visit['visits'] }}</td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>