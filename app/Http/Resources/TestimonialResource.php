<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'photo_url'   => $this->getFirstMediaUrl('testimonial_photo') ?: null,
            'created_at'  => $this->created_at,
        ];
    }
}
