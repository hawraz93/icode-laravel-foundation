<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            return;
        }

        Auth::user()->sendEmailVerificationNotification();
        Session::flash('status', 'verification-link-sent');
    }

    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

<section>
    <h1 class="auth-card-title">{{ __('auth_ui.verify_title') }}</h1>
    <p class="auth-card-subtitle">{{ __('auth_ui.verify_subtitle') }}</p>

    @if (session('status') === 'verification-link-sent')
        <div class="mt-4 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ __('auth_ui.verify_sent') }}
        </div>
    @endif

    <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
        <button wire:click="sendVerification" type="button" class="btn-brand">
            {{ __('auth.inactive.verify_email_resend') }}
        </button>
        <button wire:click="logout" type="button" class="btn-soft">
            {{ __('auth_ui.logout') }}
        </button>
    </div>
</section>
