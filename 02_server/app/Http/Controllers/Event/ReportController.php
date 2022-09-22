<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Event $event)
    {
        return view('reports.index', [
            'event' => $event,
            'rooms' => $event->rooms()->withCount('sessionRegistrations')->get(),
        ]);
    }
}
