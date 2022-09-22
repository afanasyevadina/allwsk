<?php

namespace App\Http\Controllers\Api\Organizer\Event;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EventDetailResource;
use App\Models\Attendee;
use App\Models\Organizer;
use App\Models\Ticket;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store($organizerSlug, $eventSlug, Request $request)
    {
        $attendee = Attendee::where('login_token', $request->input('token'))->first();
        if (!$attendee) {
            return response()->json([
                'message' => 'User not logged in',
            ], 401);
        }
        $organizer = Organizer::where('slug', $organizerSlug)->first();
        if (!$organizer) {
            return response()->json([
                'message' => 'Organizer not found',
            ], 404);
        }
        $event = $organizer->events()->where('slug', $eventSlug)->first();
        if (!$event) {
            return response()->json([
                'message' => 'Event not found',
            ], 404);
        }
        if ($attendee->registrations()->whereHas('ticket', fn($query) => $query->where('event_id', $event->id))->exists()) {
            return response()->json([
                'message' => 'User already registered',
            ], 401);
        }
        $ticket = Ticket::find($request->input('ticket_id'));
        if (!$ticket || !$ticket->available) {
            return response()->json([
                'message' => 'Ticket is no longer available',
            ], 401);
        }
        $registration = $attendee->registrations()->create([
            'ticket_id' => $request->input('ticket_id'),
            'registration_time' => now(),
        ]);
        foreach ($request->input('session_ids') ?? [] as $item) {
            $registration->sessionRegistrations()->create([
                'session_id' => $item,
            ]);
        }
        return response()->json([
            'message' => 'Registration successful',
        ]);
    }
}
