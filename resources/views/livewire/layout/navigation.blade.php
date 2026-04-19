<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

@php
    $navLayout = config('branding.navigation_layout', 'topbar');
    $sidebarDensity = session('sidebar_density', config('branding.sidebar_density', 'normal'));
    $isCompactSidebar = $sidebarDensity === 'compact';
    $menuItems = config('navigation.items', []);
    $user = auth()->user();

    $iconSvg = function (string $name): string {
        return match ($name) {
            'dashboard' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 13h8V3H3v10zm10 8h8V11h-8v10zM3 21h8v-6H3v6zm10-8h8V3h-8v10z"/></svg>',
            'layers' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m12 2 9 5-9 5-9-5 9-5Z"/><path d="m3 12 9 5 9-5"/><path d="m3 17 9 5 9-5"/></svg>',
            'calendar' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>',
            'building' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 22h18"/><path d="M6 18V4h12v14"/><path d="M9 9h.01M9 13h.01M15 9h.01M15 13h.01"/></svg>',
            'shield-users' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3 4 7v6c0 5 3.4 8.6 8 10 4.6-1.4 8-5 8-10V7l-8-4Z"/><path d="M9.5 13a2 2 0 1 1 0-4 2 2 0 0 1 0 4Zm5 0a2 2 0 1 1 0-4 2 2 0 0 1 0 4Z"/></svg>',
            'users' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'user' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21a8 8 0 1 0-16 0"/><circle cx="12" cy="7" r="4"/></svg>',
            'key' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="7.5" cy="15.5" r="5.5"/><path d="m21 2-9.6 9.6"/><path d="M15.5 7.5 19 11l2-2-3.5-3.5"/></svg>',
            'settings' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06A1.7 1.7 0 0 0 15 19.4a1.7 1.7 0 0 0-1 .6 1.7 1.7 0 0 1-3 0 1.7 1.7 0 0 0-1-.6 1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-.6-1 1.7 1.7 0 0 1 0-3 1.7 1.7 0 0 0 .6-1 1.7 1.7 0 0 0-.34-1.87l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1-.6 1.7 1.7 0 0 1 3 0 1.7 1.7 0 0 0 1 .6 1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9c.25.37.6.66 1 .84a1.7 1.7 0 0 1 0 3c-.4.18-.75.47-1 .84Z"/></svg>',
            'lock' => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="11" width="16" height="10" rx="2"/><path d="M8 11V7a4 4 0 1 1 8 0v4"/></svg>',
            default => '<svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><circle cx="12" cy="12" r="3"/></svg>',
        };
    };

    $canAccessItem = function (array $item) use ($user): bool {
        if (! $user) {
            return false;
        }

        if (! empty($item['permission']) && method_exists($user, 'can') && ! $user->can($item['permission'])) {
            return false;
        }

        if (! empty($item['permissions']) && method_exists($user, 'can')) {
            foreach ((array) $item['permissions'] as $permission) {
                if (! $user->can($permission)) {
                    return false;
                }
            }
        }

        if (! empty($item['any_permissions']) && method_exists($user, 'can')) {
            $allowed = collect($item['any_permissions'])->contains(fn (string $permission) => $user->can($permission));
            if (! $allowed) {
                return false;
            }
        }

        if (! empty($item['role']) && method_exists($user, 'hasRole') && ! $user->hasRole($item['role'])) {
            return false;
        }

        if (! empty($item['roles']) && method_exists($user, 'hasRole')) {
            foreach ((array) $item['roles'] as $role) {
                if (! $user->hasRole($role)) {
                    return false;
                }
            }
        }

        if (! empty($item['any_roles']) && method_exists($user, 'hasAnyRole') && ! $user->hasAnyRole($item['any_roles'])) {
            return false;
        }

        return true;
    };

    $filterItems = function (array $items) use (&$filterItems, $canAccessItem): array {
        $filtered = [];

        foreach ($items as $item) {
            if (! $canAccessItem($item)) {
                continue;
            }

            $children = [];
            if (! empty($item['children']) && is_array($item['children'])) {
                $children = $filterItems($item['children']);
            }

            $item['children'] = $children;

            if (empty($item['route']) && empty($item['url']) && $children === []) {
                continue;
            }

            $filtered[] = $item;
        }

        return $filtered;
    };

    $visibleItems = $filterItems($menuItems);

    $itemUrl = function (array $item): string {
        if (! empty($item['route'])) {
            return route($item['route']);
        }

        if (! empty($item['url'])) {
            return $item['url'];
        }

        return '#';
    };

    $itemActive = function (array $item) use (&$itemActive, $itemUrl): bool {
        if (! empty($item['active']) && is_array($item['active'])) {
            foreach ($item['active'] as $pattern) {
                if (request()->routeIs($pattern)) {
                    return true;
                }
            }
        }

        if (! empty($item['route']) && request()->routeIs($item['route'])) {
            return true;
        }

        if (! empty($item['url'])) {
            $itemPath = trim((string) parse_url($itemUrl($item), PHP_URL_PATH), '/');
            $currentPath = trim(request()->path(), '/');
            if ($itemPath !== '' && $itemPath === $currentPath) {
                return true;
            }
        }

        if (! empty($item['children'])) {
            foreach ($item['children'] as $child) {
                if ($itemActive($child)) {
                    return true;
                }
            }
        }

        return false;
    };
