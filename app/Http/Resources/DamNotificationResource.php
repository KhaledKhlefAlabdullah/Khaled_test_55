<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DamNotificationResource extends JsonResource
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
            'dam_id' => $this->dam_id,
            'notification_setting_id' => $this->notification_setting_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
