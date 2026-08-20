<?php

namespace App\Repositories;

use App\Models\InquiryModel;
use App\Repositories\Interfaces\InquiryRepositoryInterface;

class InquiryRepository implements InquiryRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = InquiryModel::latest();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        return $query->paginate($filters['per_page'] ?? 10, ['*'], 'page', $filters['page'] ?? 1);
    }

    public function findById(int $id)
    {
        return InquiryModel::findOrFail($id);
    }

    public function create(array $data)
    {
        return InquiryModel::create($data);
    }

    public function delete(int $id)
    {
        $inquiry = $this->findById($id);
        $inquiry->delete();
    }
}