@endphp

@if ($navLayout === 'sidebar')
<nav x-data="{ drawerOpen: false }" x-on:nav-close.window="drawerOpen = false">
    <aside class="hidden lg:fixed lg:inset-y-0 lg:start-0 lg:z-50 lg:flex lg:flex-col lg:border-e lg:border-slate-200/80 lg:bg-white/85 lg:backdrop-blur-xl {{ $isCompactSidebar ? 'lg:w-64' : 'lg:w-80' }}">
        <div class="border-b border-slate-200/80 {{ $isCompactSidebar ? 'p-4' : 'p-5' }}">
            <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-3">
                <x-application-logo class="{{ $isCompactSidebar ? 'h-10 w-10' : 'h-11 w-11' }} rounded-2xl object-cover" />
                <div>
                    <p class="text-sm font-black tracking-tight text-slate-800">{{ config('branding.name') }}</p>
                    @if (! $isCompactSidebar)
                        <p class="text-[11px] text-slate-500">{{ config('branding.tagline') }}</p>
                    @endif
                </div>
            </a>
        </div>

        <div class="flex-1 overflow-y-auto px-4 py-5">
            <div class="mb-3 px-2 text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Navigation</div>

            @include('livewire.layout.partials.nav-menu-items', [
                'items' => $visibleItems,
                'variant' => 'desktop',
                'iconSvg' => $iconSvg,
                'itemUrl' => $itemUrl,
                'itemActive' => $itemActive,
                'level' => 0,
                'closeOnClick' => false,
                'compact' => $isCompactSidebar,
            ])
        </div>

        <div class="border-t border-slate-200/80 p-4">
            <div class="mb-3 rounded-2xl border border-slate-200 bg-white p-2">
                <p class="mb-2 px-1 text-[11px] font-bold uppercase tracking-[0.16em] text-slate-500">{{ __('navigation.sidebar_density') }}</p>
                <div class="grid grid-cols-2 gap-2">
                    <a href="{{ route('ui.sidebar-density', 'normal') }}" class="rounded-xl px-2 py-1.5 text-center text-xs font-semibold transition {{ ! $isCompactSidebar ? 'bg-brand-primary text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ __('navigation.density_normal') }}
                    </a>
                    <a href="{{ route('ui.sidebar-density', 'compact') }}" class="rounded-xl px-2 py-1.5 text-center text-xs font-semibold transition {{ $isCompactSidebar ? 'bg-brand-primary text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ __('navigation.density_compact') }}
                    </a>
                </div>
            </div>

            <div class="mb-3 rounded-2xl bg-slate-50 p-2">
                <x-locale-switcher />
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
                <div class="flex items-center gap-3">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-11 w-11 rounded-full border border-slate-200 object-cover">
                    <div class="min-w-0 flex-1" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-on:profile-updated.window="name = $event.detail.name">
                        <p class="truncate text-sm font-semibold text-slate-800" x-text="name"></p>
                        <p class="truncate text-xs text-slate-500">{{ auth()->user()->username ?: auth()->user()->email }}</p>
                    </div>
                </div>

                <div class="mt-3 grid grid-cols-2 gap-2">
                    <a href="{{ route('profile') }}" wire:navigate class="rounded-xl bg-slate-100 px-2 py-2 text-center text-xs font-semibold text-slate-700 transition hover:bg-slate-200">{{ __('navigation.profile') }}</a>
                    <button wire:click="logout" class="rounded-xl bg-red-50 px-2 py-2 text-xs font-semibold text-red-700 transition hover:bg-red-100">{{ __('navigation.log_out') }}</button>
                </div>
            </div>
        </div>
    </aside>

    <div class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/90 backdrop-blur-xl lg:hidden">
        <div class="flex h-16 items-center justify-between px-4">
            <button @click="drawerOpen = true" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-100">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>

            <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-2">
                <x-application-logo class="h-9 w-9 rounded-xl object-cover" />
                <span class="text-sm font-black tracking-tight text-slate-800">{{ config('branding.name') }}</span>
            </a>

            <div class="shrink-0">
                <x-locale-switcher />
            </div>
        </div>
    </div>

    <div x-show="drawerOpen" x-transition.opacity class="fixed inset-0 z-50 lg:hidden" style="display:none;">
        <div class="absolute inset-0 bg-slate-900/60" @click="drawerOpen = false"></div>

        <div class="absolute inset-y-0 start-0 w-full max-w-md overflow-y-auto bg-white p-4 shadow-2xl">
            <div class="mb-4 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-3" @click="drawerOpen = false">
                    <x-application-logo class="h-10 w-10 rounded-xl object-cover" />
                    <span class="text-sm font-black tracking-tight text-slate-800">{{ config('branding.name') }}</span>
                </a>

                <button @click="drawerOpen = false" class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100">
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.22 4.22a.75.75 0 011.06 0L10 8.94l4.72-4.72a.75.75 0 111.06 1.06L11.06 10l4.72 4.72a.75.75 0 11-1.06 1.06L10 11.06l-4.72 4.72a.75.75 0 01-1.06-1.06L8.94 10 4.22 5.28a.75.75 0 010-1.06z" clip-rule="evenodd"/></svg>
                </button>
            </div>

            <div class="mb-4 rounded-2xl bg-slate-50 p-2">
                <x-locale-switcher />
            </div>

            <div class="space-y-1">
                @include('livewire.layout.partials.nav-menu-items', [
                    'items' => $visibleItems,
                    'variant' => 'mobile',
                    'iconSvg' => $iconSvg,
                    'itemUrl' => $itemUrl,
                    'itemActive' => $itemActive,
                    'level' => 0,
                    'closeOnClick' => true,
                    'compact' => false,
                ])
            </div>

            <div class="mt-5 rounded-2xl border border-slate-200 bg-slate-50 p-3">
                <div class="flex items-center gap-3">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" class="h-10 w-10 rounded-full border border-slate-200 object-cover">
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-semibold text-slate-800">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-slate-500">{{ auth()->user()->username ?: auth()->user()->email }}</p>
                    </div>
                </div>

                <a href="{{ route('profile') }}" wire:navigate @click="drawerOpen = false" class="mt-3 block w-full rounded-xl bg-white px-3 py-2 text-center text-sm font-semibold text-slate-700 hover:bg-slate-100">{{ __('navigation.profile') }}</a>
                <button wire:click="logout" class="mt-2 w-full rounded-xl bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-100">{{ __('navigation.log_out') }}</button>
            </div>
        </div>
    </div>

    <div class="fixed inset-x-0 bottom-0 z-40 border-t border-slate-200 bg-white/95 px-4 py-2 backdrop-blur lg:hidden">
        <div class="mx-auto grid max-w-md grid-cols-3 gap-2">
            <a href="{{ route('dashboard') }}" wire:navigate class="rounded-xl px-3 py-2 text-center text-xs font-semibold {{ request()->routeIs('dashboard') ? 'bg-brand-primary text-white' : 'text-slate-700 hover:bg-slate-100' }}">{{ __('navigation.dashboard') }}</a>
            <button @click="drawerOpen = true" class="rounded-xl px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-100">{{ __('navigation.menu') }}</button>
            <a href="{{ route('profile') }}" wire:navigate class="rounded-xl px-3 py-2 text-center text-xs font-semibold {{ request()->routeIs('profile') ? 'bg-brand-primary text-white' : 'text-slate-700 hover:bg-slate-100' }}">{{ __('navigation.profile') }}</a>
        </div>
    </div>
