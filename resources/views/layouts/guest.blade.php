<!DOCTYPE html>
@php
    $locale = app()->getLocale();
    $isRtl = in_array($locale, ['ku', 'ar'], true);
    $colors = config('branding.colors');
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
    <body class="min-h-screen bg-brand-surface text-brand-text antialiased">
        <div class="relative min-h-screen overflow-hidden flex flex-col">
            <div class="absolute inset-0 pointer-events-none bg-auth-gradient"></div>

            <div class="relative mx-auto grid w-full max-w-7xl flex-1 grid-cols-1 gap-6 px-4 py-6 lg:grid-cols-2 lg:gap-10 lg:px-8">
                <aside class="hidden lg:flex lg:flex-col lg:justify-between">
                    <div>
                        <div class="inline-flex items-center gap-4 rounded-2xl border border-white/40 bg-white/70 p-4 backdrop-blur">
                            <x-application-logo class="h-14 w-14 rounded-xl object-cover shadow-sm" />
                            <div>
                                <p class="text-lg font-black tracking-tight text-slate-900">{{ config('branding.name') }}</p>
                                <p class="text-sm text-slate-600">{{ __('auth_ui.auth_base') }}</p>
                            </div>
                        </div>

                        <h1 class="mt-10 max-w-lg text-3xl font-black leading-tight text-slate-900">
                            {{ __('auth_ui.hero_title') }}
                        </h1>
                        <p class="mt-4 max-w-xl text-sm leading-7 text-slate-700">
                            {{ __('auth_ui.hero_subtitle') }}
                        </p>
                    </div>
                </aside>

                <main class="flex items-center justify-center">
                    <div class="w-full max-w-xl rounded-3xl border border-white/50 bg-white/90 p-6 shadow-xl backdrop-blur sm:p-8">
                        <div class="mb-6 flex items-start justify-between gap-3">
                            <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                                <x-application-logo class="h-10 w-10 rounded-lg object-cover" />
                                <span class="text-sm font-bold text-slate-700">{{ config('branding.name') }}</span>
                            </a>
                            <x-locale-switcher />
                        </div>

                        {{ $slot }}
                    </div>
                </main>
            </div>

            <footer class="relative mx-auto mt-auto w-full max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
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
