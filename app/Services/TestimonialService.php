<?php

namespace App\Services;

use App\Repositories\Interfaces\TestimonialRepositoryInterface;

class TestimonialService
{
    public function __construct(
        private TestimonialRepositoryInterface $repository
    ) {}

    public function getAllTestimonials(array $filters = [])
    {
        return $this->repository->getAll($filters);
    }

    public function getTestimonialById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function createTestimonial(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateTestimonial(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteTestimonial(int $id)
    {
        return $this->repository->delete($id);
    }
}
