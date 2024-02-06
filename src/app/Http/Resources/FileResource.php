<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            'category_id' => $this->category_id,
            'file_type' => $this->file_type,
            'title' => $this->title,
            'description' => $this->description,
            'version' => $this->version,
            'media_url' => $this->media_url,
            'media_type' => $this->media_type,
            'update_frequency' => $this->update_frequency,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at

        ];
    }
}
