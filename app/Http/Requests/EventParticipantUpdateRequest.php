<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventParticipantUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            //
            'event_id' => 'required|exists:events,id',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'quantity' => 'required|integer|min:1',
            'payment_status' => 'required|in:pending,paid,cancelled',


        ];
    }

    public function attributes(): array
    {
        return [
            'event_id' => 'Event',
            'head_of_family_id' => 'Head of Family',
            'quantity' => 'Quantity',
            'payment_status' => 'Payment Status',

        ];
    }
}