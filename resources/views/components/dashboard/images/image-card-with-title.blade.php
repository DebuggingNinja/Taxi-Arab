<div class="card card-sm m-2 p-2">
    <div class="d-block text-center"><img src="{{ $image_url }}" class="card-img-top"
            style="max-height: {{ $width ?? 220 }}px;width: auto;"></div>
    <div class="card-body">
        <div class="d-flex align-items-center">
            <span class="avatar me-3 rounded" style="background-image: url({{ $image_url }})"></span>
            <div>
                <div>{{ $title }}</div>
            </div>
            <div class="ms-auto">
                <a href="{{ $url }}" class="text-secondary" target="_blank">
                    <!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path>
                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6">
                        </path>
                    </svg>
                    عرض
                </a>
            </div>
        </div>
    </div>
</div>