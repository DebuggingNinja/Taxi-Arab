<?php

namespace App\Http\Resources\CarType;

use App\Http\Resources\CarTypeSettings\CarTypeSettingsCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CarTypeResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            //'price_factor' => $this->price_factor,
            'icon' => asset(Storage::url($this->icon)),
            //'settings' => $this->whenLoaded('settings', fn () => new CarTypeSettingsCollection($this->settings))
        ];
    }
}
