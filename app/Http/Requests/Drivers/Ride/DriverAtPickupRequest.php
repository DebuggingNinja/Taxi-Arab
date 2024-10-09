<?php

namespace App\Http\Requests\Drivers\Ride;

use Illuminate\Foundation\Http\FormRequest;

class DriverAtPickupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return driver_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    public function messages()
    {
        return [
            'latitude.between' => 'The latitude must be a valid value between -90 and 90.',
            'longitude.between' => 'The longitude must be a valid value between -180 and 180.',
        ];
    }
}
