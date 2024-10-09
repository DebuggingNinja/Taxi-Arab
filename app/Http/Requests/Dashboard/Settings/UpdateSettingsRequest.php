<?php

namespace App\Http\Requests\Dashboard\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class UpdateSettingsRequest extends FormRequest
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
            'APP_TAX_PERCENTAGE' => ['required', 'numeric', 'min:0', 'max:99'],
            'CANCELLATION_FEES' => ['required', 'numeric', 'min:0'],
            'RUSH_HOUR_MULTIPLIER' => ['required', 'numeric', 'min:0'],
            'MINIMUM_CREDIT_TO_ACCEPT_RIDE' => ['required', 'numeric', 'min:0'],
            'DRIVER_SEARCH_RADIUS' => ['required', 'numeric', 'min:0'],
            'DRIVER_SEARCH_RETRY_INTERVAL_SECONDS' => ['required', 'numeric', 'min:0'],
            'MAX_ADDRESSES_LIMIT' => ['required', 'numeric', 'min:0'],
            'REWARD_POINT_RATIO' => ['required', 'numeric', 'min:0'],
            'REWARD_MIN' => ['required', 'numeric', 'min:0'],
            'DRIVER_COMPANSATION_FOR_MORE_THAN_2KM' => ['required', 'numeric', 'min:0'],
            'USER_INIT_BALANCE' => ['required', 'numeric', 'min:0'],
            'DISCOUNT_FROM_BALANCE' => ['required', 'numeric', 'min:0'],
            'DRIVER_INIT_BALANCE' => ['required', 'numeric', 'min:0'],
            'MAX_CHARGE_LIMIT' => ['required', 'numeric', 'min:0'],
            'MINIMUM_SPEED_FOR_DELAY_CALCULATION' => ['required', 'numeric', 'min:0'],
            'INVITE_EXPIRY_TIMEOUT' => ['required', 'numeric', 'min:0'],
            'DRIVERS_RINGTONE' => ['nullable', 'file', 'mimes:mp3', 'max:2048'],
            'USERS_RINGTONE' => ['nullable', 'file', 'mimes:mp3', 'max:2048'],
            'AUTO_PICK_DRIVER' => ['nullable', 'in:on,null'],
            'ACTIVATE_ASSET_DRIVER' => ['nullable', 'in:on,null'],
            'ALLOW_PANEL_CHARGE' => ['nullable', 'in:on,null'],
            'SUPPORT_EMAIL' => ['required', 'email'],
            'SUPPORT_PHONE' => ['required', 'numeric'],
            'APP_TERMS' => ['required'],
        ];
    }
}
