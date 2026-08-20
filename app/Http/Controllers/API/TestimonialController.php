<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Services\TestimonialService;
use App\Http\Requests\TestimonialRequest;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function __construct(
        private TestimonialService $service
    ) {}

    public function index(Request $request)
    {
        $testimonials = $this->service->getAllTestimonials(
            $request->only('search', 'page', 'per_page')
        );

        return TestimonialResource::collection($testimonials);
    }

    public function publicIndex()
    {
        $testimonials = \App\Models\TestimonialModel::latest()->get();

        return TestimonialResource::collection($testimonials);
    }

    public function store(TestimonialRequest $request)
    {
        $testimonial = $this->service->createTestimonial($request->validated());

        if ($request->hasFile('photo')) {
            $testimonial->addMediaFromRequest('photo')->toMediaCollection('testimonial_photo');
        }

        return new TestimonialResource($testimonial);
    }

    public function show(int $id)
    {
        return new TestimonialResource($this->service->getTestimonialById($id));
    }

    public function update(TestimonialRequest $request, int $id)
    {
        $testimonial = $this->service->updateTestimonial($id, $request->validated());

        if ($request->hasFile('photo')) {
            $testimonial->clearMediaCollection('testimonial_photo');
            $testimonial->addMediaFromRequest('photo')->toMediaCollection('testimonial_photo');
        }

        return new TestimonialResource($testimonial);
    }

    public function destroy(int $id)
    {
        $this->service->deleteTestimonial($id);

        return response()->json(['message' => 'Testimonial deleted successfully.']);
    }
}
