<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function sessionRegistrations()
    {
        return $this->hasManyThrough(SessionRegistration::class, Session::class);
    }
}
