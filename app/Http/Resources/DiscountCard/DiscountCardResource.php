<?php

namespace App\Http\Resources\DiscountCard;

use Illuminate\Http\Resources\Json\JsonResource;

class DiscountCardResource extends JsonResource
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
            'card_number'           => $this->card_number,
            'percentage_amount'     => $this->percentage_amount,
            'valid_from'            => $this->valid_from,
            'valid_to'              => $this->valid_to,
            'repeat_limit'          => $this->repeat_limit,
            'charge_count'          => $this->charge_count,
            'allow_user_to_reuse'   => $this->allow_user_to_reuse,
        ];
    }
}