</nav>
@else
<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-3 rounded-xl px-2 py-1 transition hover:bg-slate-100">
                    <x-application-logo class="h-9 w-9 rounded-lg object-cover" />
                    <div class="hidden sm:block">
                        <p class="text-sm font-black tracking-tight text-slate-800">{{ config('branding.name') }}</p>
                        <p class="text-[11px] text-slate-500">{{ config('branding.tagline') }}</p>
                    </div>
                </a>
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                <x-locale-switcher />
                <a href="{{ route('profile') }}" wire:navigate class="rounded-xl px-3 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">{{ __('navigation.profile') }}</a>
                <button wire:click="logout" class="rounded-xl bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">{{ __('navigation.log_out') }}</button>
            </div>

            <button @click="open = ! open" class="inline-flex items-center justify-center rounded-lg p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 sm:hidden">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <div x-show="open" x-transition class="border-t border-slate-200 bg-white sm:hidden" style="display:none;">
        <div class="space-y-2 p-4">
            @include('livewire.layout.partials.nav-menu-items', [
                'items' => $visibleItems,
                'variant' => 'mobile',
                'iconSvg' => $iconSvg,
                'itemUrl' => $itemUrl,
                'itemActive' => $itemActive,
                'level' => 0,
                'closeOnClick' => false,
                'compact' => false,
            ])
            <button wire:click="logout" class="mt-2 w-full rounded-xl bg-red-50 px-3 py-2 text-start text-sm font-semibold text-red-700 hover:bg-red-100">{{ __('navigation.log_out') }}</button>
        </div>
    </div>
</nav>
@endif
