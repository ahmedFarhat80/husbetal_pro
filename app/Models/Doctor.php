<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class Doctor extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasFactory, HasTranslations;

    public $translatable = ['name'];
    public function Category()
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }


    public function day()
    {
        return $this->hasMany(Daywork::class);
    }

    public function getStatusAttribute()
    {
        return $this->isactive ? 'Active' : 'Inactive';
    }

    public function times()
    {
        return $this->hasMany(Time::class);
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
