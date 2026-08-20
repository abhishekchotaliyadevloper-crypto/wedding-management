<?php

namespace App\Repositories;

use App\Models\TeamMemberModel;
use App\Repositories\Interfaces\TeamMemberRepositoryInterface;

/**
 * TeamMemberRepository
 *
 * Handles all database operations for Team Members using the Repository Pattern.
 */
class TeamMemberRepository implements TeamMemberRepositoryInterface
{
    /**
     * Constructor to inject the TeamMemberModel.
     *
     * @param \App\Models\TeamMemberModel $model
     */
    public function __construct(
        private TeamMemberModel $model
    ) {
    }

    /**
     * Get all team members with pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll(array $filters = [])
    {
        $query = $this->model->query()->latest();

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('designation', 'like', '%' . $filters['search'] . '%');
        }

        return $query->paginate($filters['per_page'] ?? 10, ['*'], 'page', $filters['page'] ?? 1);
    }

    /**
     * Find a team member by ID.
     *
     * @param int $id
     * @return \App\Models\TeamMemberModel
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new team member.
     *
     * @param array $data
     * @return \App\Models\TeamMemberModel
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Update a team member.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\TeamMemberModel
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function update(int $id, array $data)
    {
        $teamMember = $this->model->findOrFail($id);
        $teamMember->update($data);

        return $teamMember->fresh();
    }

    /**
     * Delete a team member (soft delete).
     *
     * @param int $id
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function delete(int $id)
    {
        $teamMember = $this->model->findOrFail($id);

        return $teamMember->delete();
    }
}
