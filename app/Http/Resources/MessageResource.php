<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'sender_id' => $this->sender_id,
            'receiver_id' => $this->receiver_id,
            'chat_id' => $this->chat_id,
            'message' => $this->message,
            'media_url' => $this->media_url,
            'message_type' => $this->message_type,
            'is_read' => $this->is_read,
            'is_edite' => $this->is_edite,
            'is_starred' => $this->is_starred,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
