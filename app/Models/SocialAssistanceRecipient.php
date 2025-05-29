<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistanceRecipient extends Model
{
    //
    use UUID, SoftDeletes;

    protected $fillable = [
        'social_assistance_id',
        'head_of_family_id',
        'amount',
        'reason',
        'bank',
        'bank_account_number',
        'proof',
        'status',
    ];

    public function socialAssistance()
    {
        return $this->belongsTo(SocialAssistance::class);
    }
    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
