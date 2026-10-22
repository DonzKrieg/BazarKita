@extends('layouts.app')
@section('title', 'Katalog Bazar — BazarKita')
@section('content')
<section class="page-width py-10" x-data="bazarBrowser(@js($screen['browse_events']), @js($screen['profile']), @js($screen['viewer']['role']))">
    <p class="eyebrow text-emerald-800">Bandung & sekitarnya</p>
    <h1 class="mt-3 text-3xl font-semibold text-forest">Katalog Bazar</h1>
    <p class="mt-4 leading-7 text-slate-600">Semua bazar aktif contoh, termasuk yang tidak tampil di Beranda. Acuan tanggal contoh: 1 November 2026 (WIB).</p>
    <form class="mt-6 grid gap-4 rounded-xl border border-stone-200 bg-white p-5 sm:grid-cols-2 lg:grid-cols-3" @submit.prevent novalidate>
        <x-form-field :hint-after="true" id="search" label="Nama atau tempat" x-model="query" type="search" />
        <x-form-field :hint-after="true" id="category" label="Jenis produk" type="select" x-model="category" :options="['' => 'Semua jenis', 'Makanan' => 'Makanan', 'Minuman' => 'Minuman', 'Kerajinan' => 'Kerajinan']" />
        <x-form-field :hint-after="true" id="budget" label="Batas sewa per hari (Rp)" type="number" min="0" step="1" hint="Kosong: semua harga. Nol: sewa gratis." x-model="budget" />
        <x-form-field :hint-after="true" id="start" label="Mulai tersedia (WIB)" type="date" x-model="start" />
        <x-form-field :hint-after="true" id="end" label="Selesai tersedia (WIB)" type="date" x-model="end" />
        <x-form-field :hint-after="true" id="facility" label="Fasilitas" type="select" x-model="facility" :options="['' => 'Semua fasilitas', 'Listrik' => 'Listrik', 'Meja' => 'Meja', 'Air' => 'Air']" />
        <x-form-field :hint-after="true" id="origin" label="Lokasi asal" hint="Lokasi contoh yang dikenali: Coblong, Bandung; Dago, Bandung; Braga, Bandung." x-model="origin" />
        <x-form-field :hint-after="true" id="radius" label="Jarak maksimal (km)" type="number" min="0" step="any" hint="Jarak garis lurus, bukan perjalanan." x-model="radius" />
        <div class="flex items-start sm:col-span-2 lg:col-span-3"><button type="button" class="button-secondary w-full sm:w-auto" @click="reset">Hapus filter</button></div>
        <p role="alert" class="text-rose-800 sm:col-span-2 lg:col-span-3" x-show="filterError" x-cloak x-text="filterError"></p>
    </form>
    <p class="mt-4 text-sm" x-show="radius !== '' && !originPoint" x-cloak>Lokasi asal belum dikenali dalam contoh. Jarak belum dapat dipastikan.</p>
    <p class="mt-6" role="status" x-text="matching.length + ' bazar sesuai, ' + uncertain.length + ' perlu ditanyakan.'"></p>
    <p class="mt-4" x-show="!matching.length && !uncertain.length" x-cloak>Belum ada bazar yang sesuai. Coba ubah pilihan pencarian.</p>
    <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @foreach($screen['events'] as $event)
            <div x-show="visible(@js($event['id']))">
                <x-event-preview :event="$event" :persona="$screen['persona']" :detail-link="true" :distance="true" />
            </div>
        @endforeach
    </div>
    <section class="mt-10" x-show="uncertain.length" x-cloak aria-label="Perlu ditanyakan">
        <h2 class="text-2xl font-semibold">Perlu ditanyakan</h2>
        <p class="mt-3">Informasi filter belum lengkap. Bazar ini belum dapat dianggap sesuai pilihan Anda.</p>
        <div class="mt-6 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($screen['events'] as $event)
                <div x-show="visible(@js($event['id']), 'unknown')"><x-event-preview id-prefix="uncertain-" :event="$event" :persona="$screen['persona']" :detail-link="true" :distance="true" /></div>
            @endforeach
        </div>
    </section>
    <noscript><p class="mt-5">Aktifkan JavaScript untuk menggunakan filter. Daftar contoh tetap dapat dibuka.</p></noscript>
</section>
@endsection
