<?php

namespace App\Http\Requests\Notification;

use Illuminate\Foundation\Http\FormRequest;

class NotificationStoreRequest extends FormRequest
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
            'title' => ['required'],
            'msg_content' => ['required'],
            'target' => [
                'required_without:user_token',
                'in:All Drivers,All Male Drivers,All Female Drivers,All Users,All Male Users,All Female Users'
            ],
            'user_token' => [
                'required_without:target',
                'nullable',
                'sometimes'
            ],
            'image' => ['nullable', 'sometimes', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048']
        ];
    }
}
