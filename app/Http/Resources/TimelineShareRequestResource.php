<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineShareRequestResource extends JsonResource
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
            'timeline_id' => $this->timeline_id,
            'send_stakeholder_id' => $this->send_stakeholder_id,
            'receive_stakeholder_id' => $this->receive_stakeholder_id,
            'status' => $this->status,
            'send_date' => $this->send_date,
            'end_date' => $this->end_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
