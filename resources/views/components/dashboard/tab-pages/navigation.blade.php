<li class="nav-item" role="presentation">
    <a href="#{{ $tabName }}" class="nav-link {{ isset($active)?($active == true?'active':''):'' }}"
        data-bs-toggle="tab" aria-selected="true" role="tab">
        {!! $icon !!}
        {!! $name !!}
    </a>
</li>