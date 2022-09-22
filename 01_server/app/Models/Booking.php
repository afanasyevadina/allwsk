<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    public const UPDATED_AT = null;

    protected $guarded = [];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
