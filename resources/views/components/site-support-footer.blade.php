@php
    $support = config('branding.support');
@endphp

<footer class="mt-8 rounded-2xl border border-slate-200/70 bg-white/85 px-4 py-4 text-xs text-slate-600 shadow-sm backdrop-blur">
    <p class="font-semibold text-slate-800">
        {{ __('auth_ui.powered_by') }} {{ $support['company'] }}
    </p>
    <p class="mt-1 text-slate-700">
        {{ __('auth_ui.icode_pitch') }}
    </p>
    <p class="mt-1">
        {{ __('auth_ui.support_text') }}
        <a href="{{ $support['website'] }}" target="_blank" rel="noopener" class="font-semibold text-brand-primary hover:underline">
            {{ parse_url($support['website'], PHP_URL_HOST) }}
        </a>
    </p>

    <div class="mt-3 flex flex-wrap items-center gap-2">
        <a href="{{ $support['website'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 rounded-full border border-slate-300 px-3 py-1 hover:bg-slate-100">
            <span>{{ __('auth_ui.website') }}</span>
        </a>
        <a href="{{ $support['facebook'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 rounded-full border border-slate-300 px-3 py-1 hover:bg-slate-100">
            <span>{{ __('auth_ui.facebook') }}</span>
        </a>
        <a href="{{ $support['whatsapp'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 rounded-full border border-slate-300 px-3 py-1 hover:bg-slate-100">
            <span>{{ __('auth_ui.whatsapp') }}</span>
        </a>
        <a href="{{ $support['telegram'] }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 rounded-full border border-slate-300 px-3 py-1 hover:bg-slate-100">
            <span>{{ __('auth_ui.telegram') }}</span>
        </a>
    </div>
</footer>
