<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'price' => number_format($this->price, 2),
            'image_url' => $this->image_path ? env('APP_URL') . Storage::url($this->image_path) : null,
            'video_url' => $this->video_path ? env('APP_URL') . Storage::url($this->video_path) : null,
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
