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
    <header class="border-b border-stone-200 bg-white">
        <div class="page-width flex min-h-20 items-center justify-between gap-4">
            <a href="{{ route('home', $persona) }}" aria-label="BazarKita, beranda" class="flex items-center gap-3 text-xl font-bold tracking-tight text-forest">
                <span aria-hidden="true" class="grid size-10 place-items-center rounded-xl bg-forest text-lg text-white">B.</span>
                BazarKita
            </a>
            <div class="flex items-center gap-3">
                @if($screen['viewer']['role'] === 'guest')
                    <a href="{{ route('login') }}" class="button-secondary">Masuk</a>
                @else
                    <span class="hidden text-sm text-slate-600 md:block">{{ $screen['viewer']['name'] }} · Contoh</span>
                    <x-dialog id="keluar-contoh" title="Keluar dari contoh akun?" trigger="Keluar" confirm-label="Keluar dari contoh" :confirm-url="route('home')">
                        Anda akan kembali ke tampilan pengunjung. Tidak ada sesi akun nyata pada contoh ini.
                    </x-dialog>
                @endif
            </div>
        </div>
        <x-navigation :viewer="$screen['viewer']" />
    </header>
    <div class="border-b border-amber-200 bg-amber-50">
        <div class="page-width flex flex-wrap items-center gap-x-3 gap-y-1 py-3 text-sm text-amber-950">
            <x-example-badge />
            <p>Seluruh informasi di halaman ini adalah contoh untuk mencoba tampilan.</p>
        </div>
    </div>
    <main id="konten" tabindex="-1">@yield('content')</main>
    <footer class="mt-16 border-t border-stone-200">
        <div class="page-width flex flex-col gap-3 py-7 text-sm text-slate-600 sm:flex-row sm:items-center sm:justify-between">
            <p>BazarKita · Ruang bertemu, kesempatan bertumbuh.</p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('preview.components', $persona) }}" class="underline decoration-stone-400 underline-offset-4">Panduan tampilan</a>
                <a href="{{ route('preview.admin') }}" class="underline decoration-stone-400 underline-offset-4">Lihat contoh halaman admin</a>
            </div>
        </div>
    </footer>
</body>
</html>
