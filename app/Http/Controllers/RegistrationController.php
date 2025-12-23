<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function store(RegistrationRequest $request)
    {
        Registration::create([
            'user_id' => auth()->check() ? auth()->id() : null,
            'event_id' => $request->validated(['event_id']),
            'naam' => $request->validated(['naam']),
            'email' => $request->validated(['email']),
        ]);

        return redirect()
            ->back()
            ->with('success', 'Je bent succesvol ingeschreven!');
    }
}

