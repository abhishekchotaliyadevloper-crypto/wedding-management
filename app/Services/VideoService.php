<?php

namespace App\Services;

use App\Repositories\Interfaces\VideoRepositoryInterface;

class VideoService
{
    public function __construct(
        private VideoRepositoryInterface $repository
    ) {}

    public function getVideos(array $filters = [])
    {
        return $this->repository->getAll($filters);
    }

    public function createVideo(array $data)
    {
        return $this->repository->create($data);
    }

    public function getVideoById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function updateVideo(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function deleteVideo(int $id)
    {
        return $this->repository->delete($id);
    }
}
