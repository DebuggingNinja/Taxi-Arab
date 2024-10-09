<?php

namespace App\Http\Requests\Rides;

use Illuminate\Foundation\Http\FormRequest;

class UpfrontRideFareRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        if(!$this->has('gender')) $this->merge(['gender' => user_auth()->user()->gender]);
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return user_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'estimated_distance_in_km' => ['sometimes', 'nullable', 'min:0', 'numeric'],
            'gender'                   => ['sometimes', 'nullable', 'in:Male,Female']
        ];
    }
}
