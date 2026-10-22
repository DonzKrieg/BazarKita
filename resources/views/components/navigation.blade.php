@props(['viewer'])
@php($persona = $viewer['role'] === 'guest' ? [] : ['as' => $viewer['role']])
<nav id="main-navigation" aria-label="Menu utama" :class="{ 'nav-collapsed': !menuOpen }" class="order-3 w-full lg:order-2 lg:w-auto">
    <div class="flex flex-col gap-1 border-t border-stone-100 pt-3 lg:flex-row lg:border-0 lg:pt-0">
        @foreach(['home' => 'Beranda', 'catalog' => 'Katalog Bazar', 'saved' => 'Tersimpan', 'profile' => 'Usaha Saya'] as $name => $label)
            <a href="{{ route($name, $persona) }}" @if((request()->routeIs($name) || ($name === 'catalog' && request()->routeIs('event.detail')))) aria-current="page" @endif
               @class(['rounded-lg px-3 py-3 whitespace-nowrap text-left text-sm font-semibold', 'bg-forest text-white' => (request()->routeIs($name) || ($name === 'catalog' && request()->routeIs('event.detail'))), 'text-slate-600 hover:bg-stone-100' => !(request()->routeIs($name) || ($name === 'catalog' && request()->routeIs('event.detail')))])>{{ $label }}</a>
        @endforeach
    </div>
</nav>
