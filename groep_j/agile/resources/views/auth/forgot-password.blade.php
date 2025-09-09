@extends("layouts.default")

@section("title", "Forgot password")

@section('content')
    <div class="section">
        <div class="container">
            <div class="password-wrapper">
                <h2>Wachtwoord vergeten</h2>

                @if(session('status'))
                    <div class="alert alert-success" id="success-alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <x-forms.input-field type="email" name="email" label="E-mailadres" :required="true" value="{{ old('email' ?? '')}}"/>

                    <button class="item-button w-full" type="submit">Wachtwoord reset link versturen</button>
                </form>
            </div>
        </div>
    </div>
@endsection
