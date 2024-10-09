<div class="form-group mb-3 row">
    <label class="form-label col-3 col-form-label">{{ $label }} <span class="text-danger fw-bold">{{ $is_mandatory ? '*'
            : '' }}</span></label>
    <div class="col">
        <select type="text" multiple="multiple" class="form-select multi-select mceNoEditor"
                data-selected="{{ is_array($value) ? implode(',', $value) : $value }}"
                name="{{ $name }}[]" id="{{ $name }}" {{ $is_mandatory ? 'required'
            : '' }}>
            <option value="">حدد</option>
            @foreach ($data as $option)
            <option value="{{ $option[$keyKey] }}">
                {{ $option[$nameKey] }}
            </option>
            @endforeach
        </select>
        <small class="form-hint">{!! $hint !!}</small>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script>
    let settings = {}, elem = $('#{{ $name }}'), select = new TomSelect('#{{ $name }}',settings),
        str = elem.data('selected').toString();
    if(str) select.setValue(str.includes(',') ? str.split(',') : str);
</script>

