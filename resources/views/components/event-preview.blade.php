@props(['event', 'persona' => [], 'detailLink' => false, 'idPrefix' => '', 'distance' => false, 'reasons' => false])
<x-card class="event-card" :heading-id="'judul-'.$idPrefix.$event['id']">
    <div class="event-cover cover-{{ crc32($event['id']) % 4 }}">
        <span class="cover-label">{{ $event['categories'][0] ?? 'Bazar Bandung' }}</span>
        <x-example-badge />
        <span class="cover-location">{{ $event['location']['label'] }}</span>
    </div>
    <p class="text-sm text-slate-600">{{ $event['date_label'] }}</p>
    <h3 id="judul-{{ $idPrefix.$event['id'] }}" class="mt-2 text-xl font-semibold tracking-tight text-forest">{{ $event['name'] }}</h3>
    <p class="mt-3 text-sm text-slate-600">{{ $event['registration_label'] }}</p>
    @if($distance)
        <p class="mt-2 text-sm leading-6 text-slate-600" x-show="km(@js($event)) !== null" x-cloak x-text="km(@js($event))?.toFixed(1) + ' km · jarak garis lurus'"></p>
    @endif
    @if($reasons)
        <ul x-show="!fallback" x-cloak class="mt-4 space-y-1 rounded-lg bg-emerald-50 p-3 text-sm leading-6 text-emerald-900" aria-label="Alasan pilihan">
            <li>Jenis produk diterima</li><li>Sewa sesuai batas harian Anda</li>
        </ul>
    @endif
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
    @if($detailLink)
        <a href="{{ route('event.detail', array_merge($persona, ['event' => $event['id']])) }}" class="button-primary mt-5">Lihat Bazar</a>
    @endif
    <x-disclosure :id="'sumber-'.$idPrefix.$event['id']" label="Lihat sumber informasi" close-label="Tutup sumber informasi" class="mt-auto pt-6">
        <p>{{ $event['source']['label'] }}</p>
        <p class="mt-2">Pemeriksaan: <x-wib-time :value="$event['source']['checked_at']" />.</p>
        <p class="mt-2">Informasi ini dibuat untuk contoh tampilan, bukan pengumuman acara nyata.</p>
    </x-disclosure>
</x-card>
