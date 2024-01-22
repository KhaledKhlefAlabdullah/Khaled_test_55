<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
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
            'material_id' => $this->material_id,
            'stakeholder_id' => $this->takeholder_id,
            'public_id' => $this->public_id,
            'location' => $this->location,
            'contact_info' => $this->contact_info,
            'slug' => $this->slug,
            'is_available' => $this->is_available,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
