<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-3xl mt-5 mb-5 mx-auto">
        <h1 class="text-2xl font-bold border-b-4 border-purple-500 inline-block pb-1">Gegevens bewerken</h1>

        <form method="POST" action="{{ route('account.update') }}" class="mt-6 space-y-6" novalidate>
            @csrf

            <div>
                <label for="name" class="block text-lg font-bold mb-1">Naam<span class="text-red-600">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                    class="w-full p-2 rounded-lg border outline-none focus:ring-2 focus:ring-purple-500
                           {{ $errors->has('name') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }}">
                @error('name')
                    <p class="text-red-600 text-sm mt-1 font-semibold" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-lg font-bold mb-1">E-mailadres<span class="text-red-600">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                    class="w-full p-2 rounded-lg border outline-none focus:ring-2 focus:ring-purple-500
                           {{ $errors->has('email') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }}">
                @error('email')
                    <p class="text-red-600 text-sm mt-1 font-semibold" role="alert">{{ $message }}</p>
                @enderror
            </div>

            <fieldset class="border-t pt-6 space-y-4">
                <legend class="text-lg font-bold">Wachtwoord wijzigen (optioneel)</legend>

                <div>
                    <label for="current_password" class="block text-lg font-bold mb-1">Huidig wachtwoord<span class="text-red-600">*</span></label>
                    <input type="password" name="current_password" id="current_password"
                        class="w-full p-2 rounded-lg border outline-none focus:ring-2 focus:ring-purple-500
                               {{ $errors->has('current_password') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }}">
                    @error('current_password')
                        <p class="text-red-600 text-sm mt-1 font-semibold" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-lg font-bold mb-1">Nieuw wachtwoord</label>
                    <input type="password" name="password" id="password"
                        class="w-full p-2 rounded-lg border outline-none focus:ring-2 focus:ring-purple-500
                               {{ $errors->has('password') ? 'bg-red-100 border-red-300 text-red-700' : 'bg-purple-100 border-purple-300 text-purple-700' }}">
                    @error('password')
                        <p class="text-red-600 text-sm mt-1 font-semibold" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-lg font-bold mb-1">Bevestig nieuw wachtwoord</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full p-2 rounded-lg border border-purple-300 bg-purple-100 text-purple-700 outline-none focus:ring-2 focus:ring-purple-500">
                </div>
            </fieldset>

            <button type="submit"
                class="w-full bg-red-500 text-white p-3 rounded-lg hover:bg-red-600 transition font-semibold cursor-pointer">
                Opslaan
            </button>
        </form>
    </div>
</x-layout>
