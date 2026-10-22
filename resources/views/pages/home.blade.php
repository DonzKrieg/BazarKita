@extends('layouts.app')

@section('content')
    <section class="page-width py-12 sm:py-20">
        <div class="grid items-center gap-12 lg:grid-cols-[1.2fr_0.8fr] lg:gap-16">
            <div>
                <span class="status-chip">● Untuk pelaku usaha Bandung</span>
                <h1 class="hero-title mt-6">Pilih bazar yang tepat.<br><span class="text-emerald-600">Kenali sewanya.</span><br>Mulai dengan yakin.</h1>
                <p class="mt-6 max-w-lg text-base leading-7 text-slate-500">Temukan ruang berjualan yang sesuai usaha Anda. Lihat lokasi, tanggal, dan ketentuan sewa dengan jelas sebelum memilih stan.</p>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="#bazar" class="button-primary">Jelajahi contoh bazar <span class="ml-3" aria-hidden="true">→</span></a>
                    <a href="{{ route('profile', $screen['persona']) }}" class="button-secondary">Lengkapi profil usaha</a>
                </div>
                <div class="mt-7 flex flex-wrap gap-2"><span class="status-chip">✓ Harga per hari</span><span class="status-chip">✓ Ketentuan paket jelas</span><span class="status-chip">✓ Sumber dapat diperiksa</span></div>
            </div>
            <aside class="hero-preview" aria-labelledby="catatan-sewa">
                <div class="flex items-center justify-between gap-3"><span class="text-sm font-bold">Bazar pilihan Bandung</span><x-example-badge /></div>
                <p class="eyebrow mt-8 text-slate-400">Kenali sebelum memilih</p>
                <h2 id="catatan-sewa" class="mt-3 text-2xl font-bold tracking-tight">Pekan Kuliner Braga</h2>
                <p class="mt-2 text-sm text-slate-500">Braga, Bandung · 7–9 November 2026</p>
                <div class="mt-6 grid grid-cols-2 gap-3">
                    <div class="rounded-xl bg-stone-50 p-4"><p class="text-xs text-slate-500">Setara per hari</p><p class="mt-2 text-xl font-bold">Rp150.000</p></div>
                    <div class="rounded-xl bg-stone-50 p-4"><p class="text-xs text-slate-500">Komitmen sewa</p><p class="mt-2 text-xl font-bold text-emerald-700">3 hari</p></div>
                </div>
                <div class="mt-4 rounded-xl bg-stone-900 p-5 text-white"><p class="text-xs font-semibold text-emerald-400">PAHAMI KETENTUANNYA</p><p class="mt-3 text-sm leading-6 text-stone-300">Paket Rp450.000 untuk tiga hari. Harga setara bukan tawaran sewa satu hari.</p><p class="mt-3 text-xs text-stone-300">Biaya tambahan wajib: belum ada informasi.</p></div>
                <p class="mt-5 text-xs leading-5 text-slate-500">Cuplikan data contoh · Pastikan kembali kepada penyelenggara.</p>
            </aside>
        </div>
    </section>
    <section class="section-band">
        <div class="page-width">
            <p class="eyebrow text-emerald-700">Informasi yang membantu keputusan</p>
            <h2 class="section-title mt-3 max-w-lg">Kenali bazarnya.<br>Pahami kebutuhan usaha Anda.</h2>
            <p class="mt-4 max-w-xl text-sm leading-6 text-slate-500">Hal penting ditampilkan lebih dulu, dengan rincian yang dapat dibuka saat dibutuhkan.</p>
            <div class="mt-9 grid gap-5 sm:grid-cols-2">
                @foreach([
                    ['01 · Sewa transparan', 'Harga harian, ketentuan yang jelas', 'Bandingkan sewa per hari sambil tetap melihat harga paket asli, lama sewa wajib, dan biaya tambahan.', 'Harga belum pasti tetap diberi keterangan'],
                    ['02 · Sesuai kebutuhan', 'Pilihan berangkat dari usaha Anda', 'Isi jenis produk, daerah asal, tanggal, jarak, dan batas sewa untuk mencoba pilihan yang sesuai.', 'Maksimal tiga pilihan di Beranda'],
                    ['03 · Sumber informasi', 'Lihat asal informasi bazar', 'Buka sumber dan waktu pemeriksaan. Konfirmasi kembali jika informasi belum tersedia atau sudah lama.', 'Tidak ada klaim pasti ramai atau laris'],
                    ['04 · Mudah dijelajahi', 'Rincian penting, tanpa terburu-buru', 'Saring katalog, baca ketentuan stan, lalu periksa kembali informasi dengan penyelenggara.', 'Data contoh selalu ditandai']
                ] as [$tag, $title, $description, $note])
                    <div class="feature-panel"><span class="status-chip">{{ $tag }}</span><h3 class="mt-4 text-lg font-bold tracking-tight">{{ $title }}</h3><p class="mt-3 text-sm leading-6 text-slate-500">{{ $description }}</p><p class="mt-6 border-t border-stone-100 pt-4 text-xs font-medium text-emerald-700">✓ {{ $note }}</p></div>
                @endforeach
            </div>
        </div>
    </section>
    @if($screen['viewer']['role'] !== 'guest')
        <aside class="page-width pt-8" x-data="profilePreview(@js($screen['profile']), @js($screen['viewer']['role']))" aria-label="Profil contoh">
            <div class="rounded-xl border border-stone-200 bg-white p-5">
                <h2 class="font-semibold">Kebutuhan usaha contoh</h2>
                <p class="mt-2 leading-7" x-text="summary"></p>
                <p class="mt-2 text-sm text-slate-600">Ringkasan dari tab ini. Pilihan di bawah menggunakan data bazar dan lokasi contoh.</p>
                <a href="{{ route('profile', $screen['persona']) }}" class="mt-3 inline-block py-2 text-emerald-800 underline">Ubah Usaha Saya</a>
            </div>
        </aside>
    @endif
    <section id="bazar" class="page-width scroll-mt-6 py-14 sm:py-20" x-data="bazarBrowser(@js($screen['browse_events']), @js($screen['profile']), @js($screen['viewer']['role']), true)">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow text-slate-500">Ruang berjualan di sekitar Anda</p>
                <h2 class="section-title mt-2" x-text="title">Bazar Mendatang</h2>
            </div>
            <a href="{{ route('catalog', $screen['persona']) }}" class="text-sm font-semibold text-emerald-800 underline underline-offset-4">Lihat Semua Bazar</a>
        </div>
        @if ($screen['state'] === 'ready')
            <p x-show="fallback" class="mb-5"><a href="{{ route('profile', $screen['persona']) }}" class="text-emerald-800 underline">Lengkapi Usaha Saya</a> untuk mencoba pilihan personal.</p>
            <p x-show="!fallback && !originPoint" x-cloak class="mb-5">Lokasi asal belum dikenali dalam contoh. Jarak belum dapat dipastikan; lihat katalog untuk menjelajahi bazar.</p>
            <p x-show="!selected.length" x-cloak class="mb-5" role="status">Belum ada bazar yang sesuai. Coba ubah pilihan pencarian atau lihat katalog.</p>
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($screen['browse_events'] as $event)
                    <div x-show="visible(@js($event['id']))" x-bind:style="{ order: selected.findIndex(event => event.id === @js($event['id'])) }" @if($loop->index >= 3) x-cloak @endif>
                        <x-event-preview :event="$event" :persona="$screen['persona']" :detail-link="true" :distance="true" :reasons="true" />
                    </div>
                @endforeach
            </div>
            @if($screen['viewer']['role'] !== 'guest')
                <div class="mt-6 max-w-lg">
                    <x-form-field id="home-scenario" label="Coba jumlah pilihan" type="select" x-model="scenario" :options="['auto' => 'Sesuai profil contoh', '0' => '0 pilihan', '1' => '1 pilihan', '2' => '2 pilihan', '3' => '3 pilihan', '5' => '5 kandidat (tampilkan maksimal 3)', 'incomplete' => 'Profil belum lengkap']" hint="Skenario membatasi jumlah kandidat yang sudah sesuai profil; tidak menambahkan bazar yang tidak cocok." />
                </div>
            @endif
            <noscript><p>Aktifkan JavaScript untuk pilihan sesuai profil. Tiga bazar mendatang contoh ditampilkan.</p></noscript>
        @else
            <x-screen-state :state="$screen['state']" :message="$screen['message']" :action-url="route('home', $screen['persona'])" />
        @endif
        <details class="mt-8 rounded-xl border border-stone-200 px-5 py-4 text-sm">
            <summary class="font-medium text-slate-600">Coba keadaan tampilan</summary>
            <p class="mt-3 text-slate-600">Pilihan ini hanya mengubah contoh yang ditampilkan.</p>
            <nav aria-label="Keadaan contoh" class="mt-4 flex flex-wrap gap-3">
                @foreach (['ready' => 'Berisi bazar', 'loading' => 'Memuat', 'empty' => 'Kosong', 'error' => 'Gagal', 'success' => 'Berhasil'] as $state => $label)
                    <a href="{{ route('home', array_merge($screen['persona'], ['state' => $state])) }}#bazar"
                       @if ($screen['state'] === $state) aria-current="page" @endif
                       @class(['rounded-lg border px-4 py-3', 'border-forest bg-forest text-white' => $screen['state'] === $state, 'border-stone-300 hover:bg-stone-100' => $screen['state'] !== $state])>{{ $label }}</a>
                @endforeach
            </nav>
        </details>
    </section>
    <section class="section-band">
        <div class="page-width">
            <p class="eyebrow text-emerald-700">Alur sederhana</p><h2 class="section-title mt-3">Dari kebutuhan usaha ke pilihan bazar.</h2>
            <div class="mt-9 grid gap-5 md:grid-cols-3">
                @foreach([['1', 'Lengkapi Usaha Saya', 'Ceritakan jenis produk, lokasi asal, tanggal, dan batas sewa harian Anda.'], ['2', 'Jelajahi pilihan bazar', 'Lihat pilihan di Beranda atau cari lebih banyak tempat di katalog.'], ['3', 'Periksa sebelum memilih', 'Baca ketentuan sewa dan pastikan kembali informasi kepada penyelenggara.']] as [$number, $title, $description])
                    <div class="feature-panel"><span class="grid size-10 place-items-center rounded-xl bg-emerald-400 font-bold">{{ $number }}</span><h3 class="mt-6 text-lg font-bold">{{ $title }}</h3><p class="mt-3 text-sm leading-6 text-slate-500">{{ $description }}</p></div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="page-width py-14 sm:py-20">
        <div class="rounded-3xl bg-[#12171d] p-7 text-white shadow-xl sm:p-12">
            <p class="eyebrow text-emerald-400">Ruang baru untuk usaha Anda</p><h2 class="mt-5 max-w-xl text-3xl leading-tight font-bold tracking-tight sm:text-4xl">Mulai dari bazar yang<br>Anda pahami.</h2>
            <p class="mt-5 max-w-lg text-sm leading-7 text-stone-300">Kenali lokasi, jadwal, dan biaya stan. Temukan pilihan berikutnya untuk usaha Anda di Bandung.</p>
            <div class="mt-7 flex flex-wrap gap-3"><a href="{{ route('catalog', $screen['persona']) }}" class="button-secondary">Buka Katalog Bazar →</a><a href="{{ route('profile', $screen['persona']) }}" class="inline-flex min-h-11 items-center rounded-full border border-white/25 px-5 py-3 text-sm font-semibold">Isi Usaha Saya</a></div>
        </div>
    </section>
@endsection
