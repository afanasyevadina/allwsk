<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Concert extends Model
{
    use HasFactory;

    public function location()
    {
        return $this->belongsTo(Location::class)->withDefault();
    }

    public function shows()
    {
        return $this->hasMany(Show::class);
    }
}
