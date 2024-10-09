<?php

namespace App\Http\Resources\Users\Profile;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'name'                      => $this->name,
            'device_token'              => $this->device_token,
            'phone_number'              => ($this->phone_number[0] ?? false) === '0' ? $this->phone_number : "0" . $this->phone_number,
            'gender'                    => $this->gender,
            'language'                  => $this->language,
            'profile_image'             => $this->profile_image ? url('uploads/'.$this->profile_image) : null,
            'balance'                   => $this->current_credit_amount,
            'topics'                    => $this->getTopics()
        ];
    }

    public function getTopics(): array
    {
        $topics = ['users'];
        $topics[] = $this->gender == "Male" ? "male_users" : "female_users";
        if(!$this->resource?->rides?->count()) $topics[] = 'non_active_users';
        return $topics;
    }
}
