<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'thumbnail' => $this->thumbnail,
            'name' => $this->name,
            'description' => $this->description,
            'date' => $this->date,
            'time' => $this->time,
            'price' => $this->price,
            'is_active' => $this->is_active,

        ];
    }
}