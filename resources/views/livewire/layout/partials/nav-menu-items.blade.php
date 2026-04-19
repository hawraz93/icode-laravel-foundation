@php
    $level = $level ?? 0;
    $closeOnClick = $closeOnClick ?? false;
    $compact = $compact ?? false;
@endphp

@foreach ($items as $item)
    @php
        $hasChildren = ! empty($item['children'] ?? []);
        $active = $itemActive($item);
        $url = $itemUrl($item);

        $isSubmenu = $level > 0;

        $buttonBase = $variant === 'mobile'
            ? ($isSubmenu
                ? 'group relative flex w-full items-center gap-2.5 rounded-xl px-2.5 py-2 text-[13px] font-medium transition'
                : 'group relative flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-sm font-semibold transition')
            : ($isSubmenu
                ? 'group relative flex w-full items-center gap-2.5 rounded-xl px-2.5 py-1.5 text-[13px] font-medium transition'
                : ($compact
                    ? 'group relative flex w-full items-center gap-2.5 rounded-xl px-2.5 py-2 text-[13px] font-semibold transition'
                    : 'group relative flex w-full items-center gap-3 rounded-2xl px-3 py-2.5 text-sm font-semibold transition'));

        $stateClasses = $active
            ? 'bg-brand-primary/10 text-brand-primary'
            : 'text-slate-700 hover:bg-slate-100';

        $iconClasses = $active
            ? 'bg-brand-primary text-white shadow-brand'
            : 'bg-slate-100 text-slate-500 group-hover:bg-slate-200';

        $childWrap = $variant === 'mobile'
            ? 'mt-1 space-y-0.5 border-s-2 border-slate-200 ps-2.5'
            : 'mt-1 space-y-0.5 border-s-2 border-slate-200/80 ps-2.5';

        $activeBarClass = $active ? 'bg-brand-primary/80' : 'bg-transparent group-hover:bg-slate-300';
        $iconSizeClass = $isSubmenu ? 'h-7 w-7 rounded-lg' : 'h-9 w-9 rounded-xl';
        $labelClass = $isSubmenu ? 'text-[12.5px] tracking-tight' : 'text-sm';
        $rowAccentClass = $isSubmenu ? 'inset-y-1.5' : 'inset-y-2';
    @endphp

    <div class="space-y-1" x-data="{ open: {{ $hasChildren && $active ? 'true' : 'false' }} }">
        @if ($hasChildren)
            <button type="button" @click="open = !open" class="{{ $buttonBase }} {{ $stateClasses }}">
                <span class="absolute {{ $rowAccentClass }} start-0 w-1 rounded-full transition {{ $activeBarClass }}"></span>

                <span class="inline-flex {{ $iconSizeClass }} shrink-0 items-center justify-center {{ $iconClasses }}">
                    {!! $iconSvg($item['icon'] ?? 'dot') !!}
                </span>

                <span class="flex-1 text-start {{ $labelClass }}">{{ __($item['label']) }}</span>

                <svg class="h-4 w-4 shrink-0 transition" :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.937a.75.75 0 111.08 1.04l-4.25 4.51a.75.75 0 01-1.08 0l-4.25-4.51a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                </svg>
            </button>

            <div
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-1"
                class="{{ $childWrap }}"
                style="display: none;"
            >
                @include('livewire.layout.partials.nav-menu-items', [
                    'items' => $item['children'],
                    'variant' => $variant,
                    'iconSvg' => $iconSvg,
                    'itemUrl' => $itemUrl,
                    'itemActive' => $itemActive,
                    'level' => $level + 1,
                    'closeOnClick' => $closeOnClick,
                    'compact' => $compact,
                ])
            </div>
        @else
            <a href="{{ $url }}" wire:navigate class="{{ $buttonBase }} {{ $stateClasses }}" @if($closeOnClick) @click="$dispatch('nav-close')" @endif>
                <span class="absolute {{ $rowAccentClass }} start-0 w-1 rounded-full transition {{ $activeBarClass }}"></span>

                <span class="inline-flex {{ $iconSizeClass }} shrink-0 items-center justify-center {{ $iconClasses }}">
                    {!! $iconSvg($item['icon'] ?? 'dot') !!}
                </span>

                <span class="flex-1 {{ $labelClass }}">{{ __($item['label']) }}</span>
            </a>
        @endif
    </div>
@endforeach
