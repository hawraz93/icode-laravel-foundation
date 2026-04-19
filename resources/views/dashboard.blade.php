<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-black tracking-tight text-slate-800">{{ __('navigation.dashboard') }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ __('navigation.mobile_ipad_ready') }}</p>
            </div>
            <span class="inline-flex items-center rounded-full bg-brand-primary/10 px-3 py-1 text-xs font-semibold text-brand-primary">
                SmartExam Base
            </span>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto grid max-w-7xl gap-4 px-4 sm:px-6 lg:grid-cols-3 lg:px-8">
            <a href="{{ route('demo.calendar') }}" wire:navigate class="card-surface block p-5 transition hover:-translate-y-0.5 hover:shadow-card">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Menu</p>
                <p class="mt-2 text-lg font-black text-slate-800">{{ __('navigation.exam_calendar') }}</p>
                <p class="mt-1 text-sm text-slate-600">Sample menu page</p>
            </a>

            <a href="{{ route('demo.planning.midterm') }}" wire:navigate class="card-surface block p-5 transition hover:-translate-y-0.5 hover:shadow-card">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Submenu</p>
                <p class="mt-2 text-lg font-black text-slate-800">{{ __('navigation.midterm_plan') }}</p>
                <p class="mt-1 text-sm text-slate-600">Nested submenu route</p>
            </a>

            <a href="{{ route('demo.reports.summary') }}" wire:navigate class="card-surface block p-5 transition hover:-translate-y-0.5 hover:shadow-card">
                <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Submenu</p>
                <p class="mt-2 text-lg font-black text-slate-800">{{ __('navigation.summary_reports') }}</p>
                <p class="mt-1 text-sm text-slate-600">Reports sample route</p>
            </a>
        </div>
    </div>
</x-app-layout>
