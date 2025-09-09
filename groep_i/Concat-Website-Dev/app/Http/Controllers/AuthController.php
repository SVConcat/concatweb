<?php

namespace App\Http\Controllers;

use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException as ValidationValidationException;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ],
        [
            // TODO: The error messages are currently written in Dutch. If the application will be used by a multilingual audience, consider using Laravel's localization features to make the messages adaptable to different languages

            'name.required' => 'Naam is verplicht.',
            'email.required' => 'email is verplicht.',
            'password.required' => 'wachtwoord is verplicht.',
        ]

    );

        $validated['role'] = 'client';
        $validated['password'] = bcrypt($validated['password']);

        $user = User::create($validated);

        Auth::login($user);

        // return redirect()->route('home');
        
        return redirect()->route('verification.notice');

    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'

        ],
        [
            'email.required' => 'Uw email alstublieft.',
            'password.required' => 'Uw wachtwoord alstublieft.',

        ]

    );

        if(Auth::attempt($validated))
        {
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        throw ValidationValidationException::withMessages([
            'credentials' => 'Sorry, onjuiste inloggegevens'
        ]);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        //return redirect()->back();
        return redirect()->route('home');
    }
}
