<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
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
            'category_id' => $this->category_id,
            'name' => $this->name,
            'slug' => $this->slug,
            'public_id' => $this->public_id,
            'phone_number' => $this->phone_number,
            'location' => $this->location,
            'from' => $this->from,
            'to' => $this->to,
            'usage' => $this->usage,
            'quantity' => $this->quantity,
            'is_available' => $this->is_available,
            'available_quantity' => $this->available_quantity,
            'note' => $this->note,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at


        ];
    }
}
