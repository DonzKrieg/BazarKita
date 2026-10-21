@extends('layouts.app')
@php($register = request()->routeIs('register'))
@section('title', ($register ? 'Daftar' : 'Masuk').' — BazarKita')
@section('content')
<section class="page-width py-12">
    <div class="mx-auto max-w-lg rounded-2xl border border-stone-200 bg-white p-6 sm:p-8" x-data="accountPreview(@js($register))">
        <x-example-badge />
        <h1 class="mt-4 text-3xl font-semibold text-forest">{{ $register ? 'Daftar' : 'Masuk' }}</h1>
        <p class="mt-4 leading-7 text-slate-600">Demonstrasi akun. Gunakan email dan kata sandi rekaan, bukan kredensial pribadi. Isian tidak dikirim atau disimpan. Peran hanya mengubah tampilan; tidak ada sesi aman atau autentikasi nyata.</p>
        <form class="mt-6 space-y-5" @submit.prevent="submit" novalidate autocomplete="off">
            <fieldset disabled x-bind:disabled="false" class="space-y-5">
                <legend class="sr-only">{{ $register ? 'Form daftar contoh' : 'Form masuk contoh' }}</legend>
                <x-form-field id="account-email" label="Email contoh" type="email" required x-model="email" x-ref="email" x-bind:aria-invalid="!!errors.email">
                    <x-slot:error><span x-text="errors.email"></span></x-slot:error>
                </x-form-field>
                <x-form-field id="account-password" label="Kata sandi contoh" type="password" required hint="Minimal 8 karakter rekaan. Isian dihapus setelah setiap percobaan." autocomplete="new-password" x-model="password" x-ref="password" x-bind:aria-invalid="!!errors.password">
                    <x-slot:error><span x-text="errors.password"></span></x-slot:error>
                </x-form-field>
                @if($register)
                    <x-form-field id="account-confirmation" label="Konfirmasi kata sandi" type="password" required autocomplete="new-password" x-model="confirmation" x-ref="confirmation" x-bind:aria-invalid="!!errors.confirmation">
                        <x-slot:error><span x-text="errors.confirmation"></span></x-slot:error>
                    </x-form-field>
                @else
                    <x-form-field id="account-role" label="Peran contoh" type="select" :options="['user' => 'Pengguna — Rani Contoh', 'admin' => 'Admin — Dina Contoh']" x-model="role" @change="reset" />
                @endif
                <x-form-field id="account-scenario" label="Skenario demonstrasi" type="select" :options="$register ? ['success' => 'Berhasil', 'duplicate' => 'Email sudah terdaftar'] : ['success' => 'Berhasil', 'wrong' => 'Kata sandi salah', 'limited' => 'Percobaan masuk dibatasi']" x-model="scenario" @change="reset" hint="Hasil ditentukan oleh pilihan contoh ini, bukan pemeriksaan akun di server." />
                <button type="submit" class="button-primary w-full">{{ $register ? 'Daftar contoh' : 'Masuk contoh' }}</button>
                <button type="button" class="button-secondary w-full" @click="scenario = 'success'; reset(); email = ''; $refs.email.focus()">Atur ulang demonstrasi</button>
            </fieldset>
        </form>
        <p x-ref="result" tabindex="-1" role="status" class="mt-4 leading-7" x-text="message"></p>
        <div x-show="success" x-cloak>
            <a x-show="role === 'user'" href="{{ route($next, ['as' => 'user']) }}" class="button-primary mt-4 w-full">Lanjut sebagai pengguna contoh</a>
            <a x-show="role === 'admin'" href="{{ route('preview.admin', ['as' => 'admin']) }}" class="button-primary mt-4 w-full">Lanjut sebagai admin contoh</a>
        </div>
        <noscript><p class="mt-4">Aktifkan JavaScript untuk mencoba validasi form. Tautan contoh di bawah tetap dapat digunakan.</p></noscript>
        <a href="{{ route($register ? 'login' : 'register', ['next' => $next]) }}" class="mt-6 block py-2 text-emerald-800 underline underline-offset-4">{{ $register ? 'Sudah punya akun? Masuk' : 'Belum punya akun? Daftar' }}</a>
        <details class="mt-4">
            <summary class="cursor-pointer py-2 font-semibold">Navigasi contoh tanpa mengisi form</summary>
            <a href="{{ route($next, ['as' => 'user']) }}" class="button-secondary mt-3 w-full">Coba sebagai pengguna</a>
            <a href="{{ route('preview.admin', ['as' => 'admin']) }}" class="button-secondary mt-3 w-full">Lihat contoh admin</a>
        </details>
        <a href="{{ route('home') }}" class="mt-6 block py-2 text-center text-sm text-emerald-800 underline underline-offset-4">Lanjut sebagai pengunjung</a>
    </div>
</section>
@endsection
