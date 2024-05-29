<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo class="w-24 h-24 mx-auto mb-8"/>
        </x-slot>

        <x-validation-errors class="mb-4"/>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div class="flex flex-col space-y-2">
                <x-label for="email" value="{{ __('Email') }}" class="block text-sm font-medium text-gray-700"/>
                <x-input id="email" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"/>
            </div>

            <div class="flex flex-col space-y-2">
                <x-label for="password" value="{{ __('Password') }}" class="block text-sm font-medium text-gray-700"/>
                <x-input id="password" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm transition duration-200" type="password" name="password" required autocomplete="current-password"/>
            </div>

            <div class="flex items-center">
                <x-checkbox id="remember_me" name="remember" class="rounded border-gray-300 text-indigo-600 focus:border-indigo-500 focus:ring-indigo-500 transition duration-200"/>
                <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
            </div>

            <div class="flex items-center justify-between mt-4">
                @if (Route::has('password.request'))
                    <a class="text-sm text-indigo-600 hover:text-indigo-900 focus:outline-none focus:underline transition duration-200" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md focus:outline-none focus:shadow-outline transition duration-200">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>

<style>
    html[lang="ar"] {
        direction: rtl;
        text-align: right;
    }
</style>
