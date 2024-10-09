<?php

namespace App\Http\Requests\Drivers;

use App\Enums\ColorsEnum;
use Illuminate\Foundation\Http\FormRequest;

class DriverRegisterRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
//        abort(400, $this->input('is_android'));
        $this->merge([
            'phone_number' => ltrim($this->input('phone_number'), '0')
        ]);
        if($this->input('is_android', false) === "true") $this->merge(['is_android' => 1]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'phone_number' => ['required', 'string', 'min:7', 'max:12', 'unique:drivers'],
            'gender' => ['required', 'in:Male,Female,Femal'],

            'national_id' => ['required', 'string', 'min:7', 'max:17'],
            'vehicle_registration_plate' => ['required', 'string', 'min:2', 'max:10'],
            'vehicle_manufacture_date' => ['required', 'numeric', 'digits:4'],
            'vehicle_color' => ['required', 'string'],
            'vehicle_model' => ['required', 'string', 'min:1', 'max:255'],


            'vehicle_image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'vehicle_license_image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'personal_image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'personal_license_image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'personal_identification_card_image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
            'personal_criminal_records_certificate_image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],

            'device_token' => ['sometimes', 'nullable', 'string'],
            'is_android' => ['sometimes', 'nullable', 'boolean'],
        ];
    }
}
