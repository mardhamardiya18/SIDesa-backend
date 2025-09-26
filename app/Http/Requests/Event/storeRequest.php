<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class storeRequest extends FormRequest
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
            'thumbnail' => 'required|image|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'date' => 'required|date',
            'time' => 'required',
            'price' => 'required|numeric|min:0',
            'is_active' => 'required|boolean',

        ];
    }

    public function attributes(): array
    {
        return [
            'thumbnail' => 'Thumbnail',
            'name' => 'Name',
            'description' => 'Description',
            'date' => 'Date',
            'time' => 'Time',
            'price' => 'Price',
            'is_active' => 'Is Active',
        ];
    }
}
