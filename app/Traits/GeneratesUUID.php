<?php

namespace App\Traits;

trait GeneratesUUID
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if ($model->getKey() === null) {
                $model->setAttribute($model->getKeyName(), self::generateUniqueID());
            }
        });
    }

    public function getIncrementing()
    {
        return false;
    }

    public function getKeyType()
    {
        return 'string';
    }

    private static function generateUniqueID()
    {
        $id = '';

        // Generate a unique 12-digit number
        do {
            $id = str_pad(mt_rand(1, 999999999999), 12, '0', STR_PAD_LEFT);
        } while (static::where('id', $id)->exists());

        return $id;
    }
}
