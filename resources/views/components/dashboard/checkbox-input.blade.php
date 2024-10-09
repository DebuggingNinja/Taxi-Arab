<div class="form-group mb-3 row">
    <label class="form-check-label col-3 col-form-label" for="{{ $name }}">{{ $label }}</label>
    <div class="col">
        <div class="form-check form-switch">
            <input type="checkbox" id="{{ $name }}" class="text-start form-check-input my-3"
                   name="{{ $name }}" {{ $value ? "checked" : "" }}>
        </div>
    </div>
</div>
