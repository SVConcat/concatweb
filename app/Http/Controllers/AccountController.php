<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRoleUpdateRequest;
use App\Http\Requests\AccountUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountController extends Controller
{
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

    public function edit()
    {
        $user = auth()->user();
        return view('account.edit', compact('user'));
    }

    // Edit own account
    public function update(AccountUpdateRequest $request)
    {
        $user = auth()->user();

        $user->name = $request->validated('name');
        $user->email = $request->validated('email');
        $user->password = Hash::make($request->validated('password'));

        $user->save();

        return redirect()
            ->route('account.show')
            ->with('success', 'Gegevens succesvol bijgewerkt');
    }

    // Update user role (admin only)
    public function updateUserRole(AccountRoleUpdateRequest $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Alleen admins kunnen rollen aanpassen.');
        }

        if ($user->id === auth()->id()) {
            return redirect()
                ->back()
                ->withErrors(['role' => 'Je kunt je eigen rol niet wijzigen.']);
        }

        $user->role = $request->validated('role');

        $user->save();

        return redirect()
            ->back()
            ->with('success', 'Rechten succesvol aangepast');
    }
}
