<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'naam' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:registrations,email,NULL,id,event_id,' . $request->event_id,
        ]);

        registration::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'event_id' => $request->event_id,
            'naam' => $request->naam,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Je bent succesvol ingeschreven!');
    }
}

