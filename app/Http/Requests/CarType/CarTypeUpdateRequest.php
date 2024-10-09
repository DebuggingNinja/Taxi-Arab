<?php

namespace App\Http\Requests\CarType;

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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'name' => ['sometimes', 'string', 'min:3', 'max:255'],
            'price_factor' => ['sometimes', 'numeric', 'min:0'],
            'icon' => ['sometimes', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'enabled' => ['sometimes', 'boolean'],
            'base_fare' => ['sometimes', 'numeric', 'min:0'],
            'kilometer_fare' => ['sometimes', 'numeric', 'min:0'],
            'late_minute_fare' => ['sometimes', 'numeric', 'min:0'],
            'minimum_fare' => ['sometimes', 'numeric', 'min:0'],
        ];
    }
}
