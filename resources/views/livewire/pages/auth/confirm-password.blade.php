<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<section>
    <h1 class="auth-card-title">{{ __('auth_ui.confirm_title') }}</h1>
    <p class="auth-card-subtitle">{{ __('auth_ui.confirm_subtitle') }}</p>

    <form wire:submit.prevent="confirmPassword" method="POST" action="{{ route('password.confirm.store') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <x-input-label for="password" :value="__('auth_ui.password')" />
            <x-text-input wire:model="password" id="password" class="mt-1 block w-full rounded-xl" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <button type="submit" class="btn-brand w-full" wire:loading.attr="disabled">
            {{ __('auth_ui.confirm_button') }}
        </button>
    </form>
</section>
