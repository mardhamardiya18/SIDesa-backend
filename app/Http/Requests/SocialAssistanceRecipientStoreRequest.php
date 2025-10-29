<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SocialAssistanceRecipientStoreRequest extends FormRequest
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
            'social_assistance_id' => 'required|exists:social_assistances,id',
            'head_of_family_id' => 'required|exists:head_of_families,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string',
            'bank' => 'required|in:bri,bni,mandiri,bca',
            'bank_account_number' => 'required|numeric',
            'proof' => 'nullable|image|max:2048',
            'status' => 'nullable|in:pending,approved,rejected',

        ];
    }

    public function attributes(): array
    {
        return [
            'social_assistance_id' => 'Bantuan Sosial',
            'head_of_family_id' => 'Kepala Keluarga',
            'amount' => 'Jumlah',
            'reason' => 'Alasan',
            'bank' => 'Bank',
            'bank_account_number' => 'Nomor Rekening',
            'proof' => 'Bukti',
            'status' => 'Status',
        ];
    }

    public function prepareForValidation()
    {
        $user = auth()->user();
        if ($user->hasRole('head-of-family')) {
            $this->merge([
                'head_of_family_id' => $user->headOfFamily->id,
            ]);
        }
    }
}
