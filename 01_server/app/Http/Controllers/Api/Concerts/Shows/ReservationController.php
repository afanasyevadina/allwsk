<?php

namespace App\Http\Controllers\Api\Concerts\Shows;

use App\Http\Controllers\Controller;
use App\Models\Concert;
use App\Models\LocationSeat;
use App\Models\Reservation;
use App\Rules\SeatAvailable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function store($concertId, $showId, Request $request)
    {
        $concert = Concert::find($concertId);
        if (!$concert || !$show = $concert->shows()->find($showId)) {
            return response()->json([
                'error' => 'A concert or show with this ID does not exist',
            ], 404);
        }
        if ($request->input('reservation_token')) {
            $reservation = Reservation::where('token', $request->input('reservation_token'))->first();
            if (!$reservation) {
                return response()->json([
                    'error' => 'Invalid reservation token',
                ], 403);
            }
            $reservation->locationSeats()->update([
                'reservation_id' => null,
            ]);
        } else {
            $reservation = new Reservation([
                'token' => Str::random(45),
            ]);
        }
        if (!$request->input('duration')) $request->merge(['duration' => 300]);
        $request->validate([
            'reservations' => ['required', 'array', new SeatAvailable($show)],
            'duration' => 'integer|between:1,300',
        ]);
        foreach ($request->input('reservations') ?? [] as $item) {
            LocationSeat::where('location_seat_row_id', $item['row'])->where('number', $item['seat'])->update([
                'reservation_id' => $reservation->id,
            ]);
        }
        $reservation->expires_at = now()->addMinutes(5);
        $reservation->save();
        return response()->json([
            'reserved' => true,
            'reservation_token' => $reservation->token,
            'reserved_until' => Carbon::create($reservation->expires_at)->toIso8601ZuluString(),
        ]);
    }
}
