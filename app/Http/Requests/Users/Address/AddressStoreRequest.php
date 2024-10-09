<?php

namespace App\Http\Requests\Users\Address;

use App\Enums\UserAddressLabelEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'label' => [
                'required',
                Rule::in(UserAddressLabelEnum::getConstants()),
            ],
            'address' => ['required', 'string', 'min:3', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],

        ];
    }

    public function messages()
    {
        return [
            'label.in' => 'The label must be one of: ' . implode(', ', UserAddressLabelEnum::getConstants()),
            'latitude.between' => 'The latitude must be a valid value between -90 and 90.',
            'longitude.between' => 'The longitude must be a valid value between -180 and 180.',
        ];
    }
}
