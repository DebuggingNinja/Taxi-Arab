<div {!! isset($tooltip)?' data-bs-toggle="tooltip" data-bs-placement="top" title="'.$tooltip.'"' :''!!}
{!! $properties ?? '' !!} >

    <a href=" {{ $route ?? "#" }}" type="button"
    class="btn me-2 {{ $cssClass }} {{ isset($disabled)?($disabled?' disabled':''):'' }}">{!! $text !!}</a>
</div>