<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Time extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['description'];
    protected $fillable = ['time', 'description', 'daywork_id', 'doctor_id'];


    public function daywork()
    {
        return $this->belongsTo(Daywork::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
