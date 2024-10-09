@if ($type == 'hidden')
<input type="{{ $type }}" name="{{ $name }}" value="{{ $value ?? old($name) }}">
@else
<div class="form-group mb-3 row">
    <label class="form-label col-3 col-form-label">{{ $label }}<span class="text-danger fw-bold">{{ $is_mandatory ? '*'
            : '' }}</span></label>
    <div class="col">
        @if(isset($url))
        <a href="{{ $url }}" class="form-control {{ $input_class ?? '' }}" style="text-decoration: underline; {{ (isset($show) && $show)
            ? 'border:none;' : '' }}" {{ isset($is_slug) ? 'data-slugify' : '' }}>
            {{ $value ?? old($name) }}
        </a>
        @else
        <input {{ (isset($readonly) && $readonly) || (isset($show) && $show) ? 'readonly' : '' }} {{ (isset($show) &&
            $show) ? 'style=border:none;' : '' }} type="{{ $type }}" class="form-control {{ $input_class ?? '' }}"
            name="{{ $name }}" value="{{ $value ?? old($name) }}"
            placeholder="{{ (isset($show) && $show) ? '-':($placeholder ?? "") }}"
               @if($min ?? false) minlength="{{ $min }}" @endif
               @if($max ?? false) maxlength="{{ $max }}" @endif
            {{ $is_mandatory ? 'required' : '' }} {{ isset($is_slug) ? 'data-slugify' : '' }}>
        @endif
        <small class="form-hint">
            {!! $hint !!}
        </small>
    </div>
</div>

@if (isset($is_slug))
<script>
    // Function to generate a slug from a string
            function slugify(text) {
                return text
                    .toLowerCase()
                    .replace(/\s+/g, '-')
                    .replace(/[^a-zA-Z0-9-\u00C0-\u017F\u0600-\u06FF]+/g, '')
                    .replace(/-{2,}/g, '-');
            }

            // jQuery document ready function
            $(document).ready(function () {
                $('input[name="{{ $is_slug }}"]').on('input', function () {
                    const input = $(this);
                    const slugifiedValue = slugify(input.val());
                    $('input[name="{{ $name }}"]').val(slugifiedValue);
                });
            });
</script>
@endif
@endif
