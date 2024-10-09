<?php

namespace App\Http\Requests\Complaint;

use Illuminate\Foundation\Http\FormRequest;

class ComplaintStoreRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        if(user_auth()->check())
            $this->merge(['user_id' => user_auth()?->id()]);
        if(driver_auth()->check())
            $this->merge(['driver_id' => driver_auth()?->id()]);
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
            'driver_id' => ['sometimes', 'nullable', 'exists:drivers,id'],
            'user_id' => ['sometimes', 'nullable', 'exists:users,id'],
            'content' => ['required', 'max:500'],
        ];
    }
}
