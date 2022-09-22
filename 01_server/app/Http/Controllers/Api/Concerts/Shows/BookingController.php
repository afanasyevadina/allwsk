<?php

namespace App\Http\Controllers\Api\Concerts\Shows;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Booking;
use App\Models\Concert;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function store($concertId, $showId, Request $request) {
        $reservation = Reservation::where('token', $request->input('reservation_token'))->first();
        if (!$reservation || now()->greaterThan($reservation->expires_at)) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }
        $concert = Concert::find($concertId);
        if (!$concert || !$concert->shows()->find($showId)) {
            return response()->json([
                'error' => 'A concert or show with this ID does not exist',
            ], 404);
        }
        $request->validate([
            'reservation_token' => 'required|string',
            'name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
        ]);
        $booking = Booking::create($request->only(['name', 'address', 'city', 'zip', 'country']));
        foreach ($reservation->locationSeats as $locationSeat) {
            $ticket = $booking->tickets()->create([
                'code' => mb_strtoupper(Str::random(10)),
            ]);
            $locationSeat->update([
                'ticket_id' => $ticket->id,
            ]);
        }
        $reservation->locationSeats()->update([
            'reservation_id' => null,
        ]);
        return response()->json([
            'tickets' => TicketResource::collection($booking->tickets()->with(['locationSeat' => function($query) {
                $query->with('locationSeatRow');
            }])->get()->sortBy('locationSeat.locationSeatRow.order')->sortBy('locationSeat.number')),
        ], 201);
    }
}
