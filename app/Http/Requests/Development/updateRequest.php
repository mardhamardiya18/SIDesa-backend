<?php

namespace App\Http\Requests\Development;

use Illuminate\Foundation\Http\FormRequest;

class updateRequest extends FormRequest
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
            'thumbnail' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'person_in_charge' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'budget' => 'required|numeric|min:0',
            'status' => 'required|in:planned,in_progress,completed,on_hold',
        ];
    }

    public function attributes(): array
    {
        return [
            'thumbnail' => 'Thumbnail',
            'name' => 'Name',
            'description' => 'Description',
            'person_in_charge' => 'Person In Charge',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'budget' => 'Budget',
            'status' => 'Status',
        ];
    }
}