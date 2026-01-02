<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function store(RegistrationRequest $request)
    {
        $validated = $request->validated();

        Registration::create([
            ...$validated,
            'user_id' => auth()->check() ? auth()->id() : null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Je bent succesvol ingeschreven!');
    }
}

