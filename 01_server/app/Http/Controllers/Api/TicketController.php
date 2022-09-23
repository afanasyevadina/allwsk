<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Booking;
use App\Models\LocationSeat;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function show(Request $request)
    {
        $booking = Booking::where('name', $request->input('name'))
            ->whereHas('tickets', fn($query) => $query->where('code', $request->input('code')))
            ->first();
        if (!$booking) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }
        return response()->json([
            'tickets' => TicketResource::collection($booking->tickets()->with(['locationSeat' => function($query) {
                $query->with('locationSeatRow');
            }])->get()->sortBy('locationSeat.locationSeatRow.order')->sortBy('locationSeat.number')),
        ]);
    }

    public function destroy($ticketId, Request $request)
    {
        $ticket = Ticket::find($ticketId);
        if (!$ticket) {
            return response()->json([
                'error' => 'A ticket with this ID does not exist',
            ], 404);
        }
        $booking = Booking::where('name', $request->input('name'))
            ->whereHas('tickets', fn($query) => $query->where('code', $request->input('code')))
            ->first();
        if (!$booking || !$booking->tickets()->where('id', $ticketId)->exists()) {
            return response()->json([
                'error' => 'Unauthorized',
            ], 401);
        }
        LocationSeat::where('ticket_id', $ticketId)->update([
            'reservation_id' => null,
            'ticket_id' => null,
        ]);
        $ticket->delete();
        return response()->noContent();
    }
}
