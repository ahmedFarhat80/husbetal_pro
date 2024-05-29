<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GeneratesUUID;

class Booking extends Model
{
    use HasFactory, GeneratesUUID;


    public function doctors()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }


    public function Categories()
    {
        return $this->belongsTo(Categories::class, 'section_id');
    }

    public function Time()
    {
        return $this->belongsTo(Time::class, 'time_id');
    }
}
