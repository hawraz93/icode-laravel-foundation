@php
    $currentLocale = app()->getLocale();
    $locales = config('branding.locales', ['en']);
    $canSwitch = is_array($locales) && count($locales) > 1;

    $labels = [
        'en' => ['short' => 'EN', 'name' => 'English'],
        'ku' => ['short' => 'KU', 'name' => 'Kurdî'],
        'ar' => ['short' => 'AR', 'name' => 'العربية'],
    ];

    $currentLabel = $labels[$currentLocale]['short'] ?? strtoupper($currentLocale);
@endphp

@if ($canSwitch)
<div x-data="{ open: false }" class="relative">
    <button
        type="button"
        @click="open = !open"
        class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 shadow-sm transition hover:border-slate-400 hover:bg-slate-50"
    >
        <svg class="h-4 w-4 text-slate-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3c4.97 0 9 4.03 9 9s-4.03 9-9 9-9-4.03-9-9 4.03-9 9-9z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12h18M12 3c2.5 2.4 4 5.7 4 9s-1.5 6.6-4 9c-2.5-2.4-4-5.7-4-9s1.5-6.6 4-9z"/>
        </svg>

        <span>{{ $currentLabel }}</span>

        <svg class="h-3 w-3 text-slate-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.937a.75.75 0 111.08 1.04l-4.25 4.51a.75.75 0 01-1.08 0l-4.25-4.51a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
        </svg>
    </button>

    <div
        x-show="open"
        @click.outside="open = false"
        x-transition
        class="absolute z-50 mt-2 min-w-40 rounded-xl border border-slate-200 bg-white p-1 shadow-lg"
        style="display: none;"
    >
        @foreach ($locales as $locale)
            @php
                $short = $labels[$locale]['short'] ?? strtoupper($locale);
                $name = $labels[$locale]['name'] ?? strtoupper($locale);
                $active = $currentLocale === $locale;
            @endphp

            <a
                href="{{ route('locale.switch', $locale) }}"
                class="flex items-center justify-between rounded-lg px-3 py-2 text-xs font-semibold transition {{ $active ? 'bg-brand-primary text-white' : 'text-slate-700 hover:bg-slate-100' }}"
            >
                <span>{{ $short }}</span>
                <span class="ms-2 text-[11px] {{ $active ? 'text-white/85' : 'text-slate-500' }}">{{ $name }}</span>
            </a>
        @endforeach
    </div>
</div>
@endif
