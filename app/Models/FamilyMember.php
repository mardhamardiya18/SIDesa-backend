<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    //
    use UUID, SoftDeletes;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'identity_number',
        'gender',
        'date_of_birth',
        'phone_number',
        'occupation',
        'marital_status',
        'relation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
