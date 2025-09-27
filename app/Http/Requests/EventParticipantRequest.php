<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventParticipantRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            'event_id' => 'required|exists:events,id',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'quantity' => 'required|integer|min:1',



        ];
    }

    public function attributes(): array
    {
        return [
            'event_id' => 'Event',
            'head_of_family_id' => 'Head of Family',
            'quantity' => 'Quantity',


        ];
    }
}
