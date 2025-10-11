<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistance extends Model
{
    //
    use UUID, SoftDeletes;

    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'category',
        'amount',
        'provider',
        'is_active',


    ];



    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('name', 'like', "%$search%")
                ->orWhere('category', 'like', "%$search%")
                ->orWhere('provider', 'like', "%$search%");
        }

        return $query;
    }

    public function socialAssistanceRecipients()
    {
        return $this->hasMany(SocialAssistanceRecipient::class);
    }
}
