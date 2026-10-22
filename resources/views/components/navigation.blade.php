@props(['viewer'])
@php($persona = $viewer['role'] === 'guest' ? [] : ['as' => $viewer['role']])
<nav id="main-navigation" aria-label="Menu utama" :class="{ 'nav-collapsed': !menuOpen }" class="order-3 w-full lg:order-2 lg:w-auto">
    <div class="flex flex-col gap-1 border-t border-white/10 pt-3 lg:flex-row lg:border-0 lg:pt-0">
        @foreach(['home' => 'Beranda', 'catalog' => 'Katalog Bazar', 'saved' => 'Tersimpan', 'profile' => 'Usaha Saya'] as $name => $label)
            <a href="{{ route($name, $persona) }}" @if((request()->routeIs($name) || ($name === 'catalog' && request()->routeIs('event.detail')))) aria-current="page" @endif
               @class(['rounded-full px-3 py-2.5 whitespace-nowrap text-left text-sm font-semibold', 'bg-white/15 text-white' => (request()->routeIs($name) || ($name === 'catalog' && request()->routeIs('event.detail'))), 'text-stone-300 hover:bg-white/10 hover:text-white' => !(request()->routeIs($name) || ($name === 'catalog' && request()->routeIs('event.detail')))])>{{ $label }}</a>
        @endforeach
    </div>
</nav>
