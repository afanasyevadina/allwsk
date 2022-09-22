<?php

namespace App\Http\Controllers\Api\Organizer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EventDetailResource;
use App\Models\Organizer;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function show($organizerSlug, $eventSlug)
    {
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
        return EventDetailResource::make($event);
    }
}
