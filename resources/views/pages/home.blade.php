@extends('layouts.app')

@section('content')
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
    <section class="page-width py-12 sm:py-16">
        <div class="grid items-center gap-10 lg:grid-cols-[1.25fr_0.75fr]">
            <div>
                <p class="eyebrow text-emerald-800">Untuk usaha makanan & minuman</p>
                <h1 class="mt-5 max-w-2xl text-4xl leading-tight font-semibold tracking-tight text-forest sm:text-5xl">Temukan tempat baru<br class="hidden sm:block"> untuk usaha Anda.</h1>
                <p class="mt-6 max-w-xl text-base leading-7 text-slate-600">Kenali pilihan bazar di Bandung, lihat sewa per hari, dan pahami ketentuannya sebelum mulai berjualan.</p>
                <a href="#bazar" class="button-primary mt-7">Jelajahi contoh bazar <svg aria-hidden="true" class="ml-3 size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14m-6-6 6 6-6 6"/></svg></a>
            </div>
            <aside class="rounded-3xl bg-forest p-7 text-white sm:p-9" aria-labelledby="catatan-sewa">
                <span aria-hidden="true" class="text-4xl text-amber-200">✳</span>
                <h2 id="catatan-sewa" class="mt-5 text-2xl leading-snug font-medium">Mulai dari informasi<br>yang jelas.</h2>
                <p class="mt-4 text-sm leading-6 text-emerald-50">Perhatikan harga per hari, jumlah hari wajib, dan biaya tambahan. Harga paket tidak selalu berarti bisa sewa satu hari.</p>
                <p class="mt-7 border-t border-white/20 pt-5 text-xs leading-5 text-emerald-100">Contoh tampilan · Semua tanggal acara menggunakan WIB.</p>
            </aside>
        </div>
    </section>
    <section id="bazar" class="page-width scroll-mt-6" x-data="bazarBrowser(@js($screen['browse_events']), @js($screen['profile']), @js($screen['viewer']['role']), true)">
        <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="eyebrow text-slate-500">Ruang berjualan di sekitar Anda</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-forest" x-text="title">Bazar Mendatang</h2>
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
@endsection
