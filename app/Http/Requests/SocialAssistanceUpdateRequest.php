<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            //
            'thumbnail' => 'nullable|image|max:2048',
            'name' => 'required|string|max:255',
            'category' => 'required|in:staple,cash,subsidized fuel,health|string',
            'amount' => 'required|numeric|min:0',
            'provider' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'required|boolean',

        ];
    }

    public function attributes(): array
    {
        return [

            'name' => 'Nama Bantuan',
            'category' => 'Kategori',
            'amount' => 'Jumlah',
            'provider' => 'Penyedia',
            'description' => 'Deskripsi',
            'is_active' => 'Status Aktif',
        ];
    }
}
