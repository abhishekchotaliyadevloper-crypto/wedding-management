<?php

namespace App\Repositories;

use App\Models\VideoModel;
use App\Repositories\Interfaces\VideoRepositoryInterface;

class VideoRepository implements VideoRepositoryInterface
{
    public function getAll(array $filters = [])
    {
        $query = VideoModel::with('gallery')->latest();

        if (!empty($filters['search'])) {
            $query->where('title', 'like', '%' . $filters['search'] . '%');
        }

        if (!empty($filters['gallery_id'])) {
            $query->where('gallery_id', $filters['gallery_id']);
        }

        return $query->paginate($filters['per_page'] ?? 10, ['*'], 'page', $filters['page'] ?? 1);
    }

    public function findById(int $id)
    {
        return VideoModel::with('gallery')->findOrFail($id);
    }

    public function create(array $data)
    {
        return VideoModel::create($data)->load('gallery');
    }

    public function update(int $id, array $data)
    {
        $video = $this->findById($id);
        $video->update($data);
        return $video->fresh()->load('gallery');
    }

    public function delete(int $id)
    {
        $video = VideoModel::findOrFail($id);
        $video->delete();
    }
}
