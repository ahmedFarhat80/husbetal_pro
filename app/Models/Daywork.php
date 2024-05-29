<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daywork extends Model
{
    use HasFactory;


    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function times()
    {
        return $this->hasMany(Time::class);
    }
}
