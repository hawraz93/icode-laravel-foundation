<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';
    public array $sessions = [];

    public function mount(): void
    {
        $this->refreshSessions();
    }

    public function refreshSessions(): void
    {
        $sessionTable = (string) config('session.table', 'sessions');
        $sessionConnection = config('session.connection');

        if (! DB::connection($sessionConnection)->getSchemaBuilder()->hasTable($sessionTable)) {
            $this->sessions = [];
            return;
        }

        $currentSessionId = session()->getId();

        $this->sessions = DB::connection($sessionConnection)->table($sessionTable)
            ->where('user_id', Auth::id())
            ->orderByDesc('last_activity')
            ->get()
            ->map(function ($session) use ($currentSessionId) {
                return [
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'user_agent' => (string) $session->user_agent,
                    'last_active' => \Carbon\Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
                    'is_current_device' => $session->id === $currentSessionId,
                ];
            })
            ->all();
    }

    public function logoutOtherBrowserSessions(): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ], [
            'password.current_password' => __('profile.current_password_invalid'),
        ]);

        $userId = Auth::id();
        $currentSessionId = session()->getId();
        $sessionTable = (string) config('session.table', 'sessions');
        $sessionConnection = config('session.connection');

        Auth::logoutOtherDevices($this->password);

        if (DB::connection($sessionConnection)->getSchemaBuilder()->hasTable($sessionTable)) {
            DB::connection($sessionConnection)->table($sessionTable)
                ->where('user_id', $userId)
                ->where('id', '!=', $currentSessionId)
                ->delete();
        }

        $this->reset('password');
        $this->refreshSessions();

        $this->dispatch('browser-sessions-logged-out');
    }
}; ?>

<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-slate-900">{{ __('profile.browser_sessions_title') }}</h2>
        <p class="mt-1 text-sm text-slate-600">{{ __('profile.browser_sessions_desc') }}</p>
    </header>

    @if (count($sessions) === 0)
        <p class="text-sm text-slate-600">{{ __('profile.no_sessions') }}</p>
    @else
        <div class="space-y-3">
            @foreach ($sessions as $session)
                <div class="rounded-xl border border-slate-200 bg-white p-3">
                    <p class="text-sm font-semibold text-slate-800">
                        {{ $session['is_current_device'] ? __('profile.this_device') : __('profile.other_device') }}
                    </p>
                    <p class="mt-1 text-xs text-slate-500">{{ $session['user_agent'] ?: __('profile.unknown_device') }}</p>
                    <p class="mt-1 text-xs text-slate-500">IP: {{ $session['ip_address'] ?: '-' }} | {{ $session['last_active'] }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <div class="space-y-4">
        <div>
            <x-input-label for="logout_other_password" :value="__('profile.password_confirm_to_logout')" />
            <x-text-input wire:model="password" id="logout_other_password" name="password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button type="button" wire:click="logoutOtherBrowserSessions" wire:loading.attr="disabled" wire:target="logoutOtherBrowserSessions">
                {{ __('profile.logout_other_sessions') }}
            </x-primary-button>

            <x-action-message class="me-3" on="browser-sessions-logged-out">
                {{ __('profile.saved') }}
            </x-action-message>
        </div>
    </div>
</section>
