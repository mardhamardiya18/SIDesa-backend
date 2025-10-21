<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'thumbnail' => 'required|image|max:2048', // Max 2MB
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'headman' => 'required|string|max:255',
            'people' => 'required|integer|min:0',
            'agricultural_area' => 'required|numeric|min:0',
            'total_area' => 'required|numeric|min:0',
            'images' => 'nullable|array',
            'images.*' => 'nullable|max:2048', // Each image max 2
        ];
    }

    public function attributes()
    {
        return [
            'thumbnail' => 'Profile Thumbnail',
            'name' => 'Profile Name',
            'about' => 'About Profile',
            'headman' => 'Headman Name',
            'people' => 'Number of People',
            'agricultural_area' => 'Agricultural Area',
            'total_area' => 'Total Area',
            'images' => 'Profile Images',
            'images.*' => 'Profile Image',
        ];
    }
}
