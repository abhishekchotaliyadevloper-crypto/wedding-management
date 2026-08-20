<?php

namespace App\Repositories\Interfaces;

interface InquiryRepositoryInterface
{
    public function getAll(array $filters = []);
    public function findById(int $id);
    public function create(array $data);
    public function delete(int $id);
}
