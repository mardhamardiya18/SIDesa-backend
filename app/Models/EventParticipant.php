<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    //

    use UUID, SoftDeletes, HasFactory;

    protected $fillable = [
        'event_id',
        'head_of_family_id',
        'quantity',
        'total_price',
        'payment_status',
    ];

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->whereHas('headOfFamily.user', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            })->orWhereHas('event', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            })->orWhere('payment_status', 'like', "%$search%");
        }

        return $query;
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class);
    }
}