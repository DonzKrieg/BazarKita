<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="BazarKita membantu usaha makanan dan minuman mengenali pilihan bazar di Bandung.">
    <title>@yield('title', 'BazarKita — Ruang untuk usaha Anda')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen">
    @php($persona = $screen['viewer']['role'] === 'guest' ? [] : ['as' => $screen['viewer']['role']])
    <a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-4">Lewati ke konten</a>
    <header class="site-header" x-data="{ menuOpen: false }" @keydown.escape="if (menuOpen) { menuOpen = false; $refs.menuToggle.focus(); }" @click.outside="menuOpen = false">
        <div class="nav-shell flex min-h-16 flex-wrap items-center justify-between gap-x-3 gap-y-2 px-4 py-3 lg:flex-nowrap lg:px-5">
            <a href="{{ route('home', $persona) }}" aria-label="BazarKita, beranda" class="brand-link flex shrink-0 items-center gap-2 text-base font-bold tracking-tight">
                <span aria-hidden="true" class="grid size-8 place-items-center rounded-full bg-emerald-400 text-sm text-stone-950">B.</span>
                BazarKita
            </a>
            <x-navigation :viewer="$screen['viewer']" />
            <div class="order-2 flex shrink-0 items-center gap-3 lg:order-3">
                @if($screen['viewer']['role'] === 'guest')
                    <a href="{{ route('login') }}" class="button-secondary">Masuk</a>
                    <a href="{{ route('register') }}" class="hidden text-xs font-semibold text-white lg:inline-flex">Daftar</a>
                @else
                    <span class="hidden text-xs text-stone-300 xl:block">{{ $screen['viewer']['name'] }} · Contoh</span>
                    <x-dialog id="keluar-contoh" title="Keluar dari contoh akun?" trigger="Keluar" confirm-label="Keluar dari contoh" :confirm-url="route('home')">
                        Anda akan kembali ke tampilan pengunjung. Tidak ada sesi akun nyata pada contoh ini.
                    </x-dialog>
                @endif
                <button type="button" class="button-secondary size-11 shrink-0 p-2 lg:hidden" x-cloak x-ref="menuToggle" @click="menuOpen = !menuOpen" :aria-expanded="menuOpen" aria-controls="main-navigation" :aria-label="menuOpen ? 'Tutup menu utama' : 'Buka menu utama'">
                    <svg aria-hidden="true" class="size-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path x-show="!menuOpen" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="menuOpen" d="m6 6 12 12M6 18 18 6" />
                    </svg>
                </button>
            </div>
        </div>
    </header>
    <div class="example-notice">
        <div class="page-width flex flex-wrap items-center justify-center gap-x-3 gap-y-1 py-3 text-xs text-slate-500">
            <x-example-badge />
            <p>Seluruh informasi di halaman ini adalah contoh untuk mencoba tampilan.</p>
        </div>
    </div>
    <main id="konten" tabindex="-1">@yield('content')</main>
    <footer class="site-footer mt-20 border-t border-stone-200 bg-white">
        <div class="page-width grid gap-10 py-12 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr]">
            <div>
                <a href="{{ route('home', $persona) }}" class="flex items-center gap-2 text-lg font-bold"><span class="grid size-8 place-items-center rounded-full bg-emerald-400 text-sm">B.</span>BazarKita <span class="status-chip">Bandung</span></a>
                <p class="mt-4 max-w-sm text-sm leading-6 text-slate-500">Ruang bertemu, kesempatan bertumbuh. Kenali pilihan bazar dan pahami ketentuan sewa sebelum mulai berjualan.</p>
                <p class="mt-5 text-xs text-slate-500">Bandung, Jawa Barat · Waktu Indonesia Barat</p>
            </div>
            <div><p class="eyebrow text-stone-500">Jelajahi</p><div class="mt-4 flex flex-col items-start gap-3 text-sm">
                <a href="{{ route('catalog', $persona) }}">Katalog Bazar</a>
                <a href="{{ route('saved', $persona) }}">Bazar Tersimpan</a>
                <a href="{{ route('profile', $persona) }}">Usaha Saya</a>
            </div></div>
            <div><p class="eyebrow text-stone-500">Tentang tampilan</p><div class="mt-4 flex flex-col items-start gap-3 text-sm">
                <a href="{{ route('preview.components', $persona) }}">Panduan tampilan</a>
                <a href="{{ route('preview.admin') }}">Lihat contoh halaman admin</a>
                <span class="text-slate-500">Harga dalam rupiah per hari</span>
            </div></div>
        </div>
        <div class="page-width pb-8"><p class="rounded-xl border border-stone-100 bg-stone-50 px-5 py-4 text-xs leading-6 text-slate-500"><strong class="text-stone-700">Informasi contoh.</strong> Semua data digunakan untuk mencoba tampilan. Pastikan kembali tanggal, ketersediaan stan, dan biaya kepada penyelenggara sebelum membuat keputusan.</p>
        <p class="mt-6 text-xs text-stone-400">© {{ date('Y') }} BazarKita · Dibuat untuk pelaku usaha Bandung.</p></div>
    </footer>
</body>
</html>
