<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialAssistanceRecipientResource extends JsonResource
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
            'social_assistance' => new SocialAssistanceResource($this->whenLoaded('socialAssistance')),
            'head_of_family' => new HeadOfFamilyResource($this->whenLoaded('headOfFamily')),
            'amount' => $this->amount,
            'reason' => $this->reason,
            'bank' => $this->bank,
            'bank_account_number' => $this->bank_account_number,
            'proof' => $this->proof,
            'status' => $this->status,
            'created_at' => $this->created_at
        ];
    }
}
