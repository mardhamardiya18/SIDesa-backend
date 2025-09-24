<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeadOfFamilyStoreRequest extends FormRequest
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
            'password' => 'required|string|min:8|confirmed',
            'profile_picture' => 'required|image|max:2048',
            'identity_number' => 'required|string|size:10|unique:head_of_families',
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

    public function messages(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'string' => ':attribute harus berupa string.',
            'image' => ':attribute harus berupa gambar.',
            'max' => ':attribute maksimal :max karakter.',
            'size' => ':attribute harus berukuran :size karakter.',
            'in' => ':attribute tidak valid.',
            'date' => ':attribute harus berupa tanggal yang valid.',
            'unique' => ':attribute sudah digunakan.',
            'email' => ':attribute harus berupa email yang valid.',
            'min' => ':attribute minimal :min karakter.',
            'confirmed' => ':attribute tidak sesuai dengan konfirmasi.',
        ];
    }
}
