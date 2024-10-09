<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterPhoneNameRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'phone_number' => ltrim($this->input('phone_number'), '0')
        ]);
    }

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
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'phone_number' => ['required', 'string', 'min:7', 'max:12', 'unique:users'],
        ];
    }
}
