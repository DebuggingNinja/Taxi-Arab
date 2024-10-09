@if (isset($show) && $show)
<div class="form-group mb-3 row">
    <label class="form-label col-3 col-form-label">{{ $label }} <span class="text-danger fw-bold">{{ $is_mandatory ? '*'
            : '' }}</span></label>
    <div class="col">
        <input type="text" class="form-control" name="{{ $name }}" value="{{ $value }}" readonly style="border: none">
        <small class="form-hint">{!! $hint !!}</small>
    </div>
</div>
@else
<div class="form-group mb-3 row">
    <label class="form-label col-3 col-form-label">{{ $label }} <span class="text-danger fw-bold">{{ $is_mandatory ? '*'
            : '' }}</span></label>
    <div class="col">
        <select type="text" class="form-select advanced-select" name="{{ $name }}" id="" {{ $is_mandatory ? 'required'
            : '' }}>
            <option value="">حدد</option>
            @foreach ($data as $option)
            <option value="{{ $option[$keyKey] }}" {{ $value==$option[$keyKey] ? 'selected' : '' }}>
                {{ $option[$nameKey] }}
            </option>
            @endforeach
        </select>
        <small class="form-hint">{!! $hint !!}</small>
    </div>
</div>
@endif
