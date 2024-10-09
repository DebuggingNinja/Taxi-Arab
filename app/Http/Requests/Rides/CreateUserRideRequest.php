<?php

namespace App\Http\Requests\Rides;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRideRequest extends FormRequest
{
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
            'pickup_location_latitude' => ['required', 'numeric'],
            'pickup_location_longitude' => ['required', 'numeric'],
            'pickup_location_name' => ['required', 'string', 'min:0', 'max:255'],

            'dropoff_location_latitude' => ['sometimes', 'nullable', 'numeric'],
            'dropoff_location_longitude' => ['sometimes', 'nullable', 'numeric'],
            'dropoff_location_name' => ['sometimes', 'nullable', 'string', 'min:0', 'max:255'],

            'estimated_distance_in_km' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'expected_ride_duration' => ['sometimes', 'nullable', 'date_format:H:i:s'],
            'car_type_id' => ['required', 'integer', 'exists:car_types,id'],
            'type' => ['required', Rule::in(['All', 'Female'])],

        ];
    }
}
