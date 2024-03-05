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
            'stakeholder_id' => $this->stakeholder_id,
            'route' => $this->whenLoaded('route', function () {
                return $this->route->only(['name', 'location', 'from', 'to', 'is_available']);
            }),
            'department' => $this->whenLoaded('department', function () {
                return $this->department->only(['name']);
            }),
            'station' => $this->whenLoaded('station', function () {
                return $this->station->only(['name', 'location']);
            }),
            'is_leadership' => $this->is_leadership,
            'residential_area_id' => $this->residential_area_id,
            'employee_number' => $this->employee_number,
            'created_at' => $this->created_at
        ];
    }
}
