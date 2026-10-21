@props(['state', 'message'])
<section class="rounded-2xl border border-dashed border-stone-300 bg-white px-6 py-12 text-center"
         role="{{ $state === 'error' ? 'alert' : 'status' }}" aria-live="polite" aria-busy="{{ $state === 'loading' ? 'true' : 'false' }}">
    <p class="text-lg font-semibold text-forest">{{ $message['title'] }}</p>
    <p class="mt-2 text-sm text-slate-600">{{ $message['description'] }}</p>
    <a href="{{ route('home') }}" class="button-primary mt-6">{{ $state === 'error' ? 'Coba lagi' : 'Kembali ke contoh bazar' }}</a>
</section>
