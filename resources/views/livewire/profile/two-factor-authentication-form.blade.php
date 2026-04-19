<?php

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\EnableTwoFactorAuthentication;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\RecoveryCode;
use Livewire\Volt\Component;

new class extends Component
{
    public bool $showingQrCode = false;
    public bool $showingRecoveryCodes = false;
    public array $recoveryCodes = [];
    public string $code = '';

    public function mount(): void
    {
        $this->showingQrCode = $this->showingTwoFactorSetup();
    }

    public function showingTwoFactorSetup(): bool
    {
        $user = Auth::user();

        return ! is_null($user->two_factor_secret) && is_null($user->two_factor_confirmed_at);
    }

    public function enabled(): bool
    {
        return Auth::user()->hasEnabledTwoFactorAuthentication();
    }

    public function enableTwoFactorAuthentication(EnableTwoFactorAuthentication $enable): void
    {
        $enable(Auth::user());

        $this->showingQrCode = true;
        $this->showingRecoveryCodes = true;
        $this->recoveryCodes = Auth::user()->recoveryCodes();

        $this->dispatch('open-modal', 'two-factor-setup-modal');
    }

    public function openSetupModal(): void
    {
        $this->dispatch('open-modal', 'two-factor-setup-modal');
    }

    public function confirmTwoFactorAuthentication(): void
    {
        $this->validate([
            'code' => ['required', 'string', 'max:10'],
        ]);

        $user = Auth::user();

        if (is_null($user->two_factor_secret)) {
            throw ValidationException::withMessages([
                'code' => __('profile.two_factor_not_enabled'),
            ]);
        }

        $valid = app(TwoFactorAuthenticationProvider::class)->verify(
            Fortify::currentEncrypter()->decrypt($user->two_factor_secret),
            $this->code
        );

        if (! $valid) {
            throw ValidationException::withMessages([
                'code' => __('profile.two_factor_invalid_code'),
            ]);
        }

        $user->forceFill([
            'two_factor_confirmed_at' => now(),
        ])->save();

        $this->code = '';
        $this->showingQrCode = false;
        $this->showRecoveryCodes();

        $this->dispatch('close-modal', 'two-factor-setup-modal');
    }

    public function showRecoveryCodes(): void
    {
        $this->showingRecoveryCodes = true;
        $this->recoveryCodes = Auth::user()->recoveryCodes();

        $this->dispatch('open-modal', 'two-factor-recovery-modal');
    }

    public function regenerateRecoveryCodes(): void
    {
        $user = Auth::user();

        $user->forceFill([
            'two_factor_recovery_codes' => Fortify::currentEncrypter()->encrypt(json_encode(Collection::times(8, fn () => RecoveryCode::generate())->all())),
        ])->save();

        $this->showRecoveryCodes();
    }

    public function disableTwoFactorAuthentication(DisableTwoFactorAuthentication $disable): void
    {
        $disable(Auth::user());

        $this->reset('code', 'recoveryCodes');
        $this->showingQrCode = false;
        $this->showingRecoveryCodes = false;

        $this->dispatch('close-modal', 'two-factor-setup-modal');
        $this->dispatch('close-modal', 'two-factor-recovery-modal');
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-slate-900">{{ __('profile.two_factor_title') }}</h2>
        <p class="mt-1 text-sm text-slate-600">{{ __('profile.two_factor_desc') }}</p>
    </header>

    @if (! $this->enabled() && ! $this->showingTwoFactorSetup())
        <x-primary-button wire:click="enableTwoFactorAuthentication">{{ __('profile.two_factor_enable') }}</x-primary-button>
    @endif

    @if ($this->showingTwoFactorSetup())
        <div class="rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
            <p>{{ __('profile.two_factor_pending_setup') }}</p>
            <button wire:click="openSetupModal" class="mt-2 font-semibold text-amber-900 underline">
                {{ __('profile.two_factor_open_setup') }}
            </button>
        </div>
    @endif

    @if ($this->enabled())
        <p class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ __('profile.two_factor_enabled') }}</p>

        <div class="flex flex-wrap items-center gap-3">
            <x-secondary-button wire:click="showRecoveryCodes">{{ __('profile.two_factor_show_recovery') }}</x-secondary-button>
            <x-secondary-button wire:click="regenerateRecoveryCodes">{{ __('profile.two_factor_regenerate_recovery') }}</x-secondary-button>
            <x-danger-button wire:click="disableTwoFactorAuthentication">{{ __('profile.two_factor_disable') }}</x-danger-button>
        </div>
    @endif

    <x-modal name="two-factor-setup-modal" focusable>
        <div class="space-y-4 p-6">
            <h3 class="text-lg font-semibold text-slate-900">{{ __('profile.two_factor_setup_title') }}</h3>
            <p class="text-sm text-slate-600">{{ __('profile.two_factor_scan_qr') }}</p>

            @if ($this->showingTwoFactorSetup() && auth()->user()->two_factor_secret)
                <div class="inline-flex rounded-lg border border-slate-200 bg-white p-3">
                    {!! Auth::user()->twoFactorQrCodeSvg() !!}
                </div>

                <div>
                    <x-input-label for="code" :value="__('profile.two_factor_code')" />
                    <x-text-input wire:model="code" id="code" type="text" class="mt-1 block w-full" autocomplete="one-time-code" />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <x-primary-button wire:click="confirmTwoFactorAuthentication">{{ __('profile.two_factor_confirm') }}</x-primary-button>
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'two-factor-setup-modal')">{{ __('profile.close') }}</x-secondary-button>
                </div>
            @else
                <p class="text-sm text-slate-600">{{ __('profile.two_factor_not_enabled') }}</p>
            @endif
        </div>
    </x-modal>

    <x-modal name="two-factor-recovery-modal" maxWidth="lg">
        <div class="space-y-4 p-6" x-data="{ copied: false, codesText: @js(implode("\n", $recoveryCodes)) }" x-effect="codesText = @js(implode("\n", $recoveryCodes))">
            <h3 class="text-lg font-semibold text-slate-900">{{ __('profile.two_factor_recovery_title') }}</h3>
            <p class="text-sm text-slate-600">{{ __('profile.two_factor_recovery_hint') }}</p>

            <div class="grid gap-2 rounded-lg bg-slate-900/95 p-3 font-mono text-sm text-emerald-300">
                @foreach ($recoveryCodes as $recoveryCode)
                    <div>{{ $recoveryCode }}</div>
                @endforeach
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <button
                    type="button"
                    class="btn-soft"
                    x-on:click="navigator.clipboard.writeText(codesText); copied = true; setTimeout(() => copied = false, 1800);"
                >
                    <span x-show="!copied">{{ __('profile.copy_codes') }}</span>
                    <span x-show="copied" style="display:none;">{{ __('profile.copied') }}</span>
                </button>

                <button
                    type="button"
                    class="btn-soft"
                    x-on:click="const w = window.open('', '_blank'); w.document.write('<pre style=\"font-family:monospace;padding:24px;\">'+codesText+'</pre>'); w.document.close(); w.print();"
                >
                    {{ __('profile.print_codes') }}
                </button>

                <x-secondary-button x-on:click="$dispatch('close-modal', 'two-factor-recovery-modal')">{{ __('profile.close') }}</x-secondary-button>
            </div>
        </div>
    </x-modal>
</section>
