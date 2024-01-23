<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MonitoringPointNotificationSettingResource extends JsonResource
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
            'monitoring_point_id' => $this->monitoring_point_id,
            'notifications_setting_id' => $this->notifications_setting_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
