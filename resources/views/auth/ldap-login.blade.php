<x-guest-layout>
    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-900 dark:text-gray-100">
            Library Visitor Management System
        </h2>

        @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600 dark:text-red-400">
                    {{ $errors->first('credentials') }}
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" 
                    class="block mt-1 w-full" 
                    type="text" 
                    name="username" 
                    :value="old('username')" 
                    required 
                    autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" 
                    class="block mt-1 w-full"
                    type="password"
                    name="password"
                    required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="w-full justify-center">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>