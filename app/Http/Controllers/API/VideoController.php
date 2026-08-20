<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Services\VideoService;
use App\Http\Requests\VideoRequest;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function __construct(
        private VideoService $service
    ) {}

    public function index(Request $request)
    {
        $videos = $this->service->getVideos(
            $request->only('search', 'gallery_id', 'page', 'per_page')
        );

        return VideoResource::collection($videos);
    }

    public function store(VideoRequest $request)
    {
        $video = $this->service->createVideo($request->validated());

        return new VideoResource($video);
    }

    public function show(int $id)
    {
        $video = $this->service->getVideoById($id);

        return new VideoResource($video);
    }

    public function update(VideoRequest $request, int $id)
    {
        $video = $this->service->updateVideo($id, $request->validated());

        return new VideoResource($video);
    }

    public function destroy(int $id)
    {
        $this->service->deleteVideo($id);

        return response()->json(['message' => 'Video deleted successfully.']);
    }
}
