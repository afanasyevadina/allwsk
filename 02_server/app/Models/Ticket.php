<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'event_tickets';

    protected $guarded = [];

    protected $casts = [
        'special_validity' => 'array',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class)->withDefault();
    }

    public function getDescriptionAttribute()
    {
        if (@$this->special_validity['type'] == 'date') {
            return 'Available until ' . date('F d, Y', strtotime($this->special_validity['date'] ?? ''));
        }
        if (@$this->special_validity['type'] == 'amount') {
            return @$this->special_validity['amount'] . ' tickets available';
        }
        return null;
    }

    public function getAvailableAttribute()
    {
        if (@$this->special_validity['type'] == 'date') {
            return now()->lessThan(Carbon::create($this->special_validity['date'] ?? ''));
        }
        if (@$this->special_validity['type'] == 'amount') {
            return $this->registrations()->count() < @$this->special_validity['amount'];
        }
        return true;
    }
}
