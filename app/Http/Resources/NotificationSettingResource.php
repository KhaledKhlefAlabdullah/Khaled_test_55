<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationSettingResource extends JsonResource
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
            'main_category_id' => $this->main_category_id,
            'sub_category_id' => $this->sub_category_id,
            'notification_state' => $this->notification_state,
            'notification_level' => $this->notification_level,
            'notification_priorities' => $this->notification_priorities,
            'is_on' => $this->is_on,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
