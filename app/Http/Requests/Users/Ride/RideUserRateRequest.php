<?php

namespace App\Http\Requests\Users\Ride;

use App\Enums\RideStatusEnum;
use App\Models\Ride;
use App\Rules\RideDriverRatingExists;
use Illuminate\Foundation\Http\FormRequest;

class RideUserRateRequest extends FormRequest
{

    public function prepareForValidation()
    {

        $this->merge(['ride_id' => $this->route('ride')]);
    }
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

            'ride_id' => [
                'required',
                'exists:rides,id',
                function ($attribute, $value, $fail) {
                    // Additional custom validation for ride_id
                    $ride = Ride::find($value);

                    if (!$ride || $ride->status != RideStatusEnum::COMPLETED) {

                        $fail(__('app.The selected ride is not marked as completed, Please make sure you have selected a valid completed ride'));
                    }
                    if (!$ride || $ride->driver_id !== driver_auth()->id()) {
                        $fail(__('app.The selected ride is not associated with the authenticated driver'));
                    }
                },
//                new RideDriverRatingExists($this->input('ride_id'))
            ],
            'rate' => ['required', 'integer', 'between:1,5'],
            'comment' => 'nullable|string|min:1|max:255',

        ];
    }
}
