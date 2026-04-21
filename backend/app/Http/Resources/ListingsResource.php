<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListingsResource extends JsonResource
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
            'price' => $this->price,
            'status' => $this->status,
            'user' => new UserResource($this->whenLoaded('user')),
            'car' => new CarResource($this->whenLoaded('car')),
            'favouritedBy' => UserResource::collection($this->whenLoaded('favouritedBy')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
