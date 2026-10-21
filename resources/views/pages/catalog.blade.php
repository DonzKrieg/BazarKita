@extends('layouts.app')
@section('title', 'Katalog Bazar — BazarKita')
@section('content')
<section class="page-width py-10">
    <p class="eyebrow text-emerald-800">Bandung & sekitarnya</p>
    <h1 class="mt-3 text-3xl font-semibold text-forest">Katalog Bazar</h1>
    <p class="mt-4 max-w-2xl leading-7 text-slate-600">Kenali bazar dan ketentuan sewanya. Daftar ini menggunakan data contoh; pencarian dan filter akan tersedia pada tahap berikutnya.</p>
    <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @foreach($screen['events'] as $event)<x-event-preview :event="$event" />@endforeach
    </div>
</section>
@endsection
