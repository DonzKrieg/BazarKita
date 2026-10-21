@extends('layouts.app')
@section('title', 'Tersimpan — BazarKita')
@section('content')
<section class="page-width py-10">
    <p class="eyebrow text-emerald-800">Pilihan Anda</p>
    <h1 class="mt-3 text-3xl font-semibold text-forest">Tersimpan</h1>
    <p class="mt-4 max-w-2xl leading-7 text-slate-600">Berikut contoh bazar yang tersimpan untuk Rani Contoh. Menambah dan menghapus pilihan akan tersedia pada tahap berikutnya.</p>
    <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @foreach($screen['events'] as $event)<x-event-preview :event="$event" />@endforeach
    </div>
</section>
@endsection
