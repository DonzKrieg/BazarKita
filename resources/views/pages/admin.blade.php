@extends('layouts.app')
@section('title', 'Contoh pengelolaan bazar — BazarKita')

@section('content')
    <section class="page-width py-12">
        <p class="eyebrow text-emerald-800">Contoh halaman admin</p>
        <h1 class="mt-3 text-3xl font-semibold text-forest">Kelola Bazar</h1>
        <p class="mt-4 max-w-2xl leading-7 text-slate-600">{{ $screen['viewer']['name'] }} · Halaman ini terbuka untuk mencoba tampilan. Tidak ada proses masuk, perubahan data, atau penerbitan acara.</p>
        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @foreach ($screen['events'] as $event)
                <article class="rounded-xl border border-stone-200 bg-white p-5">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <x-badge :tone="$event['status'] === 'cancelled' ? 'danger' : ($event['status'] === 'published' ? 'success' : 'warning')">{{ $event['status_label'] }}</x-badge>
                        <x-example-badge />
                    </div>
                    <h2 class="mt-3 text-lg font-semibold">{{ $event['name'] }}</h2>
                    <p class="mt-2 text-sm text-slate-600">{{ $event['date_label'] }} · {{ $event['location']['label'] }}</p>
                    <p class="mt-4 font-semibold">{{ $event['offer']['price_label'] }}</p>
                    <p class="mt-1 text-sm">{{ $event['offer']['commitment_label'] }}</p>
                    @if ($event['offer']['package_label'])
                        <p class="mt-1 text-sm">{{ $event['offer']['package_label'] }}</p>
                    @endif
                    <p class="mt-2 text-sm text-slate-600">{{ $event['offer']['fees_label'] }}</p>
                </article>
            @endforeach
        </div>
        <a href="{{ route('home', $screen['persona']) }}" class="button-primary mt-8">Kembali ke contoh beranda</a>
    </section>
@endsection
