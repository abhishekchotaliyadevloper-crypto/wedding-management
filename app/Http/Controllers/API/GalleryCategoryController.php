<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryCategoryResource;
use App\Services\GalleryCategoryService;
use App\Http\Requests\GalleryCategoryRequest;

class GalleryCategoryController extends Controller
{
    public function __construct(
        private GalleryCategoryService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->service->getCategories();

        return GalleryCategoryResource::collection(
            $categories
        );
    }

    public function publicIndex()
    {
        $categories = \App\Models\GalleryCategoryModel::orderBy('created_at', 'asc')->get();

        return GalleryCategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GalleryCategoryRequest $request)
    {
        $category = $this->service->createCategory($request->validated());

        if ($request->hasFile('image')) {
            $category->addMediaFromRequest('image')->toMediaCollection('category_image');
        }

        if ($request->hasFile('video')) {
            $category->addMediaFromRequest('video')->toMediaCollection('category_video');
        }

        return new GalleryCategoryResource($category);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = $this->service->getCategoryById((int) $id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return new GalleryCategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GalleryCategoryRequest $request, string $id)
    {
        $category = $this->service->getCategoryById((int) $id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $updatedCategory = $this->service->updateCategory((int) $id, $request->validated());

        if ($request->hasFile('image')) {
            $updatedCategory->clearMediaCollection('category_image');
            $updatedCategory->addMediaFromRequest('image')->toMediaCollection('category_image');
        }

        if ($request->hasFile('video')) {
            $updatedCategory->clearMediaCollection('category_video');
            $updatedCategory->addMediaFromRequest('video')->toMediaCollection('category_video');
        }

        return new GalleryCategoryResource($updatedCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = $this->service->getCategoryById((int) $id);
        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $this->service->deleteCategory((int) $id);

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
