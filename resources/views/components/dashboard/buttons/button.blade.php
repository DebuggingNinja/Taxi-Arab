<div {!! isset($tooltip) ? ' data-bs-toggle="tooltip" data-bs-placement="top" title="' .$tooltip.'"' : '' !!}
    @isset($data_id) {!! $data_id ? ' data-bs-toggle="modal"' : '' !!} {!! $data_id ? ' data-bs-target="#modal-' .
    (($method=='DELETE' ) ? 'danger"' : "success" .'"') : '' !!} @endisset>

    @if(isset($form) && $form)
    <form action="{{ $route ?? '#' }}" method="{{ $method ?? 'POST' }}" class="d-inline">
        @csrf
        @method($method ?? 'POST')

        <!-- Add hidden input fields for the array data -->
        @foreach ($dataArray ?? [] as $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <button type="submit"
            class="btn me-2 {{ $cssClass }} {{ isset($disabled) ? ($disabled ? ' disabled' : '') : '' }}"
            @isset($data_id) {!! $data_id ? 'data-id="' . $method . '_' . $data_id . '"' : '' !!} @endisset>{!! $text
            !!}</button>
    </form>
    @else
    <a href="{{ $route ?? '#' }}" type="button"
        class="btn me-2 {{ $cssClass }} {{ isset($disabled) ? ($disabled ? ' disabled' : '') : '' }}"
        @isset($data_id){!! $data_id ? 'data-id="' . $method . '_' . $data_id . '"' : '' !!}@endisset>{!! $text !!}</a>
    @endif
</div>