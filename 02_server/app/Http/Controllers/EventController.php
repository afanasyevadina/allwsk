<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return view('events.index', [
            'events' => auth()->user()->events()->withCount('registrations')->orderBy('date')->get(),
        ]);
    }

    public function detail(Event $event)
    {
        return view('events.detail', [
            'event' => $event,
        ]);
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(CreateEventRequest $request)
    {
        $event = auth()->user()->events()->create($request->validated());
        return redirect()->route('events.detail', $event->id)->with('success', 'Event successfully created');
    }

    public function edit(Event $event)
    {
        return view('events.edit', [
            'event' => $event,
        ]);
    }

    public function update(Event $event, UpdateEventRequest $request)
    {
        $event->update($request->validated());
        return redirect()->route('events.detail', $event->id)->with('success', 'Event successfully updated');
    }
}
