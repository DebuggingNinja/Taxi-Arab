<div class="card">
    <div class="card-header">
        <ul class="nav nav-tabs card-header-tabs d-flex justify-content-end" data-bs-toggle="tabs">
            @foreach ($sharedLanguages as $language)
            <li class="nav-item">
                <a href="#language-{{ $language->language }}"
                    class="nav-link {{ $language->language == 'en'?'active':'' }}" data-bs-toggle="tab">{{
                    $language->local_name }}</a>
            </li>
            @endforeach
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            @yield('content')
        </div>
    </div>
</div>