<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<section>
    @php
        $registerCta = __('auth.login.create_account');
        if ($registerCta === 'auth.login.create_account') {
            $registerCta = __('auth_ui.no_account_register');
        }
    @endphp

    <h1 class="auth-card-title">{{ __('auth.login.title') }}</h1>
    <p class="auth-card-subtitle">{{ __('auth.login.subtitle') }}</p>

    <x-auth-session-status class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700" :status="session('status')" />

    <form wire:submit.prevent="login" method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
        @csrf
        <div>
            <x-input-label for="login" :value="__('auth.login.login_field')" />
            <x-text-input wire:model="form.login" id="login" class="mt-1 block w-full rounded-xl" type="text" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.login')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('auth.login.password')" />
            <x-text-input wire:model="form.password" id="password" class="mt-1 block w-full rounded-xl" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <label for="remember" class="inline-flex items-center gap-2">
            <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-slate-300 text-sky-600 shadow-sm focus:ring-sky-500" name="remember">
            <span class="text-sm text-slate-600">{{ __('auth.login.remember') }}</span>
        </label>

        <button type="submit" class="btn-brand w-full" wire:loading.attr="disabled">
            {{ __('auth.login.btn') }}
        </button>
    </form>

    <div class="mt-5 flex flex-wrap items-center justify-between gap-3 text-sm">
        <a class="text-brand-primary hover:underline" href="{{ route('password.request') }}" wire:navigate>
            {{ __('auth.login.forgot') }}
        </a>
        <a class="text-slate-600 hover:text-slate-900 hover:underline" href="{{ route('register') }}" wire:navigate>
            {{ $registerCta }}
        </a>
    </div>
</section>
