<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OffersResource extends JsonResource
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
            'name_ar' => $this->name_ar,
            'name_en' => $this->name_en,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'offer_price' => $this->offer_price,
            'trip_id' => $this->trip_id,
        ];
    }
}
