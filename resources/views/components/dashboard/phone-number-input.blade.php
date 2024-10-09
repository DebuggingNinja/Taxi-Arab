<div class="form-group mb-3 row">
    <label class="form-label col-3 col-form-label">{{ $label }} <span class="text-danger fw-bold">{{
            $is_mandatory ? '*':'' }}</span></label>
    <div class="col row">
        <div class="col-lg-2 col-sm-4 col-4">
            <select type="text" class="select-countries form-select" name="{{ $keyname }}" {{ $is_mandatory? 'required'
                :''}}>
                @foreach ($countries as $country)
                <option value="{{ $country['phone_code'] }}" {{ $value ? ($value==$country['phone_code'] ? 'selected'
                    :'') : '' }} data-custom-properties="&lt;span class=&quot;flag flag-xs flag-country-{{
                strtolower($country['iso_alpha2']) }}&quot;&gt;&lt;/span&gt;">
                    {{ $country['phone_code'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-10 col-sm-8 col-8">
            <input type="{{ $type }}" class="form-control {{ $input_class??'' }}" name="{{ $name }}"
                value="{{ $phone ?? old($name) }}" placeholder="{{ $placeholder }}" minlength="{{ $min }}"
                maxlength="{{ $max }}" {{ $is_mandatory? 'required' :''}}>
        </div>
        <small class="form-hint">{!! $hint !!}</small>
    </div>

</div>