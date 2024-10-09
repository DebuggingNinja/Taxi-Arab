<?php

namespace App\Http\Requests\Dashboard\CarType;

use Illuminate\Foundation\Http\FormRequest;

class CarTypeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'icon' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'is_female_type' => ['nullable', 'in:on,null'],
            'setting.BASE_FARE' => ['required', 'numeric', 'min:0', 'max:200'],
            'setting.KILOMETER_FARE' => ['required', 'numeric', 'min:0', 'max:200'],
            'setting.LATE_MINUTE_FARE' => ['required', 'numeric', 'min:0', 'max:200'],
            'setting.MINIMUM_FARE' => ['required', 'numeric', 'min:0', 'max:200'],
        ];
    }
}
