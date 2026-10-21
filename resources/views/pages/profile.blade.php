@extends('layouts.app')
@section('title', 'Usaha Saya — BazarKita')
@section('content')
<section class="page-width py-10" x-data="profilePreview(@js($screen['profile']), @js($screen['viewer']['role']))">
    <x-example-badge />
    <h1 class="mt-3 text-3xl font-semibold text-forest">Usaha Saya</h1>
    <p class="mt-4 max-w-2xl leading-7 text-slate-600">Isi kebutuhan usaha untuk mencoba profil contoh. Perubahan hanya disimpan sementara di tab browser ini, bukan di server. Gunakan data rekaan.</p>
    <div class="mt-6 flex flex-wrap gap-3" x-cloak>
        <button type="button" class="button-secondary" @click="incomplete">Coba profil belum lengkap</button>
        <button type="button" class="button-secondary" @click="reset">Kembalikan contoh awal</button>
    </div>
    <form class="mt-8 max-w-2xl space-y-6 rounded-2xl border border-stone-200 bg-white p-6" @submit.prevent="save" novalidate autocomplete="off">
        <fieldset disabled x-bind:disabled="false" class="space-y-6">
            <legend class="mb-5 text-xl font-semibold">Lima informasi utama</legend>
            <x-form-field id="profile-category" label="Jenis produk" type="select" required hint="Contoh: Makanan." x-model="form.category" x-bind:aria-invalid="!!errors.category" :options="['' => 'Pilih jenis produk', 'Makanan' => 'Makanan', 'Minuman' => 'Minuman', 'Kerajinan' => 'Kerajinan', 'Lainnya' => 'Lainnya']">
                <x-slot:error><span x-text="errors.category"></span></x-slot:error>
            </x-form-field>
            <fieldset class="space-y-4"><legend class="mb-3 font-semibold">Lokasi asal (wajib)</legend>
            <x-form-field id="profile-location" label="Daerah asal" type="text" required hint="Contoh: Coblong, Bandung. Koordinat digunakan untuk jarak garis lurus." x-model="form.location" x-bind:aria-invalid="!!errors.location" >
                <x-slot:error><span x-text="errors.location"></span></x-slot:error>
            </x-form-field>
            <x-form-field id="profile-latitude" label="Lintang" type="number" required hint="Contoh: -6.8868. Rentang -90 sampai 90." x-model="form.latitude" x-bind:aria-invalid="!!errors.latitude" step="any" min="-90" max="90">
                <x-slot:error><span x-text="errors.latitude"></span></x-slot:error>
            </x-form-field>
            <x-form-field id="profile-longitude" label="Bujur" type="number" required hint="Contoh: 107.6133. Rentang -180 sampai 180." x-model="form.longitude" x-bind:aria-invalid="!!errors.longitude" step="any" min="-180" max="180">
                <x-slot:error><span x-text="errors.longitude"></span></x-slot:error>
            </x-form-field>
            </fieldset>
            <x-form-field id="profile-radius" label="Jarak maksimal (km)" type="number" required hint="Contoh: 10 km. Jarak garis lurus, bukan jarak perjalanan." x-model="form.radius" x-bind:aria-invalid="!!errors.radius" step="any" min="0">
                <x-slot:error><span x-text="errors.radius"></span></x-slot:error>
            </x-form-field>
            <x-form-field id="profile-rent" label="Batas sewa per hari (Rp)" type="number" required hint="Contoh: 150000. Isi 0 hanya untuk sewa gratis yang sudah dipastikan; kosong bukan nol." x-model="form.rent" x-bind:aria-invalid="!!errors.rent" step="1" min="0">
                <x-slot:error><span x-text="errors.rent"></span></x-slot:error>
            </x-form-field>
            <fieldset class="space-y-4"><legend class="mb-3 font-semibold">Tanggal tersedia (wajib, WIB)</legend>
            <x-form-field id="profile-start" label="Tanggal mulai" type="date" required hint="" x-model="form.start" x-bind:aria-invalid="!!errors.start" >
                <x-slot:error><span x-text="errors.start"></span></x-slot:error>
            </x-form-field>
            <x-form-field id="profile-end" label="Tanggal selesai" type="date" required hint="" x-model="form.end" x-bind:aria-invalid="!!errors.end" >
                <x-slot:error><span x-text="errors.end"></span></x-slot:error>
            </x-form-field>
            </fieldset>
            <div class="border-t border-stone-200 pt-5">
                <button type="button" class="button-secondary" @click="extra = !extra" x-bind:aria-expanded="extra" aria-controls="profile-extra">Tambahkan Informasi Usaha</button>
                <div id="profile-extra" class="mt-5 space-y-5" x-show="extra" x-cloak>
                    <p class="text-sm text-slate-600">Opsional. Kosongkan bila belum diketahui.</p>
            <x-form-field id="profile-name" label="Nama usaha" type="text"  hint="Contoh: Dapur Rani." x-model="form.name" x-bind:aria-invalid="!!errors.name" maxlength="120">
                <x-slot:error><span x-text="errors.name"></span></x-slot:error>
            </x-form-field>
            <x-form-field id="profile-min" label="Harga produk terendah (Rp)" type="number"  hint="" x-model="form.min" x-bind:aria-invalid="!!errors.min" step="1" min="0">
                <x-slot:error><span x-text="errors.min"></span></x-slot:error>
            </x-form-field>
            <x-form-field id="profile-max" label="Harga produk tertinggi (Rp)" type="number"  hint="" x-model="form.max" x-bind:aria-invalid="!!errors.max" step="1" min="0">
                <x-slot:error><span x-text="errors.max"></span></x-slot:error>
            </x-form-field>
                    <fieldset class="space-y-3">
                        <legend class="mb-3 font-semibold">Fasilitas yang diperlukan</legend>
                        @foreach(['Listrik', 'Air', 'Meja', 'Tenda'] as $facility)
                            <label class="flex items-center gap-3 py-2"><input type="checkbox" value="{{ $facility }}" x-model="form.facilities" class="size-5">{{ $facility }}</label>
                        @endforeach
                    </fieldset>
                </div>
            </div>
            <button type="submit" class="button-primary">Terapkan perubahan contoh</button>
        </fieldset>
        <p role="status" x-ref="result" tabindex="-1" x-text="message" class="leading-7"></p>
        <noscript><p>Aktifkan JavaScript untuk mencoba perubahan dan validasi profil.</p></noscript>
    </form>
    <a href="{{ route('home', $screen['persona']) }}" class="button-secondary mt-6">Lihat Beranda</a>
</section>
@endsection
