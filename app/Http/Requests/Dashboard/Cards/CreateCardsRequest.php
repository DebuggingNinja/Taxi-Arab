<?php

namespace App\Http\Requests\Dashboard\Cards;

use Illuminate\Foundation\Http\FormRequest;

class CreateCardsRequest extends FormRequest
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
            'category'      => ['required', 'in:Driver,User'],
            'amount'        => ['required', 'numeric', 'min:1', 'max:1000'],
            'card_repeat'   => ['required', 'numeric', 'min:1', 'max:1000'],
        ];
    }
}
