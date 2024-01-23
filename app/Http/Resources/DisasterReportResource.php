<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DisasterReportResource extends JsonResource
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
            'natural_disaster_id' => $this->natural_disaster_id,
            'entity_id' => $this->entity_id,
            'shipment_id' => $this->shipment_id,
            'supplier_id' => $this->supplier_id,
            'employee_id' => $this->employee_id,
            'waste_id' => $this->waste_id,
            'is_safe' => $this->is_safe,
            'impact_date' => $this->impact_date,
            'start_date' => $this->start_date,
            'stop_date' => $this->stop_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
