<?php

namespace App\Http\Controllers\Api\Concerts\Shows;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeatingResource;
use App\Models\Concert;

class SeatingController extends Controller
{
    public function show($concertId, $showId)
    {
        $concert = Concert::find($concertId);
        if (!$concert || !$show = $concert->shows()->find($showId)) {
            return response()->json([
                'error' => 'A concert or show with this ID does not exist',
            ], 404);
        }
        return response()->json([
            'rows' => SeatingResource::collection($show->locationSeatRows()->orderBy('order')->get()),
        ]);
    }
}
