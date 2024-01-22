<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StakeholderResource extends JsonResource
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
            'industrial_area_id' => $this->industrial_area_id,
            'representative_government_agency' => $this->representative_government_agency,
            'tent_company_state' => $this->tent_company_state,
            'company_representative_name' => $this->company_representative_name,
            'job_title' => $this->job_title,
            'infrastructures_state' => $this->infrastructures_state,
            'infrastructure_type' => $this->infrastructure_type,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
