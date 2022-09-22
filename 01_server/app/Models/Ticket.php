<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $guarded = [];

    public function locationSeat()
    {
        return $this->hasOne(LocationSeat::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class)->withDefault();
    }
}
