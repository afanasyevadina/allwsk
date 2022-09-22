<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendee;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $attendee = Attendee::where('lastname', $request->input('lastname'))->where('registration_code', $request->input('registration_code'))->first();
        if (!$attendee) {
            return response()->json([
                'message' => 'Invalid login',
            ], 401);
        }
        $attendee->login_token = md5($attendee->username);
        $attendee->save();
        return response()->json([
            'firstname' => $attendee->firstname,
            'lastname' => $attendee->lastname,
            'username' => $attendee->username,
            'email' => $attendee->email,
            'token' => $attendee->login_token,
        ]);
    }

    public function logout(Request $request)
    {
        $attendee = Attendee::where('login_token', $request->input('token'))->first();
        if (!$attendee) {
            return response()->json([
                'message' => 'Invalid token',
            ], 401);
        }
        $attendee->login_token = null;
        $attendee->save();
        return response()->json([
            'message' => 'Logout success',
        ]);
    }
}
