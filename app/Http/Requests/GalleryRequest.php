<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $galleryId = $this->route('gallery');
        $id = is_object($galleryId) ? $galleryId->id : $galleryId;

        return [
            'title'               => 'required|string|max:255',
            'gallery_category_id' => 'required|exists:gallery_category,id',
            'location'            => 'nullable|string|max:255',
            'event_date'          => 'nullable|date',
            'cover_image'         => [
                $id ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],
        ];
    }
}
