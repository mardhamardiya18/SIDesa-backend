<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',

            'password' => 'Kata Sandi',
        ];
    }
}
