<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * TeamMemberResource
 *
 * Transforms Team Member model data for API responses.
 */
class TeamMemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'name'                => $this->name,
            'designation'         => $this->designation,
            'profile_description' => $this->profile_description,
            'created_at'          => $this->created_at,
        ];
    }
}
