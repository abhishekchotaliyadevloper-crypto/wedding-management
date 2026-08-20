<?php

namespace App\Services;

use App\Repositories\Interfaces\GalleryCategoryRepositoryInterface;

class GalleryCategoryService
{
    public function __construct(
        private GalleryCategoryRepositoryInterface $repository
    ) {}

    public function getCategories()
    {
        return $this->repository->getAll();
    }

    public function createCategory(array $data)
    {
        return $this->repository->create($data);
    }

    public function getCategoryById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function updateCategory(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteCategory(int $id)
    {
        return $this->repository->delete($id);
    }
}