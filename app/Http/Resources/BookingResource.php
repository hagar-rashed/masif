<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'prices' => $this->prices,
            'user_id' => $this->user_id,
            'unit_id' => $this->unit_id,
            'trip_id' => $this->trip_id,
            'status' => $this->status,
        ];
    }
}
