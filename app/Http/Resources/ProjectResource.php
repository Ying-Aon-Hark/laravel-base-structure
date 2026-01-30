<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'mediaObjects' => $this->mediaObjects->map(function ($mediaObject) {
                return [
                    'id' => $mediaObject->id,
                    'file_path' => $mediaObject->file_path,
                ];
            }),
        ];
    }
}
