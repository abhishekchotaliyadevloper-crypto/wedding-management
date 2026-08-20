<?php

namespace App\Repositories\Interfaces;

interface GalleryRepositoryInterface
{
    public function getAll(array $filters = []);

    public function findBySlug(string $slug);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);

    public function addImages(int $id, array $images);

    public function findByIdWithImages(int $id);

    public function updateImage(int $mediaId, array $data);

    public function deleteImage(int $mediaId);
}
