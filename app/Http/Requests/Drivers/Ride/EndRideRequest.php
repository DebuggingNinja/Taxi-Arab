<?php

namespace App\Http\Requests\Drivers\Ride;

use Illuminate\Foundation\Http\FormRequest;

class EndRideRequest extends FormRequest
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
            'actual_distance' => ['required', 'numeric', 'min:0']
        ];
    }
}