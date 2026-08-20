<?php

namespace App\Http\Controllers;

use App\Models\GalleryCategoryModel;

class GalleryCategoryPageController extends Controller
{
    /**
     * Display all gallery images belonging to the given category slug.
     * Eager-loads galleries with their media in two queries (no N+1).
     */
    public function show(string $slug)
    {
        // Resolve category or return 404
        $category = GalleryCategoryModel::with([
            'media',
            'galleries.media' => fn ($q) => $q->where('collection_name', 'gallery'),
        ])
            ->where('slug', $slug)
            ->first();

        if (! $category) {
            abort(404, 'Gallery category not found.');
        }

        // Flatten all gallery-collection media across every gallery in this category
        $images = $category->galleries->flatMap(function ($gallery) {
            return $gallery->getMedia('gallery')->map(function ($media) use ($gallery) {
                return [
                    'id'        => $media->id,
                    'title'     => $gallery->title,
                    'thumb_url' => $media->hasGeneratedConversion('thumb')
                        ? $media->getUrl('thumb')
                        : $media->getUrl(),
                    'full_url'  => $media->getUrl(),
                    'alt'       => $media->getCustomProperty('alt') ?: $gallery->title,
                ];
            });
        });

        return view('gallery.category', compact('category', 'images'));
    }
}
