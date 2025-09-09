@extends("layouts.default")

@section("title", "Verify Email")

@section("content")
    <div class="section">
        <div class="container">
            <div class="profile-wrapper text-center">
                    <h1 class="text-xl font-bold text-gray-700 mb-4">Verifieer je e-mailadres</h1>

                    @if (session('message'))
                        <div class="mb-4 text-green-600">
                            {{ session('message') }}
                        </div>
                    @endif

                    <p class="mb-4">
                        We hebben een verificatielink naar je e-mailadres gestuurd. Klik op de link om je account te activeren. Hierna kun je inloggen.
                    </p>
            </div>
        </div>
    </div>

@endsection
