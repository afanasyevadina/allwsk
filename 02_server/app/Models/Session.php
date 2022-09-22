<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function room()
    {
        return $this->belongsTo(Room::class)->withDefault();
    }

    public function sessionRegistrations()
    {
        return $this->hasMany(SessionRegistration::class);
    }
}
