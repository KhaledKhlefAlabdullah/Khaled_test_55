<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'page_id' => $this->page_id,
            'category_id' => $this->category_id,
            'title' => $this->title,
            'body' => $this->body,
            'media_url' => $this->media_url,
            'media_type' => $this->media_type,
            'is_priority' => $this->is_priority,
            'priority_count' => $this->priority_count,
            'is_general_news' => $this->is_general_news,
            'is_publish' => $this->is_publish,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
