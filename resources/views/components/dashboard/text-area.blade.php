<div class="form-group mb-3 row">
    <label class="form-label col-3 col-form-label">{{ $label }}<span class="text-danger fw-bold">{{
            $is_mandatory ? '*' : '' }}</span></label>
    <div class="col">
        <textarea type="textarea" class="form-control {{ $input_class ?? '' }}" name="{{ $name }}"
            placeholder="{{ $placeholder }}" minlength="{{ $min }}" maxlength="{{ $max }}" {{ $is_mandatory ? 'required'
            : '' }}>{{ $value ?? old($name) }}</textarea>
        <small class="form-hint">
            {!! $hint !!}
        </small>
    </div>
</div>