<?php

namespace App\Repositories\Interfaces;

/**
 * TeamMemberRepositoryInterface
 *
 * Defines the contract for Team Member repository operations.
 */
interface TeamMemberRepositoryInterface
{
    /**
     * Get all team members with pagination.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getAll(array $filters = []);

    /**
     * Find a team member by ID.
     *
     * @param int $id
     * @return \App\Models\TeamMemberModel|null
     */
    public function findById(int $id);

    /**
     * Create a new team member.
     *
     * @param array $data
     * @return \App\Models\TeamMemberModel
     */
    public function create(array $data);

    /**
     * Update a team member.
     *
     * @param int $id
     * @param array $data
     * @return \App\Models\TeamMemberModel
     */
    public function update(int $id, array $data);

    /**
     * Delete a team member.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id);
}
