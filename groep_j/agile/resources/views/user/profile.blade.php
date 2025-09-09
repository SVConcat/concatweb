@extends("layouts.default")

@section("title", "Profiel")

@section("content")
    <div class="section">
        <div class="container">
            <div class="profile-wrapper">
                @if(session('success'))
                    <div class="alert alert-success" id="success-alert">
                        {{ session('success') }}
                    </div>
                @endif
                <div class="profile-information">
                    <h2>Gegevens</h2>
                    <form method="POST" action="{{ route('user.profile.update') }}">
                        @csrf
                        <x-forms.input-field type="text" name="name" label="Naam" :required="true" value="{{ old('name', $user->name ?? '')}}"/>
                        <x-forms.input-select name="major" :required="true" label="Major" :enum="$majors" value="{{ old('major', $user->major ?? '')}}"/>
                        <div class="mb-1">
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email ?? '') }}"
                                required
                                class="w-full border border-gray-400 rounded-md py-2 px-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>
                        <p class="text-sm text-gray-600 italic mb-4">Als het e-mailadres wordt gewijzigd, dient deze opnieuw geverifieerd te worden voordat deze wordt opgeslagen en deze gebruikt kan worden.</p>
                        <x-forms.input-field type="phone" name="phone" label="Telefoonnummer" :required="true" value="{{ old('phone', $user->phone ?? '')}}"/>




                        <x-forms.input-checkbox
                            name="newsletter_subscription"
                            label="Inschrijven voor nieuwsbrief"
                            :checked="$user->newsletter_subscription ?? true"
                        />
                        <x-forms.input-checkbox
                            name="announcement_subscription"
                            label="Inschrijven voor nieuws"
                            :checked="$user->announcement_subscription ?? true"
                        />
                        <button class="item-button" type="submit" name="update_user">Update gegevens</button>
                    </form>
                </div>

                <div class="password-information">
                    <h2>Wachtwoord</h2>
                    <form method="POST" action="{{ route('user.password.update') }}">
                        @csrf
                        <x-forms.input-field type="password" name="current_password" label="Huidig wachtwoord" :required="true"/>
                        <x-forms.input-field type="password" name="password" label="Nieuw wachtwoord" :required="true"/>
                        <x-forms.input-field type="password" name="password_confirmation" label="Herhaal nieuw wachtwoord" :required="true"/>
                        <button class="item-button" type="submit" name="update_user_password">Update wachtwoord</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
