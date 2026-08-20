<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    public function toArray($request): array
    {
        $cover = $this->getFirstMedia('cover_image');

        return [
            'id'                  => $this->id,
            'title'               => $this->title,
            'slug'                => $this->slug,
            'location'            => $this->location,
            'event_date'          => $this->event_date,
            'gallery_category_id' => $this->gallery_category_id,
            'category'            => $this->whenLoaded('category', fn() => [
                'id'   => $this->category->id,
                'name' => $this->category->name,
            ]),
            'cover_image_url'     => $cover ? $cover->getUrl() : null,
            'cover_thumb_url'     => $cover ? ($cover->hasGeneratedConversion('thumb') ? $cover->getUrl('thumb') : $cover->getUrl()) : null,
            'images_count'        => $this->images_count ?? $this->getMedia('gallery')->count(),
            'created_at'          => $this->created_at,
        ];
    }
}
