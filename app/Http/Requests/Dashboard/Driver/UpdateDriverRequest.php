<?php

namespace App\Http\Requests\Dashboard\Driver;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverRequest extends FormRequest
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
            'name'                                          => ['sometimes', 'string', 'max:200'],
            'gender'                                        => ['sometimes', 'in:Male,Female'],
            'national_id'                                   => ['sometimes', 'string', 'max:20'],
            'phone_number'                                  => ['sometimes', 'string', 'min:5', 'max:15'],
            'vehicle_manufacture_date'                      => ['sometimes', 'integer', 'min:1900', 'max:2100'],
            'vehicle_registration_plate'                    => ['sometimes', 'string', 'max:20'],
            'vehicle_color'                                 => ['sometimes', 'string', 'max:50'],
            'vehicle_model'                                 => ['sometimes', 'string', 'max:50'],
            'vehicle_license_image'                         => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'personal_identification_card_image'            => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'vehicle_image'                                 => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'personal_criminal_records_certificate_image'   => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'personal_license_image'                        => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'personal_image'                                => ['sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'acceptance_status'                             => ['sometimes', 'string', 'in:accepted,rejected,pending'],
            'car_types'                                     => ['sometimes', 'array'],
            'car_types.*'                                   => ['sometimes', 'integer', 'exists:car_types,id'],
            'is_asset'                                      => ['sometimes'],

        ];
    }
}
