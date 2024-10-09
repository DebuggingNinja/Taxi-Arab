<?php

namespace App\Http\Resources\CarTypeSettings;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CarTypeSettingsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return collect(parent::toArray($request))->flatMap(function ($item) {
            return $item;
        })->toArray();
    }
}
