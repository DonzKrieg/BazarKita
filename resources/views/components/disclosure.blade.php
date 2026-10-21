@props(['id', 'label', 'closeLabel' => null])
<div {{ $attributes }} x-data="{ open: false }">
    <button type="button" class="min-h-11 text-left text-sm font-semibold text-emerald-800 underline underline-offset-4"
            :aria-expanded="open" aria-expanded="false" aria-controls="{{ $id }}" @click="open = !open">
        <span x-show="!open">{{ $label }}</span>
        <span x-show="open" x-cloak>{{ $closeLabel ?? $label }}</span>
    </button>
    <div id="{{ $id }}" x-show="open" x-cloak class="mt-3 rounded-xl bg-stone-50 p-4 text-sm leading-relaxed text-slate-600">
        {{ $slot }}
    </div>
    <noscript><div class="mt-3 text-sm">{{ $slot }}</div></noscript>
</div>
