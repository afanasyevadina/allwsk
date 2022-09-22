<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocationSeat extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'reservation_id',
        'ticket_id',
    ];

    public function locationSeatRow()
    {
        return $this->belongsTo(LocationSeatRow::class)->withDefault();
    }
}
