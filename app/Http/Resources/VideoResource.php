<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'url'         => $this->url,
            'description' => $this->description,
            'gallery_id'  => $this->gallery_id,
            'gallery'     => $this->whenLoaded('gallery', fn() => [
                'id'    => $this->gallery->id,
                'title' => $this->gallery->title,
            ]),
            'created_at'  => $this->created_at,
        ];
    }
}
