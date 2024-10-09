<?php

namespace App\Http\Requests\Drivers;

use App\Enums\ColorsEnum;
use Illuminate\Foundation\Http\FormRequest;

class ProfileImageRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'profile_image' => ['required', 'image', 'mimes:jpeg,png', 'max:2048'],
        ];
    }
}