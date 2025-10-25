<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyMemberStoreRequest extends FormRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'profile_picture' => 'required|image|max:2048',
            'identity_number' => 'required|string|size:10|unique:head_of_families',
            'gender' => 'required|in:male,female|string',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:15',
            'occupation' => 'required|string|max:255',
            'marital_status' => 'required|in:single,married',
            'relation' => 'required|in:child,wife,husband|string',
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
            'head_of_family_id' => 'Kepala Keluarga',
            'relationship' => 'Hubungan',
        ];
    }
}
