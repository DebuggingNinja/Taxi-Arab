<div class="form-group mb-3 row">
    <label class="form-label col-3 col-form-label">{{ $label }}<span class="text-danger fw-bold">{{
            $is_mandatory ? '*':'' }}</span></label>
    <div class="col">
        <input type="{{ $type }}" class="form-control {{ $input_class??'' }}" name="{{ $name }}"
            value="{{ $value ?? old($name) }}" placeholder="{{ $placeholder }}" minlength="{{ $min }}"
            maxlength="{{ $max }}" {{ $is_mandatory? 'required' :''}}>
        <small class="form-hint">
            {!! $hint !!}
        </small>
    </div>
</div>