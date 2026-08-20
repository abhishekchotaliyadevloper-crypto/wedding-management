<?php

namespace App\Repositories;

use App\Models\TestimonialModel;
use App\Repositories\Interfaces\TestimonialRepositoryInterface;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = TestimonialModel::latest();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate($filters['per_page'] ?? 10, ['*'], 'page', $filters['page'] ?? 1);
    }

    public function findById(int $id)
    {
        return TestimonialModel::findOrFail($id);
    }

    public function create(array $data)
    {
        return TestimonialModel::create($data);
    }

    public function update(int $id, array $data)
    {
        $testimonial = $this->findById($id);
        $testimonial->update($data);
        return $testimonial->fresh();
    }

    public function delete(int $id)
    {
        $testimonial = $this->findById($id);
        $testimonial->delete();
    }
}
