<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EventResource;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return response()->json([
            'events' => EventResource::collection(Event::where('date', '>', '2019-09-01')->orderBy('date')->get()),
        ]);
    }
}
