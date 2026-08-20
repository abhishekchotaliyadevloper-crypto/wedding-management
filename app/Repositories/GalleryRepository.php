<?php

namespace App\Repositories;

use App\Models\GalleryModel;
use App\Repositories\Interfaces\GalleryRepositoryInterface;
use App\Jobs\ProcessGalleryImagesJob;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class GalleryRepository implements GalleryRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = GalleryModel::with(['category', 'media' => fn($q) => $q->where('collection_name', 'cover_image')])
            ->withCount(['media as images_count' => fn($q) => $q->where('collection_name', 'gallery')])
            ->latest();

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['gallery_category_id'])) {
            $query->where('gallery_category_id', $filters['gallery_category_id']);
        }

        return $query->paginate($filters['per_page'] ?? 10, ['*'], 'page', $filters['page'] ?? 1);
    }

    public function findBySlug(string $slug)
    {
        return GalleryModel::with(['category', 'media'])->where('slug', $slug)->firstOrFail();
    }

    public function create(array $data)
    {
        $coverImage = $data['cover_image'] ?? null;

        if (!isset($data['slug']) && isset($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $gallery = GalleryModel::create([
            'title'               => $data['title'],
            'slug'                => $data['slug'],
            'gallery_category_id' => $data['gallery_category_id'],
            'location'            => $data['location'] ?? null,
            'event_date'          => $data['event_date'] ?? null,
        ]);

        if ($coverImage) {
            $gallery->addMedia($coverImage)->toMediaCollection('cover_image');
        }

        return $gallery->fresh()->load(['category', 'media']);
    }

    public function update(int $id, array $data)
    {
        $gallery = GalleryModel::findOrFail($id);

        $coverImage = $data['cover_image'] ?? null;
        unset($data['cover_image']);

        if (isset($data['title']) && !isset($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        $gallery->update([
            'title'               => $data['title'],
            'gallery_category_id' => $data['gallery_category_id'],
            'location'            => $data['location'] ?? null,
            'event_date'          => $data['event_date'] ?? null,
            'slug'                => $data['slug'],
        ]);

        if ($coverImage) {
            $gallery->clearMediaCollection('cover_image');
            $gallery->addMedia($coverImage)->toMediaCollection('cover_image');
        }

        return $gallery->fresh()->load(['category', 'media']);
    }

    public function delete(int $id)
    {
        $gallery = GalleryModel::findOrFail($id);
        $gallery->clearMediaCollection('cover_image');
        $gallery->clearMediaCollection('gallery');
        return $gallery->delete();
    }

    public function addImages(int $id, array $images)
    {
        $gallery = GalleryModel::findOrFail($id);

        $paths = [];
        foreach ($images as $image) {
            $paths[] = $image->store('temp-gallery', 'local');
        }

        ProcessGalleryImagesJob::dispatch($id, $paths);

        return $gallery->fresh()->load('media');
    }

    public function findByIdWithImages(int $id)
    {
        return GalleryModel::with(['media' => fn($q) => $q->where('collection_name', 'gallery')])
            ->where('id', $id)
            ->firstOrFail();
    }

    public function updateImage(int $mediaId, array $data)
    {
        $media = Media::findOrFail($mediaId);
        $media->update(['custom_properties' => array_merge($media->custom_properties, $data)]);
        return $media->fresh();
    }

    public function deleteImage(int $mediaId)
    {
        $media = Media::findOrFail($mediaId);
        $media->delete();
        return true;
    }
}
