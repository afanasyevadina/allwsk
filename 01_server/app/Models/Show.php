<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    public function locationSeatRows()
    {
        return $this->hasMany(LocationSeatRow::class);
    }

    public function concert()
    {
        return $this->belongsTo(Concert::class)->withDefault();
    }
}
