@extends("layouts.default")
@php
    $fields = ['name', 'major', 'email', 'phone'];
@endphp

@section("title", "Register")

@section("content")

    <div class="section">
        <div class="container">
            <div class="info">
                <div class="form">
                    <h2>Registratieformulier</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <p>
                            Hallo! Ik ben
                            <input type="text" id="name" name="name"
                                   class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                   placeholder="Jeroen de Beer" value="{{ old('name') }}" required>
                            . Ik doe de opleiding informatica met een
                            <select id="major" name="major"
                                    class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                    required>
                                <option value="SO" {{ (old('major') ?? 'SO') == 'SO' ? 'selected' : '' }}>SO</option>
                                <option value="BI" {{ old('major') == 'BI' ? 'selected' : '' }}>BI</option>
                            </select>
                            major aan Avans Hogeschool in 's-Hertogenbosch.<br />
                            Ik ben te bereiken via
                            <input type="email" id="email" name="email"
                                   class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                   placeholder="naam@domein.com" value="{{ old('email') }}" required>
                            of telefonisch via
                            <input type="tel" id="phone" name="phone"
                                   class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                   placeholder="+31 00 00000000" value="{{ old('phone') }}" required>
                            .<br />
                            Ik hoop snel mee te kunnen doen aan alle leuke activiteiten die op de planning staan!
                        </p>

                        @foreach ($fields as $field)
                            @error($field)
                            <span class="text-danger text-sm">{{ $message }}</span><br>
                            @enderror
                        @endforeach


                        <div class="mt-3">
                            <p>
                                Wachtwoord: <br/>
                                <input type="password" id="password" name="password"
                                       class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                       required>
                                <br/>
                                Herhaal wachtwoord: <br/>
                                <input type="password" id="confirm_password" name="password_confirmation"
                                       class="bg-indigo-100 text-purple-400 px-2 py-2 rounded-xl outline-none focus:ring-2 focus:ring-indigo-300 w-auto"
                                       required>
                            </p>

                            @error('password')
                            <span class="text-danger text-sm">{{ $message }}</span><br>
                            @enderror

                            <p class="mt-2 flex">
                                <input type="checkbox" class="labeled" name="privacy" id="privacy" required />
                                <label class="mb-0 ms-2 flex" for="privacy">Daarnaast ga ik uiteraard akkoord met het <a href="{{ asset('assets/files/privacyverklaring_concat.pdf') }}"><b>&nbsp;privacybeleid</b>.</a></label> <br />
                            </p>
                        </div>

                        <button type="submit" name="register"
                                class="btn btn-primary px-4 py-2 rounded-xl">
                            Registreren
                        </button>

                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
