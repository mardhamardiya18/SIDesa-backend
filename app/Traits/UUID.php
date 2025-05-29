<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait UUID
{
    /**
     * Boot the UUID trait for a model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if ($model->getKey() === null) {
                $model->setAttribute($model->getKeyName(), Str::uuid()->toString());
            }
        });
    }

    /**
     * Get the incrementing property.
     *
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the key type.
     *
     * @return string
     */
    public function getKeyType()
    {
        return 'string';
    }
}
