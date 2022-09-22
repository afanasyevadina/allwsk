<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function sessionRegistrations()
    {
        return $this->hasMany(SessionRegistration::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class)->withDefault();
    }
}
