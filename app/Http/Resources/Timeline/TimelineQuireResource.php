<?php

namespace App\Http\Resources\Timeline;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TimelineQuireResource extends JsonResource
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
            'timeline_event_id' => $this->timeline_event_id,
            'stakeholder_id' => $this->stakeholder_id,
            'inquiry' => $this->inquiry,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
