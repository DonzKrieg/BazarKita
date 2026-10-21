@extends('layouts.app')
@section('title', 'Masuk — BazarKita')
@section('content')
<section class="page-width py-12">
    <div class="mx-auto max-w-lg rounded-2xl border border-stone-200 bg-white p-6 sm:p-8">
        <x-example-badge />
        <h1 class="mt-4 text-3xl font-semibold text-forest">Masuk</h1>
        <p class="mt-4 leading-7 text-slate-600">Masuk untuk melihat Tersimpan dan Usaha Saya. Pada contoh ini, Anda dapat mencoba navigasi sebagai pengguna tanpa memasukkan kata sandi.</p>
        <p class="mt-3 text-sm leading-6 text-slate-600">Pilihan ini hanya mengubah tampilan contoh. Form akun lengkap disiapkan pada tahap berikutnya.</p>
        <a href="{{ route($next, ['as' => 'user']) }}" class="button-primary mt-6 w-full">Coba sebagai pengguna</a>
        <a href="{{ route('preview.admin', ['as' => 'admin']) }}" class="button-secondary mt-3 w-full">Lihat contoh admin</a>
        <a href="{{ route('home') }}" class="mt-6 block py-2 text-center text-sm text-emerald-800 underline underline-offset-4">Lanjut sebagai pengunjung</a>
    </div>
</section>
@endsection
