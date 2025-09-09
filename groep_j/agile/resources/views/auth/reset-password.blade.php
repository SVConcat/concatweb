@extends("layouts.default")

@section("title", "Reset password")

@section('content')
    <div class="section">
        <div class="container">
            <div class="password-wrapper">
                <h2>Wachtwoord opnieuw instellen</h2>

                @if(session('status'))
                    <div class="alert alert-success" id="success-alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <x-forms.input-field type="email" name="email" label="E-mailadres" :required="true" value="{{ old('email', $request->email ?? '')}}"/>
                    <x-forms.input-field type="password" name="password" label="Nieuw wachtwoord" :required="true"/>
                    <x-forms.input-field type="password" name="password_confirmation" label="Herhaal nieuw wachtwoord" :required="true"/>
                    <button class="item-button w-full" type="submit" name="update_user_password">Wachtwoord resetten</button>
                </form>
            </div>
        </div>
    </div>
@endsection
