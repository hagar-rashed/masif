<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResearchResource extends JsonResource
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
            'id'           => $this->id,
            'type'         => $this->type,
            'title'        => $this->title,
            'publish_date' => $this->publish_date,
            'hijri_date'   => $this->hijri_date,
            'desc'         => strip_tags($this->desc),
            'pages'        => $this->pages,
            'folders'      => $this->folders,
            'downloads'    => $this->downloads,
            'image'        => url('storage/' . $this->image),
            'file'         => url('storage/' . $this->file),
            'views'        => $this->views,
            'keywords'     => json_decode($this->keywords)
        ];
    }
}
