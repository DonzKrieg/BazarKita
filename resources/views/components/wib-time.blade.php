@props(['value'])
@if($value)
    <time datetime="{{ $value }}" {{ $attributes }}>{{ \App\Support\Display::wib($value) }}</time>
@else
    <span {{ $attributes }}>Belum ada informasi</span>
@endif
