<div class="form-group mb-3 row">
    <label class="form-label col-3 col-form-label">{{ $label }} <span class="text-danger fw-bold">{{
            $is_mandatory ? '*':'' }}</span></label>
    <div class="col">
        <select type="text" class="form-select select-countries" name="{{ $name }}" id="" {{ $is_mandatory? 'required'
            :''}}>
            @foreach ($countries as $country)
            <option value="{{ $country['name'] }}" {{ $value ? ($value==$country['name'] ? 'selected' :'') : '' }}
                data-custom-properties="&lt;span class=&quot;flag flag-xs flag-country-{{
                strtolower($country['iso_alpha2']) }}&quot;&gt;&lt;/span&gt;">
                {{ $country['name'] }}</option>
            @endforeach
        </select>
        <small class="form-hint">{!! $hint !!}</small>
    </div>

</div>