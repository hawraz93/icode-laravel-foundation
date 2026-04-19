<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink($this->only('email'));

        if ($status !== Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
}; ?>

<section>
    <h1 class="auth-card-title">{{ __('auth.forgot.title') }}</h1>
    <p class="auth-card-subtitle">{{ __('auth.forgot.subtitle') }}</p>

    <x-auth-session-status class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

    <form wire:submit.prevent="sendPasswordResetLink" method="POST" action="{{ route('password.email') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <x-input-label for="email" :value="__('auth.forgot.email')" />
            <x-text-input wire:model="email" id="email" class="mt-1 block w-full rounded-xl" type="email" name="email" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="btn-brand w-full" wire:loading.attr="disabled">
            {{ __('auth.forgot.btn') }}
        </button>
    </form>

    <p class="mt-5 text-sm text-slate-600">
        <a class="text-brand-primary hover:underline" href="{{ route('login') }}" wire:navigate>{{ __('auth.forgot.back') }}</a>
    </p>
</section>
