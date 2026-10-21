@extends('layouts.app')
@section('title', 'Panduan tampilan — BazarKita')
@section('content')
<section class="page-width py-10">
    <p class="eyebrow text-emerald-800">Contoh tampilan bersama</p>
    <h1 class="mt-3 text-3xl font-semibold text-forest">Panduan tampilan</h1>
    <p class="mt-4 max-w-2xl leading-7 text-slate-600">Coba isian, keterangan, dan konfirmasi yang digunakan bersama di BazarKita. Perubahan di halaman ini hanya untuk contoh dan tidak disimpan.</p>
    <div class="mt-8 grid items-start gap-6 lg:grid-cols-2">
        <x-card heading-id="contoh-isian">
            <h2 id="contoh-isian" class="text-xl font-semibold text-forest">Isian yang jelas</h2>
            <form class="mt-6 space-y-5" x-data="exampleForm" @submit.prevent="submit" novalidate>
                <x-form-field id="example-name" label="Nama usaha" hint="Contoh: Dapur Rani." x-model="name" x-bind:aria-invalid="error ? 'true' : 'false'" required>
                    <x-slot:error><span x-text="error"></span></x-slot:error>
                </x-form-field>
                <x-form-field id="example-category" type="select" label="Jenis produk" :options="['food' => 'Makanan', 'drink' => 'Minuman']" />
                <x-form-field id="example-note" type="textarea" label="Catatan tambahan" hint="Bagikan informasi singkat tentang usaha contoh Anda." />
                <button type="submit" class="button-primary">Periksa contoh isian</button>
                <p role="status" class="text-sm text-emerald-800" x-text="message"></p>
            </form>
        </x-card>
        <x-card heading-id="contoh-keterangan">
            <h2 id="contoh-keterangan" class="text-xl font-semibold text-forest">Keterangan yang mudah dibaca</h2>
            <div class="mt-5 flex flex-wrap gap-3">
                <x-example-badge />
                <x-badge tone="success">Pendaftaran dibuka</x-badge>
                <x-badge tone="warning">Perlu ditanyakan</x-badge>
                <x-badge tone="danger">Dibatalkan</x-badge>
            </div>
            <dl class="mt-6 space-y-4 text-sm">
                <div><dt class="text-slate-600">Contoh harga harian</dt><dd class="mt-1 font-semibold"><x-money :value="150000" />/hari</dd></div>
                <div><dt class="text-slate-600">Contoh waktu pemeriksaan</dt><dd class="mt-1 font-semibold"><x-wib-time value="2026-11-01T02:00:00Z" /></dd></div>
                <div><dt class="text-slate-600">Harga belum diketahui</dt><dd class="mt-1 font-semibold"><x-money :value="null" /></dd></div>
            </dl>
            <x-disclosure id="contoh-rincian" label="Buka informasi lainnya" close-label="Tutup informasi lainnya" class="mt-5">
                Keterangan tambahan dapat dibuka sesuai kebutuhan. Biaya wajib dan kewajiban paket tetap ditampilkan di bagian utama kartu.
            </x-disclosure>
            <div class="mt-6 border-t border-stone-200 pt-6" x-data="{ confirmed: false }" @example-confirmed="confirmed = true">
                <x-dialog id="konfirmasi-contoh" title="Lanjutkan contoh ini?" trigger="Coba dialog konfirmasi">
                    Ini hanya contoh konfirmasi. Tidak ada perubahan pada data usaha atau bazar.
                </x-dialog>
                <p role="status" class="mt-3 text-sm text-emerald-800" x-text="confirmed ? 'Contoh konfirmasi selesai. Tidak ada data yang disimpan.' : ''"></p>
            </div>
        </x-card>
    </div>
    <section class="mt-10" aria-labelledby="keadaan-layar">
        <h2 id="keadaan-layar" class="text-2xl font-semibold text-forest">Keadaan halaman</h2>
        <div class="mt-5 grid gap-5 md:grid-cols-2">
            @foreach(['loading' => ['title' => 'Sedang memuat bazar', 'description' => 'Mohon tunggu sebentar.'], 'empty' => ['title' => 'Belum ada bazar yang sesuai', 'description' => 'Coba ubah pilihan pencarian.'], 'error' => ['title' => 'Informasi belum berhasil dimuat', 'description' => 'Silakan coba lagi.'], 'success' => ['title' => 'Contoh berhasil ditampilkan', 'description' => 'Informasi contoh sudah dapat dibaca.']] as $state => $message)
                <x-screen-state :state="$state" :message="$message" :action-url="route('catalog', $screen['persona'])" action-label="Lihat contoh bazar" />
            @endforeach
        </div>
    </section>
    <section class="mt-10 rounded-2xl border border-stone-200 bg-white p-6" aria-labelledby="istilah">
        <h2 id="istilah" class="text-2xl font-semibold text-forest">Istilah yang digunakan</h2>
        <dl class="mt-5 grid gap-6 md:grid-cols-2">
            <div><dt class="font-semibold">Sewa per hari</dt><dd class="mt-1 text-sm leading-6 text-slate-600">Biaya menyewa stan selama satu hari.</dd></div>
            <div><dt class="font-semibold">Setara per hari</dt><dd class="mt-1 text-sm leading-6 text-slate-600">Harga paket dibagi jumlah hari sewa yang diketahui. Tetap perhatikan hari yang wajib disewa.</dd></div>
            <div><dt class="font-semibold">Biaya wajib</dt><dd class="mt-1 text-sm leading-6 text-slate-600">Biaya tambahan yang harus dibayar di luar sewa stan.</dd></div>
            <div><dt class="font-semibold">Perlu ditanyakan</dt><dd class="mt-1 text-sm leading-6 text-slate-600">Keterangan belum cukup jelas. Pastikan kembali kepada penyelenggara.</dd></div>
            <div><dt class="font-semibold">Sumber Informasi</dt><dd class="mt-1 text-sm leading-6 text-slate-600">Asal keterangan tentang bazar, misalnya pengumuman penyelenggara.</dd></div>
            <div><dt class="font-semibold">Belum ada informasi</dt><dd class="mt-1 text-sm leading-6 text-slate-600">Nilai belum diketahui. Tidak berarti gratis atau tidak tersedia.</dd></div>
        </dl>
    </section>
</section>
@endsection
