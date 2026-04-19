<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ku', 'ar'], true);
    $colors = config('branding.colors');
    $navLayout = config('branding.navigation_layout', 'topbar');
    $sidebarDensity = session('sidebar_density', config('branding.sidebar_density', 'normal'));
    $sidebarPadding = $sidebarDensity === 'compact' ? 'lg:ps-64' : 'lg:ps-80';
@endphp
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('branding.name') }}</title>

        <style>
            :root {
                --brand-primary: {{ $colors['primary'] }};
                --brand-secondary: {{ $colors['secondary'] }};
                --brand-accent: {{ $colors['accent'] }};
                --brand-surface: {{ $colors['surface'] }};
                --brand-surface-dark: {{ $colors['surface_dark'] }};
                --brand-text: {{ $colors['text'] }};
            }
        </style>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
        @if (file_exists(base_path('vendor/wireui/wireui/dist/wireui.css')))
            <wireui:styles />
        @endif
    </head>
    <body class="font-sans antialiased bg-brand-surface text-brand-text">
        <div class="min-h-screen flex flex-col {{ $navLayout === 'sidebar' ? 'pb-20 lg:pb-0 '.$sidebarPadding : '' }}">
            <livewire:layout.navigation />

            @if (isset($header))
                <header class="bg-white shadow-sm">
                    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1">
                {{ $slot }}
            </main>

            <footer class="mx-auto mt-auto w-full max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
                <x-site-support-footer />
            </footer>
        </div>

        <x-dialog />
        <x-notifications />
        @livewireScripts
        @if (file_exists(base_path('vendor/wireui/wireui/dist/wireui.js')))
            <wireui:scripts />
        @endif
    </body>
</html>
