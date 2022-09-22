<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTicketRequest;
use App\Models\Event;

class TicketController extends Controller
{
    public function create(Event $event)
    {
        return view('tickets.create', [
            'event' => $event,
        ]);
    }

    public function store(Event $event, CreateTicketRequest $request)
    {
        $event->tickets()->create([
            'name' => $request->input('name'),
            'cost' => $request->input('cost'),
            'special_validity' => [
                'type' => $request->input('special_validity'),
                $request->input('special_validity') => $request->input($request->input('special_validity')),
            ],
        ]);
        return redirect()->route('events.detail', $event->id)->with('success', 'Ticket successfully created');
    }
}
