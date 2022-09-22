<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\RegistrationResource;
use App\Models\Attendee;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $attendee = Attendee::where('login_token', $request->input('token'))->first();
        if (!$attendee) {
            return response()->json([
                'message' => 'User not logged in',
            ], 401);
        }
        return response()->json([
            'registrations' => RegistrationResource::collection($attendee->registrations),
        ]);
    }
}
