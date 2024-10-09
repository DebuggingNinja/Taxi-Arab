<?php

namespace App\Http\Requests\Dashboard\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdminRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'min:2', 'max:200'],
            'email' => [
                'sometimes',
                'email',
                'min:3',
                'max:255',
                Rule::unique('admins', 'email')->ignore($this->route('admin')),
            ],
            'password' => [
                'sometimes',
                'nullable',
                'min:8',
                'max:50',
                'different:name',
            ],

        ];
    }
}
