<?php

namespace App\Http\Controllers;

use App\Models\Organizer;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showForm()
    {
        return view('index');
    }

    public function login(Request $request)
    {
        if (!$organizer = Organizer::where('email', $request->input('email'))->where('password_hash', $request->input('password'))->first()) {
            return redirect()->back()->withErrors(['email' => 'Email or password not correct']);
        }
        auth()->login($organizer);
        return redirect()->route('events');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('index');
    }
}
