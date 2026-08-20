<?php

namespace App\Services;

use App\Repositories\Interfaces\TeamMemberRepositoryInterface;

/**
 * TeamMemberService
 *
 * Handles business logic for Team Member operations.
 * Acts as a thin layer delegating to the repository.
 */
class TeamMemberService
{
    /**
     * Constructor to inject the Team Member Repository.
     *
     * @param \App\Repositories\Interfaces\TeamMemberRepositoryInterface $repository
     */
    public function __construct(
        private TeamMemberRepositoryInterface $repository
    ) {
    }

    /**
     * Get all team members with pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getTeamMembers(array $filters = [])
    {
        return $this->repository->getAll($filters);
    }

    /**
     * Get a team member by ID.
     *
     * @param int $id
     * @return \App\Models\TeamMemberModel|null
     */
    public function getTeamMemberById(int $id)
    {
        return $this->repository->findById($id);
    }

    /**
     * Create a new team member.
     *
     * @param array $data
     * @return \App\Models\TeamMemberModel
     */
    public function createTeamMember(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update a team member.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\TeamMemberModel
     */
    public function updateTeamMember(int $id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Delete a team member.
     *
     * @param int $id
     * @return bool
     */
    public function deleteTeamMember(int $id)
    {
        return $this->repository->delete($id);
    }
}
