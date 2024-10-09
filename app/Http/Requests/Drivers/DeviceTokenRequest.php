<?php

namespace App\Http\Requests\Drivers;

use App\Enums\ColorsEnum;
use Illuminate\Foundation\Http\FormRequest;

class DeviceTokenRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        if(in_array($this->input('is_android', false), ['true', '1']))
            $this->merge(['is_android' => 1]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return user_auth()->check() || driver_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'device_token' => ['required', 'string'],
            'is_android' => ['sometimes', 'nullable', 'boolean'],
        ];
    }
}
