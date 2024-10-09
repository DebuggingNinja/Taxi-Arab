<?php

namespace App\Http\Requests\Dashboard\CarType;

use Illuminate\Foundation\Http\FormRequest;

class CarTypeUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:200'],
            'icon' => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'is_female_type' => ['sometimes', 'nullable', 'in:on,null'],
            'setting.BASE_FARE' => ['sometimes', 'numeric', 'min:0', 'max:200'],
            'setting.KILOMETER_FARE' => ['sometimes', 'numeric', 'min:0', 'max:200'],
            'setting.LATE_MINUTE_FARE' => ['sometimes', 'numeric', 'min:0', 'max:200'],
            'setting.MINIMUM_FARE' => ['sometimes', 'numeric', 'min:0', 'max:200'],
        ];
    }
}
