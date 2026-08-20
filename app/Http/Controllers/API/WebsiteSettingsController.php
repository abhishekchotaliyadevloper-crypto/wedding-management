<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateWebsiteSettingsRequest;
use App\Http\Requests\UploadHeroSliderImagesRequest;
use App\Models\ContactModel;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class WebsiteSettingsController extends Controller
{
    private function getContact(): ContactModel
    {
        $contact = ContactModel::first();

        if (!$contact) {
            $contact = ContactModel::create([]);
        }

        return $contact;
    }

    public function index()
    {
        $contact = $this->getContact();

        $sliderImages = $contact->getMedia('hero_slider')->map(fn($media) => [
            'id'  => $media->id,
            'url' => $media->getUrl(),
        ]);

        $contentImages = $contact->getMedia('website_content');
        $leftImage  = $contentImages->firstWhere(fn($m) => $m->getCustomProperty('position') === 'left');
        $rightImage = $contentImages->firstWhere(fn($m) => $m->getCustomProperty('position') === 'right');

        return response()->json([
            'success' => true,
            'data'    => [
                'website_content'    => $contact->website_content,
                'hero_slider_images' => $sliderImages,
                'left_side_image'    => $leftImage  ? ['id' => $leftImage->id,  'url' => $leftImage->getUrl()]  : null,
                'right_side_image'   => $rightImage ? ['id' => $rightImage->id, 'url' => $rightImage->getUrl()] : null,
            ],
        ]);
    }

    public function update(UpdateWebsiteSettingsRequest $request)
    {
        $contact = $this->getContact();
        $contact->update(['website_content' => $request->validated()['website_content'] ?? null]);

        return response()->json([
            'success' => true,
            'message' => 'Website content updated successfully.',
        ]);
    }

    public function uploadSliderImages(UploadHeroSliderImagesRequest $request)
    {
        $contact = $this->getContact();
        $uploaded = [];

        foreach ($request->file('images') as $image) {
            $media = $contact->addMedia($image)->toMediaCollection('hero_slider');
            $uploaded[] = [
                'id'  => $media->id,
                'url' => $media->getUrl(),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Images uploaded successfully.',
            'data'    => $uploaded,
        ]);
    }

    public function deleteSliderImage(int $mediaId)
    {
        $media = Media::findOrFail($mediaId);
        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.',
        ]);
    }

    public function uploadContentImage(Request $request)
    {
        $request->validate([
            'position' => 'required|in:left,right',
            'image'    => 'required|image|max:10240',
        ]);

        $contact  = $this->getContact();
        $position = $request->input('position');

        // Remove existing image for this position
        $contact->getMedia('website_content')
            ->filter(fn($m) => $m->getCustomProperty('position') === $position)
            ->each(fn($m) => $m->delete());

        $media = $contact->addMedia($request->file('image'))
            ->withCustomProperties(['position' => $position])
            ->toMediaCollection('website_content');

        return response()->json([
            'success' => true,
            'data'    => ['id' => $media->id, 'url' => $media->getUrl()],
        ]);
    }

    public function deleteContentImage(int $mediaId)
    {
        $media = Media::findOrFail($mediaId);
        $media->delete();

        return response()->json([
            'success' => true,
            'message' => 'Image deleted successfully.',
        ]);
    }
}
