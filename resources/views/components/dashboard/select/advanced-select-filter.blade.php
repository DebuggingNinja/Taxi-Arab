<select type="text" class="form-select advanced-select"
    onchange='document.getElementById("{{ $form_id??null }}").submit();' name="{{ $name }}" id="">
    @foreach ($data as $key=> $option)
    <option value="{{ $option[$keyKey] }}" {{ $value==$option[$keyKey]?'selected':'' }}>
        {{ $option[$nameKey] }}</option>
    @endforeach
</select>