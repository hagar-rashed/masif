<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id'       => $this->id,
            'title'    => $this->title,
            'desc'     => $this->desc,
            'url'      => $this->url,
            'keywords' => json_decode($this->keywords)
        ];
    }
}
