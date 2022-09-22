<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ConcertResource;
use App\Models\Concert;
use Illuminate\Http\Request;

class ConcertController extends Controller
{
    public function index()
    {
        return response()->json([
            'concerts' => ConcertResource::collection(Concert::orderBy('artist')->get()),
        ]);
    }

    public function show($concertId)
    {
        $concert = Concert::find($concertId);
        if (!$concert) {
            return response()->json([
                'error' => 'A concert with this ID does not exist',
            ], 404);
        }
        return response()->json([
            'concert' => ConcertResource::make($concert),
        ]);
    }
}
