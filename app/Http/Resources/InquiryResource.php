<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InquiryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'contact_number' => $this->contact_number,
            'subject'        => $this->subject,
            'email'          => $this->email,
            'message'        => $this->message,
            'created_at'     => $this->created_at,
        ];
    }
}
