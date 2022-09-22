<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationSeatRow extends Model
{
    use HasFactory;

    public function locationSeats()
    {
        return $this->hasMany(LocationSeat::class);
    }

    public function show()
    {
        return $this->belongsTo(Show::class)->withDefault();
    }
}
