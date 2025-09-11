<x-layout>
    <div class="bg-white p-6 rounded-xl shadow-lg w-full max-w-xl mt-5 mb-5">

    <form action="{{route('login')}}" method="POST" class="mt-4 space-y-4">

        @csrf

        <h2 class="text-center text-xl font-bold mb-4 text-purple-700">Login</h2>

        @if($errors->any())
          <ul class="px-4 py-2 bg-red-100">
            @foreach($errors->all() as $error)
              <li class="my-2 text-red-500">{{$error}}</li>
            @endforeach
          </ul>
        @endif

        <div>
            <label for="email" class="block text-sm font-semibold">Email:</label>
            <input type="email" name="email" id="email" aria-label="Vul uw email alstublieft in" value="{{old('email')}}"

                   class="w-full p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-purple-500">

        </div>

        <div>
            <label for="password" class="block text-sm font-semibold">Wachtwoord:</label>
            <input type="password" name="password" id="password" aria-label="Vul uw wachtwoord alstublieft in"
                   class="w-full p-2 bg-purple-100 text-purple-700 rounded-lg outline-none border border-purple-300 focus:ring-2 focus:ring-purple-500">

        </div>

        <div class="text-center mt-2">
          <a href="/register" class="text-sm text-purple-600 hover:underline hover:text-purple-800 font-medium">
            Nog geen account? Registreer hier
          </a>
      </div>
        
        <input type="submit" value="Login" class="w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600 transition font-semibold cursor-pointer mt-4">
    </form>
    </div>
</x-layout>

