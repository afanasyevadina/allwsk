<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRoomRequest;
use App\Models\Event;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function create(Event $event)
    {
        return view('rooms.create', [
            'event' => $event,
        ]);
    }

    public function store(Event $event, CreateRoomRequest $request)
    {
        Room::create($request->validated());
        return redirect()->route('events.detail', $event->id)->with('success', 'Room successfully created');
    }
}
