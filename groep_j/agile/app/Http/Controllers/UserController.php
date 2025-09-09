<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Enums\UserMajorEnum;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function index(){
        $user = auth()->user();
        $majors = UserMajorEnum::class;
        return view('user.profile', ['user' => $user, 'majors' => $majors]);
    }

    public function register(Request $request){
        $user = app(CreateNewUser::class)->create($request->all());

        event(new Registered($user));

        return redirect()->route('verification.notice');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        app(UpdateUserProfileInformation::class)->update($user, $request->all());
        return to_route('user.profile.index')->with('success', 'Profiel bijgewerkt.');
    }

    public function password(Request $request){
        $user = auth()->user();
        app(UpdateUserPassword::class)->update($user, $request->all());
        return to_route('user.profile.index')->with('success', 'Wachtwoord bijgewerkt.');
    }

    public function verifyEmail(Request $request, $id, $hash){
        $user = User::findOrFail($id);

        // Bepaal welke email er vergeleken moet worden (new_email krijgt prioriteit)
        $emailToVerify = $user->new_email ?? $user->email;

        if (! hash_equals((string) $hash, sha1($emailToVerify))) {
            abort(403, 'Ongeldige verificatielink.');
        }

        if ($user->new_email) {
            $user->email_verified_at = null;
            $user->email = $user->new_email;
            $user->new_email = null;
        }

        if (! $user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            event(new Verified($user));
        }

        return redirect('/login')->with('status', 'Je e-mailadres is geverifieerd. Je kunt nu inloggen.');
    }

}
