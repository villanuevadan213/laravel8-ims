<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeLog extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $dates = ['clock_in', 'clock_out'];

    // Define the relationship with the user model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

