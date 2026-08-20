<?php

namespace App\Repositories;

use App\Models\GalleryCategoryModel as GalleryCategory;
use App\Repositories\Interfaces\GalleryCategoryRepositoryInterface;
use Illuminate\Support\Str;

class GalleryCategoryRepository implements GalleryCategoryRepositoryInterface
{
    public function getAll()
    {
        return GalleryCategory::query()
            ->latest()
            ->paginate(10);
    }

    public function findById(int $id)
    {
        return GalleryCategory::find($id);
    }

    public function create(array $data)
    {
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        return GalleryCategory::create($data);
    }

    public function update(int $id, array $data)
    {
        $category = $this->findById($id);
        if (empty($data['slug']) && !empty($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return $category;
    }

    public function delete(int $id)
    {
        $category = $this->findById($id);

        return $category->delete();
    }
}