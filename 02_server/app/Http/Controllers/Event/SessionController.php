<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSessionRequest;
use App\Http\Requests\UpdateSessionRequest;
use App\Models\Event;
use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function create(Event $event)
    {
        return view('sessions.create', [
            'event' => $event,
        ]);
    }

    public function store(Event $event, CreateSessionRequest $request)
    {
        Session::create($request->validated());
        return redirect()->route('events.detail', $event->id)->with('success', 'Session successfully created');
    }

    public function edit(Event $event, Session $session)
    {
        return view('sessions.edit', [
            'event' => $event,
            'session' => $session,
        ]);
    }

    public function update(Event $event, Session $session, UpdateSessionRequest $request)
    {
        $session->update($request->validated());
        return redirect()->route('events.detail', $event->id)->with('success', 'Session successfully updated');
    }
}
