<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-xl mt-5 mb-5">

    <form action="{{route('register')}}" method="POST" class="mt-4 space-y-4">

        @csrf

        <h2 class="text-center text-xl font-bold mb-4 text-purple-700">Registreren</h2>

        <div>
            <label for="name" class="block text-sm font-semibold">Naam:</label>
            <input type="text" name="name" id="naam" 
           aria-label="Vul uw naam alstublieft in"  value="{{old('name')}}"
                   class="w-full p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-            purple-500">

            @error('name')
            <div class="text-red-500 text-sm mt-1 font-bold">{{$message}}</div>
            @enderror
        </div>
        <div>
            <label for="email" class="block text-sm font-semibold">Email:</label>
            <input type="email" name="email" id="email" 
            aria-label="Vul uw email alstublieft in"
             value="{{old('email')}}"
                   class="w-full p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-                purple-500">

                   @error('email')
                    <div class="text-red-500 text-sm mt-1 font-bold">{{$message}}</div>
                    @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold">Wachtwoord:</label>
            <input type="password" name="password" id="password" aria-label="Vul een wachtwoord alstublieft in"
                   class="w-full p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-                    purple-500">

                   @error('password')
                    <div class="text-red-500 text-sm mt-1 font-bold">{{$message}}</div>
                    @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold">Bevestig wachtwoord:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" aria-label="Herhaal Uw wachtwoord alstublieft"  
                   class="w-full p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-                    purple-500">

                   @error('password_confirmation')
                     <div class="text-red-500 text-sm mt-1 font-bold">{{$message}}</div>
                    @enderror
        </div>


        <input type="submit" value="Register" class="w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition font-semibold cursor-pointer mt-4">
    </form>
    </div>
</x-layout>

