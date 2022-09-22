<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'token',
        'expires_at',
    ];

    public function locationSeats()
    {
        return $this->hasMany(LocationSeat::class);
    }
}
