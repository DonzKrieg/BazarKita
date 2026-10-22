@props(['viewer'])
@php($persona = $viewer['role'] === 'guest' ? [] : ['as' => $viewer['role']])
<nav aria-label="Menu utama" class="order-3 w-full lg:order-2 lg:w-auto">
    <div class="grid grid-cols-2 gap-1 sm:flex sm:justify-center lg:flex-nowrap">
        @foreach(['home' => 'Beranda', 'catalog' => 'Katalog Bazar', 'saved' => 'Tersimpan', 'profile' => 'Usaha Saya'] as $name => $label)
            <a href="{{ route($name, $persona) }}" @if((request()->routeIs($name) || ($name === 'catalog' && request()->routeIs('event.detail')))) aria-current="page" @endif
               @class(['rounded-lg px-3 py-3 whitespace-nowrap text-center text-sm font-semibold sm:text-left', 'bg-forest text-white' => (request()->routeIs($name) || ($name === 'catalog' && request()->routeIs('event.detail'))), 'text-slate-600 hover:bg-stone-100' => !(request()->routeIs($name) || ($name === 'catalog' && request()->routeIs('event.detail')))])>{{ $label }}</a>
        @endforeach
    </div>
</nav>
