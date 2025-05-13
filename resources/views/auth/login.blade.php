<!-- resources/views/auth/login.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>{{ config('app.name', 'Laravel') }} — Connexion</title>
  
  <!-- Tailwind + JS -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 dark:bg-gray-900 flex items-center justify-center">

  <div class="w-full max-w-md bg-white dark:bg-gray-800 shadow-lg rounded-lg p-6">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-2xl font-bold text-center text-gray-800 dark:text-gray-100 mb-6">
      {{ __('Connexion') }}
    </h2>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
      @csrf

      <!-- Email Address -->
      <div>
        <x-input-label for="email" :value="__('Email')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
        <x-text-input 
          id="email" 
          class="mt-1 block w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
          type="email" 
          name="email" 
          :value="old('email')" 
          required 
          autofocus 
          autocomplete="username" 
        />
        <x-input-error :messages="$errors->get('email')" class="mt-1 text-sm text-red-600" />
      </div>

      <!-- Password -->
      <div>
        <x-input-label for="password" :value="__('Mot de passe')" class="block text-sm font-medium text-gray-700 dark:text-gray-300" />
        <x-text-input 
          id="password" 
          class="mt-1 block w-full px-3 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" 
          type="password" 
          name="password" 
          required 
          autocomplete="current-password" 
        />
        <x-input-error :messages="$errors->get('password')" class="mt-1 text-sm text-red-600" />
      </div>

      <!-- Remember Me -->
      <div class="flex items-center">
        <input 
          id="remember_me" 
          type="checkbox" 
          name="remember" 
          class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" 
        />
        <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
          {{ __('Se souvenir de moi') }}
        </label>
      </div>

      <div class="flex items-center justify-between">
        @if (Route::has('password.request'))
          <a 
            href="{{ route('password.request') }}" 
            class="text-sm text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-200"
          >
            {{ __('Mot de passe oublié ?') }}
          </a>
        @endif

        <x-primary-button class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-500 dark:hover:bg-indigo-600 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
          {{ __('Se connecter') }}
        </x-primary-button>
      </div>
    </form>
  </div>

</body>
</html>
