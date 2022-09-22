<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateChannelRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class ChannelController extends Controller
{
    public function create(Event $event)
    {
        return view('channels.create', [
            'event' => $event,
        ]);
    }

    public function store(Event $event, CreateChannelRequest $request)
    {
        $event->channels()->create($request->validated());
        return redirect()->route('events.detail', $event->id)->with('success', 'Channel successfully created');
    }
}
