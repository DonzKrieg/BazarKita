@props(['tone' => 'neutral'])
<span {{ $attributes->class([
    'inline-flex items-center rounded-md px-2 py-1 text-xs font-semibold',
    'bg-slate-100 text-slate-700' => $tone === 'neutral',
    'bg-emerald-100 text-emerald-950' => $tone === 'success',
    'bg-amber-100 text-amber-950' => $tone === 'warning',
    'bg-rose-100 text-rose-950' => $tone === 'danger',
]) }}>{{ $slot }}</span>
