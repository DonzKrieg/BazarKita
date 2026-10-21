@props(['event'])
<x-card :heading-id="'judul-'.$event['id']">
    <div class="mb-5 flex items-center justify-between gap-2">
        <span class="eyebrow text-emerald-800">{{ $event['location']['label'] }}</span>
        <x-example-badge />
    </div>
    <p class="text-sm text-slate-600">{{ $event['date_label'] }}</p>
    <h3 id="judul-{{ $event['id'] }}" class="mt-2 text-xl font-semibold tracking-tight text-forest">{{ $event['name'] }}</h3>
    <p class="mt-3 text-sm text-slate-600">{{ $event['registration_label'] }}</p>
    @if(in_array($event['status'], ['ended', 'cancelled', 'withdrawn'], true))
        <div class="mt-3"><x-badge :tone="$event['status'] === 'cancelled' ? 'danger' : 'warning'">{{ $event['status_label'] }}</x-badge></div>
    @endif
    <div class="mt-6 border-t border-stone-100 pt-5">
        <p class="text-lg font-bold text-forest">{{ $event['offer']['price_label'] }}</p>
        <p class="mt-1 text-sm font-semibold">{{ $event['offer']['commitment_label'] }}</p>
        @if ($event['offer']['package_label'])
            <p class="mt-1 text-sm text-slate-600">{{ $event['offer']['package_label'] }}</p>
        @endif
        <p class="mt-3 text-sm leading-relaxed text-slate-600">{{ $event['offer']['fees_label'] }}</p>
    </div>
    <x-disclosure :id="'sumber-'.$event['id']" label="Lihat sumber informasi" close-label="Tutup sumber informasi" class="mt-auto pt-6">
        <p>{{ $event['source']['label'] }}</p>
        <p class="mt-2">Pemeriksaan: <x-wib-time :value="$event['source']['checked_at']" />.</p>
        <p class="mt-2">Informasi ini dibuat untuk contoh tampilan, bukan pengumuman acara nyata.</p>
    </x-disclosure>
</x-card>
