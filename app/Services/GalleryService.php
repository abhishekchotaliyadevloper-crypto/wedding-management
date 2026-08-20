<?php

namespace App\Services;
use App\Repositories\Interfaces\GalleryRepositoryInterface;

class GalleryService
{
    public function __construct(
        private GalleryRepositoryInterface $repository
    ) {}

    public function getGalleries(array $filters = [])
    {
        return $this->repository->getAll($filters);
    }

    public function createGallery(array $data)
    {
        return $this->repository->create($data);
    }

    public function getGalleryBySlug(string $slug)
    {
        return $this->repository->findBySlug($slug);
    }

    public function updateGallery(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteGallery(int $id)
    {
        return $this->repository->delete($id);
    }

    public function addImagesToGallery(int $id, array $images)
    {
        return $this->repository->addImages($id, $images);
    }

    public function getGalleryById(int $id)
    {
        return $this->repository->findByIdWithImages($id);
    }

    public function updateGalleryImage(int $mediaId, array $data)
    {
        return $this->repository->updateImage($mediaId, $data);
    }

    public function deleteGalleryImage(int $mediaId)
    {
        return $this->repository->deleteImage($mediaId);
    }
}
