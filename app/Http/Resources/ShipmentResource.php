<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShipmentResource extends JsonResource
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
            'product_id' => $this->product_id,
            'customer_id' => $this->customer_id,
            'stakeholder_id' => $this->stakeholder_id,
            'public_id' => $this->public_id,
            'name' => $this->name,
            'description' => $this->description,
            'location' => $this->location,
            'contact_info' => $this->contact_info,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
