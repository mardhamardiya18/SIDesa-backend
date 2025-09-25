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
        'head_of_family_id',
        'profile_picture',
        'identity_number',
        'gender',
        'date_of_birth',
        'phone_number',
        'occupation',
        'marital_status',
        'relation',
    ];

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })->orWhere('identity_number', 'like', "%$search%")
                ->orWhere('phone_number', 'like', "%$search%")
                ->orWhere('occupation', 'like', "%$search%");
        }

        return $query;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
