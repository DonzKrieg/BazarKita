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
    <a href="#konten" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:bg-white focus:p-4">Lewati ke konten</a>
    <header class="border-b border-stone-200 bg-white">
        <div class="page-width flex min-h-20 items-center justify-between gap-4">
            <a href="{{ route('home') }}" aria-label="BazarKita, beranda" class="flex items-center gap-3 text-xl font-bold tracking-tight text-forest">
                <span aria-hidden="true" class="grid size-10 place-items-center rounded-xl bg-forest text-lg text-white">B.</span>
                BazarKita
            </a>
            <span class="rounded-full border border-stone-200 px-3 py-1.5 text-xs font-medium text-slate-600">Bandung & sekitarnya</span>
        </div>
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
            <a href="{{ route('preview.admin') }}" class="underline decoration-stone-400 underline-offset-4">Lihat contoh halaman admin</a>
        </div>
    </footer>
</body>
</html>
