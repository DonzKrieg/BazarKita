@props(['headingId' => null])
<article @if($headingId) aria-labelledby="{{ $headingId }}" @endif {{ $attributes->class(['flex h-full flex-col rounded-2xl border border-stone-200 bg-white p-6']) }}>
    {{ $slot }}
</article>
