<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Services\GalleryService;
use App\Http\Requests\GalleryRequest;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct(
        private GalleryService $service
    ) {}

    public function index(Request $request)
    {
        $galleries = $this->service->getGalleries($request->only('search', 'gallery_category_id', 'page', 'per_page'));

        return GalleryResource::collection($galleries);
    }

    public function store(GalleryRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image');
        }

        $gallery = $this->service->createGallery($data);

        return new GalleryResource($gallery);
    }

    public function show(string $slug)
    {
        $gallery = $this->service->getGalleryBySlug($slug);

        return new GalleryResource($gallery);
    }

    public function update(GalleryRequest $request, int $id)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image');
        }

        $gallery = $this->service->updateGallery($id, $data);

        return new GalleryResource($gallery);
    }

    public function destroy(int $id)
    {
        $this->service->deleteGallery($id);

        return response()->json(['success' => true, 'message' => 'Gallery deleted successfully.']);
    }

    public function addImages(Request $request)
    {
        $request->validate([
            'gallery_id' => 'required|exists:galleries,id',
            'images'     => 'required|array',
            'images.*'   => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        $this->service->addImagesToGallery($request->input('gallery_id'), $request->file('images'));

        return response()->json(['success' => true, 'message' => 'Images added successfully.']);
    }

    public function getImagesById(int $id)
    {
        $gallery = $this->service->getGalleryById($id);

        $images = $gallery->getMedia('gallery')->map(fn($media) => [
            'id'        => $media->id,
            'url'       => $media->getUrl(),
            'thumb_url' => $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl(),
        ]);

        return response()->json(['data' => $images]);
    }

    public function updateImage(Request $request, int $mediaId)
    {
        $request->validate(['alt' => 'nullable|string|max:255']);

        $media = $this->service->updateGalleryImage($mediaId, $request->only('alt'));

        return response()->json([
            'id'        => $media->id,
            'url'       => $media->getUrl(),
            'thumb_url' => $media->hasGeneratedConversion('thumb') ? $media->getUrl('thumb') : $media->getUrl(),
            'alt'       => $media->getCustomProperty('alt'),
        ]);
    }

    public function deleteImage(int $mediaId)
    {
        $this->service->deleteGalleryImage($mediaId);

        return response()->json(['success' => true, 'message' => 'Image deleted successfully.']);
    }
}
