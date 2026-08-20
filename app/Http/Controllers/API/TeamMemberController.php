<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamMemberStoreRequest;
use App\Http\Requests\TeamMemberUpdateRequest;
use App\Http\Resources\TeamMemberResource;
use App\Services\TeamMemberService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * TeamMemberController
 *
 * Handles API requests for Team Member CRUD operations.
 * Implements RESTful resource actions with proper dependency injection.
 */
class TeamMemberController extends Controller
{
    /**
     * Constructor to inject the Team Member Service.
     *
     * @param \App\Services\TeamMemberService $service
     */
    public function __construct(
        private TeamMemberService $service
    ) {
    }

    /**
     * Display a paginated list of all team members.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $teamMembers = $this->service->getTeamMembers(
            $request->only('search', 'page', 'per_page')
        );

        return TeamMemberResource::collection($teamMembers);
    }

    /**
     * Store a newly created team member in the database.
     *
     * @param \App\Http\Requests\TeamMemberStoreRequest $request
     * @return \App\Http\Resources\TeamMemberResource
     */
    public function store(TeamMemberStoreRequest $request)
    {
        $data = $request->validated();
        $teamMember = $this->service->createTeamMember($data);

        return new TeamMemberResource($teamMember);
    }

    /**
     * Display the specified team member.
     *
     * @param int $id
     * @return \App\Http\Resources\TeamMemberResource|\Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        try {
            $teamMember = $this->service->getTeamMemberById($id);

            return new TeamMemberResource($teamMember);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Team member not found'], 404);
        }
    }

    /**
     * Update the specified team member in the database.
     *
     * @param int $id
     * @param \App\Http\Requests\TeamMemberUpdateRequest $request
     * @return \App\Http\Resources\TeamMemberResource|\Illuminate\Http\JsonResponse
     */
    public function update(int $id, TeamMemberUpdateRequest $request)
    {
        try {
            $data = $request->validated();
            $teamMember = $this->service->updateTeamMember($id, $data);

            return new TeamMemberResource($teamMember);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Team member not found'], 404);
        }
    }

    /**
     * Delete the specified team member from the database.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        try {
            $this->service->deleteTeamMember($id);

            return response()->json([
                'success' => true,
                'message' => 'Team member deleted successfully.',
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Team member not found'], 404);
        }
    }
}
