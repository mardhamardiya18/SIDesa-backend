<?php

namespace App\Http\Requests;

use App\Models\HeadOfFamily;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class HeadOfFamilyUpdateRequest extends FormRequest
{

    public function rules(): array
    {


        return [
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->route('head_of_family')->user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'profile_picture' => 'nullable|image|max:2048',
            'identity_number' => 'required|string|size:10',
            'gender' => 'required|in:male,female|string',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'occupation' => 'required|string|max:255',
            'marital_status' => 'required|in:single,married',
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Kata Sandi',
            'profile_picture' => 'Foto Profil',
            'identity_number' => 'Nomor Identitas',
            'gender' => 'Jenis Kelamin',
            'date_of_birth' => 'Tanggal Lahir',
            'phone_number' => 'Nomor Telepon',
            'occupation' => 'Pekerjaan',
            'marital_status' => 'Status Perkawinan',
        ];
    }
}
