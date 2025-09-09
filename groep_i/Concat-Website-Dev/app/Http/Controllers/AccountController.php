<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountController extends Controller
{
    // Toon eigen accountgegevens + lijst gebruikers als admin
    public function show(Request $request)
    {
        $user = auth()->user();
        $users = [];

        if ($user->role === 'admin') {
            $query = User::where('id', '!=', $user->id);

            if ($request->has('search') && $request->search !== '') {
                $query->where('email', 'like', '%' . $request->search . '%');
            }

            $users = $query->get();
        }

        return view('account.show', compact('user', 'users'));
    }

    // Bewerk eigen account
    public function edit()
    {
        $user = auth()->user();
        return view('account.edit', compact('user'));
    }

    // Update eigen account (email en wachtwoord)
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|required_with:password',
            'password' => 'nullable|confirmed|min:8',
        ]);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Huidig wachtwoord is incorrect'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->save();

        return redirect()->route('account.show')->with('success', 'Gegevens succesvol bijgewerkt');
    }

    // ADMIN: update rol van andere gebruiker
    public function updateUserRole(Request $request, User $user)
    {
        // Verwijder de Gate-check en vervang door simpele rolcheck
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Alleen admins kunnen rollen aanpassen.');
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors(['role' => 'Je kunt je eigen rol niet wijzigen.']);
        }

        $request->validate([
            'role' => 'required|in:student,admin',
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('account.show')->with('success', 'Rechten succesvol aangepast');
    }

}
