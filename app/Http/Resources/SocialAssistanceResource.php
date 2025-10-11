<?php

namespace App\Http\Resources;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialAssistanceResource extends JsonResource
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
            'thumbnail' => asset('storage/' . $this->thumbnail),
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'amount' => $this->amount,
            'provider' => $this->provider,
            'is_active' => $this->is_active,
            'social_assistance_recipients' => SocialAssistanceRecipientResource::collection($this->socialAssistanceRecipients)
        ];
    }
}
