<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonitoringPointResource extends JsonResource
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
            'name' => $this->name,
            'location' => $this->location,
            'point_type' => $this->point_type,
            'api_link' => $this->api_link,
            'is_custom' => $this->is_custom,
            'water_level' => $this->water_level,
            'risk_indicators' => $this->risk_indicators,
            'discharge' => $this->discharge,
            'source' => $this->source,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
