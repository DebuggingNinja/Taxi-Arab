<?php

namespace App\Http\Requests\Dashboard\DiscountCards;

use Illuminate\Foundation\Http\FormRequest;

class CreateDiscountCardsRequest extends FormRequest
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
            'percentage_amount' => ['required', 'numeric', 'min:1', 'max:99', 'unique:discount_cards,card_number'],
            'card_number' => ['required', 'min:1', 'max:99'],
            'valid_from' => ['required', 'date', 'before:valid_to'],
            'valid_to' => ['required', 'date', 'after:valid_from'],
            'repeat_limit' => ['required', 'numeric', 'min:1', 'max:9999'],
        ];
    }
}
