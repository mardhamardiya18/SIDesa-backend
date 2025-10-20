<?php

namespace App\Http\Resources;

use App\Models\DevelopmentApplicant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DevelopmentResource extends JsonResource
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
            'person_in_charge' => $this->person_in_charge,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'budget' => $this->budget,
            'status' => $this->status,
            'development_applicants'    => DevelopmentApplicantResource::collection($this->whenLoaded('developmentApplicants'))
        ];
    }
}
