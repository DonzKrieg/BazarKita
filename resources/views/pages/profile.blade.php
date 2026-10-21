@extends('layouts.app')
@section('title', 'Usaha Saya — BazarKita')
@section('content')
<section class="page-width py-10">
    <p class="eyebrow text-emerald-800">Kenali kebutuhan usaha</p>
    <h1 class="mt-3 text-3xl font-semibold text-forest">Usaha Saya</h1>
    <p class="mt-4 max-w-2xl leading-7 text-slate-600">Ringkasan ini menggunakan data contoh. Form untuk mengubah profil akan tersedia pada tahap berikutnya.</p>
    <div class="mt-8 max-w-2xl">
        <x-card heading-id="nama-usaha">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 id="nama-usaha" class="text-xl font-semibold">{{ $screen['profile']['name'] }}</h2>
                <x-example-badge />
            </div>
            <dl class="mt-6 grid gap-5 sm:grid-cols-2">
                <div><dt class="text-sm text-slate-600">Jenis produk</dt><dd class="mt-1 font-semibold">{{ $screen['profile']['product_category'] }}</dd></div>
                <div><dt class="text-sm text-slate-600">Lokasi usaha</dt><dd class="mt-1 font-semibold">{{ $screen['profile']['location']['label'] }}</dd></div>
                <div><dt class="text-sm text-slate-600">Jarak maksimal</dt><dd class="mt-1 font-semibold">{{ $screen['profile']['radius_km'] }} km<span class="mt-1 block text-xs font-normal text-slate-600">Jarak garis lurus.</span></dd></div>
                <div><dt class="text-sm text-slate-600">Batas sewa per hari</dt><dd class="mt-1 font-semibold"><x-money :value="$screen['profile']['daily_rent_budget']" />/hari</dd></div>
                <div><dt class="text-sm text-slate-600">Tanggal tersedia</dt><dd class="mt-1 font-semibold">7–9 November 2026 (WIB)</dd></div>
            </dl>
        </x-card>
    </div>
</section>
@endsection
