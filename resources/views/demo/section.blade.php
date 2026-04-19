<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-black tracking-tight text-slate-800">{{ $title }}</h2>
                <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
            </div>
            <span class="inline-flex items-center rounded-full bg-brand-primary/10 px-3 py-1 text-xs font-semibold text-brand-primary">
                {{ $badge ?? __('navigation.demo_page') }}
            </span>
        </div>
    </x-slot>

    <div class="py-6 sm:py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="card-surface">
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Route</p>
                        <p class="mt-2 text-sm font-bold text-slate-800">{{ request()->route()->getName() }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">URL</p>
                        <p class="mt-2 break-all text-sm font-bold text-slate-800">{{ url()->current() }}</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 sm:col-span-2 xl:col-span-1">
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Device Ready</p>
                        <p class="mt-2 text-sm text-slate-700">{{ __('navigation.mobile_ipad_ready') }}</p>
                    </div>
                </div>

                <div class="mt-5 rounded-2xl border border-dashed border-slate-300 bg-white p-5">
                    <p class="text-sm leading-7 text-slate-700">{{ $content }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
