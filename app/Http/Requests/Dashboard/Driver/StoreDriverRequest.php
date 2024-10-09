<?php

namespace App\Http\Requests\Dashboard\Driver;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
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
            'name'                                                      => ['required', 'string', 'max:200'],
            'gender'                                                    => ['required', 'in:Male,Female'],
            'national_id'                                               => ['required', 'string', 'max:20'],
            'phone_number'                                              => ['required', 'string', 'min:5', 'max:15'],
            'vehicle_manufacture_date'                                  => ['required', 'integer', 'min:1900', 'max:2100'],
            'vehicle_registration_plate'                                => ['required', 'string', 'max:20'],
            'vehicle_color'                                             => ['required', 'string', 'max:50'],
            'vehicle_model'                                             => ['required', 'string', 'max:50'],
            'vehicle_license_image'                                     => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'personal_identification_card_image'                        => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'vehicle_image'                                             => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'personal_criminal_records_certificate_image'               => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'personal_license_image'                                    => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'personal_image'                                            => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'acceptance_status'                                         => ['required', 'string', 'in:accepted,rejected,pending'],
            'car_types'                                                 => ['required', 'array'],
            'car_types.*'                                               => ['required', 'integer', 'exists:car_types,id'],
        ];
    }
}
