<?php

namespace App\Models;

use App\Traits\UUID;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    //

    use UUID, SoftDeletes;

    protected $fillable = [
        'thumbnail',
        'name',
        'about',
        'headman',
        'people',
        'agricultural_area',
        'total_area',

    ];

    public function profileImages()
    {
        return $this->hasMany(ProfileImage::class);
    }
}
