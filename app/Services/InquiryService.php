<?php

namespace App\Services;

use App\Repositories\Interfaces\InquiryRepositoryInterface;

class InquiryService
{
    public function __construct(
        private InquiryRepositoryInterface $repository
    ) {}

    public function getAllInquiries(array $filters = [])
    {
        return $this->repository->getAll($filters);
    }

    public function getInquiryById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function createInquiry(array $data)
    {
        return $this->repository->create($data);
    }

    public function deleteInquiry(int $id)
    {
        return $this->repository->delete($id);
    }
}
