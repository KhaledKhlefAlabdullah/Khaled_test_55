<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'route_id' => $this->route_id,
            'department_id' => $this->department_id,
            'station_id' => $this->station_id,
            'stakeholder_id' => $this->stakeholder_id,
            'public_id' => $this->public_id,
            'is_leader_shop' => $this->is_leader_shop,
            'slug' => $this->slug,
            'phone_number' => $this->phone_number,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
