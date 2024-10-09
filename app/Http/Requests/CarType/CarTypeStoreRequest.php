<?php

namespace App\Http\Requests\CarType;

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
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'price_factor' => ['required', 'numeric', 'min:0'],
            'icon' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'enabled' => ['required', 'boolean'],
            'base_fare' => ['required', 'numeric', 'min:0'],
            'kilometer_fare' => ['required', 'numeric', 'min:0'],
            'late_minute_fare' => ['required', 'numeric', 'min:0'],
            'minimum_fare' => ['required', 'numeric', 'min:0'],
        ];
    }
}
