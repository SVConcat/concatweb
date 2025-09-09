<!DOCTYPE html>
<html
  class="h-full"
  data-theme="true"
  data-theme-mode="light"
  dir="ltr"
  lang="nl"
>
  <head>
      <link href="assets/vendors/keenicons/styles.bundle.css" rel="stylesheet" />
      <link rel="icon" href="{{ asset('assets/images/favicon.ico') }}">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>{{ config("app.name") }} | Login </title>
      <link rel="stylesheet" href="{{ asset("assets/css/login.css") }}" />
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </head>

  <body
    class="h-full flex items-center justify-center bg-[var(--input-background)] text-gray-900"
  >
    <div
      class="flex items-center justify-center grow bg-center bg-no-repeat page-bg relative w-full"
    >
      <!-- Login Card -->
      <div class="card relative">
        <!-- Back Button -->
        <a href="{{ url("/") }}" class="back-button">
          <i class="ki-filled ki-arrow-left text-2xl"></i>
        </a>

        <!-- Login Form -->
        <form
          action="{{ route("login") }}"
          class="card-body relative"
          id="sign_in_form"
          method="POST"
        >
          @csrf

          <!-- Titel -->
          <div class="text-center mb-4">
            <h3 class="has-background">Inloggen</h3>
          </div>

          <!-- Email Input -->
          <div class="w-full text-left mb-3">
            <label class="text-black font-semibold">E-mail</label>
            <input
              name="email"
              class="input @error("email") border-red-500 @enderror"
              placeholder="test@example.com"
              type="email"
              required
            />
            @error("email")
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
          </div>

          <!-- Password Input -->
          <div class="w-full text-left mb-3">
            <label class="text-black font-semibold">Wachtwoord</label>
            <div class="input-wrapper relative">
              <input
                name="password"
                class="input w-full"
                placeholder="Voer wachtwoord in"
                type="password"
                required
              />
              <i
                class="eye-icon ki-filled ki-eye absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer"
                onclick="togglePassword()"
              ></i>
            </div>
            @error("password")
              <span class="text-danger text-sm">{{ $message }}</span>
            @enderror
          </div>

          <!-- Inloggen Knop -->
          <button
            class="btn delete mt-4 w-full"
            type="submit"
            id="login-btn"
          >
            Inloggen
          </button>
        </form>

          <!-- Wachtwoord vergeten link -->
          <div class="mt-2">
              <a
                  href="{{ route('password.request') }}"
                  class="text-blue-600 hover:underline password-reset-button"
              >
                  Wachtwoord vergeten?
              </a>
          </div>
      </div>
    </div>

    <script>
      function togglePassword() {
        let input = document.querySelector('input[name="password"]');
        input.type = input.type === 'password' ? 'text' : 'password';
      }

      document.addEventListener('DOMContentLoaded', function () {
        let loginBtn = document.getElementById('login-btn');

        loginBtn.addEventListener('mouseover', function () {
          loginBtn.style.transform = 'scale(1.05)';
          loginBtn.style.boxShadow = '0px 8px 12px rgba(254, 64, 64, 0.3)';
        });

        loginBtn.addEventListener('mouseleave', function () {
          loginBtn.style.transform = 'scale(1)';
          loginBtn.style.boxShadow = 'var(--button-shadow)';
        });
      });
    </script>
  </body>
</html>
