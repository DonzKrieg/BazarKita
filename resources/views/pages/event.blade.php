@extends('layouts.app')
@section('title', $event['name'].' — BazarKita')
@section('content')
<section class="page-width py-10">
    <a href="{{ route('catalog', $screen['persona']) }}" class="text-emerald-800 underline">Kembali ke Katalog Bazar</a>
    <div class="mt-6 max-w-3xl rounded-2xl border border-stone-200 bg-white p-6 sm:p-8">
        <x-example-badge />
        <h1 class="mt-4 text-3xl font-semibold text-forest">{{ $event['name'] }}</h1>
        <p class="mt-4">{{ $event['date_label'] }} (WIB) · {{ $event['location']['label'] }}</p>
        <p class="mt-4 font-semibold">{{ $event['registration_label'] }}</p>
        <div class="mt-6 border-y border-stone-200 py-5">
            <h2 class="text-xl font-bold">{{ $event['offer']['price_label'] }}</h2>
            <p class="mt-2 font-semibold">{{ $event['offer']['commitment_label'] }}</p>
            @if($event['offer']['package_label'])<p class="mt-2">{{ $event['offer']['package_label'] }}</p>@endif
            @if($event['offer']['basis'] === 'package')<p class="mt-2">Harga setara per hari bukan tawaran sewa satu hari.</p>@endif
            <p class="mt-3">{{ $event['offer']['fees_label'] }}</p>
            <p class="mt-2 text-sm text-slate-600">Batas sewa hanya untuk sewa stan, bukan total biaya berjualan.</p>
        </div>
        @if($stale)<p class="mt-5 rounded-lg bg-amber-50 p-4">Silakan pastikan kembali kepada penyelenggara.</p>@endif
        @if($event['contact'])
            <div class="mt-5"><x-dialog id="contact-example" title="Kontak penyelenggara contoh" trigger="Hubungi Penyelenggara" confirm-label="Tutup contoh kontak">{{ $event['contact'] }} adalah alamat rekaan untuk demonstrasi. Tidak ada pesan yang dikirim.</x-dialog></div>
        @else
            <p class="mt-5">Kontak penyelenggara: Belum ada informasi.</p>
        @endif
        <x-disclosure id="event-information" label="Informasi Lainnya" close-label="Tutup informasi lainnya" class="mt-8">
            <dl class="space-y-4">
                <div><dt class="font-semibold">Jenis produk</dt><dd>{{ implode(', ', $event['categories'] ?? []) ?: 'Belum ada informasi' }}</dd></div>
                <div><dt class="font-semibold">Fasilitas</dt><dd>{{ $event['facilities'] === null ? 'Belum ada informasi' : (implode(', ', $event['facilities']) ?: 'Tidak ada fasilitas menurut sumber contoh') }}</dd></div>
                <div><dt class="font-semibold">Penyelenggara</dt><dd>{{ $event['organizer'] }}</dd></div>
                <div><dt class="font-semibold">Batas pendaftaran</dt><dd>{{ $event['deadline'] ?? 'Belum ada informasi' }}</dd></div>
                <div><dt class="font-semibold">Sumber informasi</dt><dd>{{ $event['source']['label'] }}. Tautan sumber: Belum ada informasi.</dd></div>
                <div><dt class="font-semibold">Terakhir diperiksa</dt><dd><x-wib-time :value="$event['source']['checked_at']" /></dd></div>
            </dl>
            @if(isset($event['offer']['daily_rates']))
                <p class="mt-4 font-semibold">Tarif tiap hari</p>
                @foreach($event['offer']['daily_rates'] as $rate)<p>{{ $rate['date'] }}: <x-money :value="$rate['amount']" />/hari</p>@endforeach
            @endif
            <p class="mt-4">Pilihan di Beranda memakai jenis produk, tanggal tersedia, jarak garis lurus, batas sewa, fasilitas, dan pendaftaran terbuka pada data contoh. Informasi yang belum pasti tidak dianggap cocok.</p>
        </x-disclosure>
        @if($screen['viewer']['role'] !== 'guest')
            <div class="mt-6" x-data="bazarBrowser(@js([$event]), @js($screen['profile']), @js($screen['viewer']['role']), true)" x-cloak>
                <div x-show="!fallback && match(events[0], true) === 'yes'">
                    <x-disclosure id="choice-reasons" label="Alasan pilihan" close-label="Tutup alasan pilihan">
                        <p x-text="'Jenis produk ' + profile.category + ' diterima.'"></p>
                        <p x-text="'Jarak garis lurus ' + km(events[0])?.toFixed(1) + ' km, dalam batas ' + profile.radius + ' km.'"></p>
                        <p>Sewa stan sesuai batas harian, tanggal partisipasi tersedia, fasilitas wajib terpenuhi, dan pendaftaran terbuka menurut data contoh.</p>
                        <p class="mt-2">Alasan ini hanya membahas kecocokan kebutuhan, bukan jaminan ramai atau keuntungan.</p>
                    </x-disclosure>
                </div>
            </div>
        @endif
        <div class="mt-8 border-t border-stone-200 pt-6" x-data="correctionPreview">
            <h2 class="text-xl font-semibold">Laporkan Informasi</h2>
            <p class="mt-3">Contoh laporan koreksi untuk diperiksa admin. Laporan tidak langsung mengubah informasi bazar.</p>
            <form class="mt-4 space-y-4" @submit.prevent="submit">
                <fieldset disabled x-bind:disabled="false" class="space-y-4">
                    <x-form-field id="correction-reason" label="Alasan laporan" type="textarea" x-model="reason" x-ref="reason" maxlength="1000" hint="Contoh: tanggal pada poster berbeda. Gunakan data rekaan." />
                    <button type="submit" class="button-primary">Kirim laporan contoh</button>
                </fieldset>
                <p role="status" x-text="message"></p>
            </form>
            <noscript>Aktifkan JavaScript untuk mencoba laporan.</noscript>
        </div>
    </div>
</section>
@endsection
