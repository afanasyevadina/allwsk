<?php

namespace App\Rules;

use App\Models\LocationSeat;
use App\Models\Show;
use Illuminate\Contracts\Validation\Rule;

class SeatAvailable implements Rule
{
    protected $show;
    protected $message;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(Show $show)
    {
        $this->show = $show;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        foreach ($value ?? [] as $item) {
            $row = $item['row'] ?? null;
            $seat = $item['seat'] ?? null;
            if (!$row) {
                $this->message = "The row field is required";
                return false;
            }
            if (!$seat) {
                $this->message = "The seat field is required";
                return false;
            }
            $locationSeat = LocationSeat::where('location_seat_row_id', $row)
                ->where('number', $seat)
                ->whereHas('locationSeatRow', function($query) {
                    $query->where('show_id', $this->show->id);
                })
                ->first();
            if (!$locationSeat) {
                $this->message = "Seat $seat in row $row is invalid";
                return false;
            }
            if ($locationSeat->ticket_id || $locationSeat->reservation_id) {
                $this->message = "Seat $seat in row $row is already taken";
                return false;
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}
