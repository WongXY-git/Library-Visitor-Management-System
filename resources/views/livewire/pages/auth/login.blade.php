<?php

use App\Services\LdapAuthenticationService;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $username = '';
    public string $password = '';

    /**
     * Handle login attempt
     * Demo: Uses admin/password123
     * Later: Will use LDAP server
     */
    public function login(): void
    {
        $this->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $ldap = new LdapAuthenticationService();
        $user = $ldap->authenticate($this->username, $this->password);
        
        if (!$user) {
            $this->addError('username', 'Invalid credentials');
            return;
        }

        Session::put('user', $user);
        $this->redirect('/dashboard');
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <!-- Username -->
        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input wire:model="username" id="username" class="block mt-1 w-full" type="text" name="username" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</div>
