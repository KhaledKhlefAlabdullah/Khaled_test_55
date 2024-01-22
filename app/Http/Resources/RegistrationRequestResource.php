<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegistrationRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'company_name' => $this->company_name,
            'representative_name' => $this->representative_name,
            'email' => $this->email,
            'password' => $this->password,
            'location' => $this->location,
            'phone_number' => $this->phone_number,
            'job_title' => $this->job_title,
            'request_state' => $this->request_state,
            'failed_message' => $this->failed_message,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
