<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NaturalDisasterResource extends JsonResource
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
            'name' => $this->name,
            'disaster_type' => $this->disaster_type,
            'disaster_date' => $this->disaster_date,
            'description' => $this->description,
            'location' => $this->location,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
