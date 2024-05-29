<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Categories extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name'];
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function Complaint()
    {
        return $this->hasMany(Complaint::class);
    }
}
