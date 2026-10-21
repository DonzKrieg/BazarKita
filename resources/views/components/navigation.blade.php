@props(['viewer'])
@php($persona = $viewer['role'] === 'guest' ? [] : ['as' => $viewer['role']])
<nav aria-label="Menu utama" class="border-t border-stone-100">
    <div class="page-width grid grid-cols-2 gap-1 py-2 sm:flex sm:flex-wrap sm:gap-2">
        @foreach(['home' => 'Beranda', 'catalog' => 'Katalog Bazar', 'saved' => 'Tersimpan', 'profile' => 'Usaha Saya'] as $name => $label)
            <a href="{{ route($name, $persona) }}" @if(request()->routeIs($name)) aria-current="page" @endif
               @class(['rounded-lg px-4 py-3 text-center text-sm font-semibold sm:text-left', 'bg-forest text-white' => request()->routeIs($name), 'text-slate-600 hover:bg-stone-100' => !request()->routeIs($name)])>{{ $label }}</a>
        @endforeach
    </div>
</nav>
