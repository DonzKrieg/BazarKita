@props(['event'])
<article class="flex h-full flex-col rounded-2xl border border-stone-200 bg-white p-6" aria-labelledby="judul-{{ $event['id'] }}">
    <div class="mb-5 flex items-center justify-between gap-2">
        <span class="eyebrow text-emerald-800">{{ $event['location']['label'] }}</span>
        <x-example-badge />
    </div>
    <p class="text-sm text-slate-600">{{ $event['date_label'] }}</p>
    <h3 id="judul-{{ $event['id'] }}" class="mt-2 text-xl font-semibold tracking-tight text-forest">{{ $event['name'] }}</h3>
    <p class="mt-3 text-sm text-slate-600">{{ $event['registration_label'] }}</p>
    <div class="mt-6 border-t border-stone-100 pt-5">
        <p class="text-lg font-bold text-forest">{{ $event['offer']['price_label'] }}</p>
        <p class="mt-1 text-sm font-semibold">{{ $event['offer']['commitment_label'] }}</p>
        @if ($event['offer']['package_label'])
            <p class="mt-1 text-sm text-slate-600">{{ $event['offer']['package_label'] }}</p>
        @endif
        <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $event['offer']['fees_label'] }}</p>
    </div>
    <div class="mt-auto pt-6" x-data="{ open: false }">
        <button type="button" class="min-h-11 text-sm font-semibold text-emerald-800 underline underline-offset-4"
                :aria-expanded="open" aria-expanded="false" aria-controls="sumber-{{ $event['id'] }}"
                @click="open = !open">
            <span x-text="open ? 'Tutup sumber informasi' : 'Lihat sumber informasi'">Lihat sumber informasi</span>
        </button>
        <div id="sumber-{{ $event['id'] }}" x-show="open" x-cloak class="mt-3 rounded-xl bg-stone-50 p-4 text-sm leading-relaxed text-slate-600">
            <p>{{ $event['source']['label'] }}</p>
            <p class="mt-2">Pemeriksaan: {{ $event['source']['checked_label'] }}.</p>
            <p class="mt-2">Informasi ini dibuat untuk contoh tampilan, bukan pengumuman acara nyata.</p>
        </div>
        <noscript><p class="mt-2 text-sm">{{ $event['source']['label'] }}. Pemeriksaan: {{ $event['source']['checked_label'] }}.</p></noscript>
    </div>
</article>
