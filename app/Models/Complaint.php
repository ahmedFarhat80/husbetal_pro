<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;



    public function Category()
    {
        return $this->belongsTo(Categories::class, 'categories_id');
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
