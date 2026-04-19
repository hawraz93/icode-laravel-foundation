<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $username = '';
    public string $phone = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'min:3', 'max:30', 'regex:/^[A-Za-z0-9_.-]+$/', 'unique:'.User::class],
            'phone' => ['nullable', 'string', 'regex:/^\+?[0-9]{7,15}$/', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['username'] = $validated['username'] !== '' ? Str::lower($validated['username']) : null;
        $validated['phone'] = $validated['phone'] !== '' ? preg_replace('/\s+/', '', $validated['phone']) : null;
        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<section>
    @php
        $title = __('auth.register.title');
        if ($title === 'auth.register.title') {
            $title = __('auth.register.employeeRegistration');
        }

        $subtitle = __('auth.register.subtitle');
        if ($subtitle === 'auth.register.subtitle') {
            $subtitle = __('auth_ui.register_subtitle');
        }

        $emailLabel = __('auth.register.university_email');
        if ($emailLabel === 'auth.register.university_email') {
            $emailLabel = __('auth.register.email');
        }

        $usernameLabel = __('auth.register.username');
        $phoneLabel = __('auth.register.phone');

        $confirmPasswordLabel = __('auth.register.confirm_password');
        if ($confirmPasswordLabel === 'auth.register.confirm_password') {
            $confirmPasswordLabel = __('auth.register.confirmPassword');
        }

        $registerButton = __('auth.register.sign_up');
        if ($registerButton === 'auth.register.sign_up') {
            $registerButton = __('auth.register.register');
        }

        $haveAccountText = __('auth.register.have_account');
        if ($haveAccountText === 'auth.register.have_account') {
            $haveAccountText = __('auth.register.alreadyRegistered');
        }

        $signInText = __('auth.register.sign_in');
        if ($signInText === 'auth.register.sign_in') {
            $signInText = __('auth.login.btn');
        }
    @endphp

    <h1 class="auth-card-title">{{ $title }}</h1>
    <p class="auth-card-subtitle">{{ $subtitle }}</p>

    <form wire:submit.prevent="register" method="POST" action="{{ route('register') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <x-input-label for="name" :value="__('auth.register.name')" />
            <x-text-input wire:model="name" id="name" class="mt-1 block w-full rounded-xl" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="username" :value="$usernameLabel" />
            <x-text-input wire:model="username" id="username" class="mt-1 block w-full rounded-xl" type="text" name="username" autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="phone" :value="$phoneLabel" />
            <x-text-input wire:model="phone" id="phone" class="mt-1 block w-full rounded-xl" type="text" name="phone" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="$emailLabel" />
            <x-text-input wire:model="email" id="email" class="mt-1 block w-full rounded-xl" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('auth.register.password')" />
            <x-text-input wire:model="password" id="password" class="mt-1 block w-full rounded-xl" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="$confirmPasswordLabel" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-xl" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="btn-brand w-full" wire:loading.attr="disabled">
            {{ $registerButton }}
        </button>
    </form>

    <p class="mt-5 text-sm text-slate-600">
        {{ $haveAccountText }}
        <a class="text-brand-primary hover:underline" href="{{ route('login') }}" wire:navigate>
            {{ $signInText }}
        </a>
    </p>
</section>
