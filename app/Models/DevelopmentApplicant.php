<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevelopmentApplicant extends Model
{
    //

    use UUID, SoftDeletes, HasFactory;

    protected $fillable = [
        'development_id',
        'user_id',
        'status',
    ];

    public function scopeSearch($query, $search)
    {

        $query->whereHas('user', function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        })->orWhereHas('development', function ($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        })->orWhere('status', 'like', "%$search%");


        return $query;
    }
    public function development()
    {
        return $this->belongsTo(Development::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
