@props(['id', 'title', 'trigger', 'confirmLabel' => 'Lanjutkan contoh', 'confirmUrl' => null])
<div x-data="dialogPanel" {{ $attributes }}>
    <button type="button" class="button-secondary" x-ref="trigger" @click="$refs.dialog.showModal()">{{ $trigger }}</button>
    <dialog id="{{ $id }}" x-ref="dialog" aria-labelledby="{{ $id }}-title" aria-describedby="{{ $id }}-description"
            @close="$refs.trigger.focus()" @keydown.tab="trap($event)" class="m-auto w-[calc(100%-2.5rem)] max-w-md rounded-2xl border border-stone-200 bg-white p-6 text-slate-800 shadow-xl backdrop:bg-slate-950/50">
        <h2 id="{{ $id }}-title" class="text-xl font-semibold text-forest">{{ $title }}</h2>
        <div id="{{ $id }}-description" class="mt-3 text-sm leading-6 text-slate-600">{{ $slot }}</div>
        <div class="mt-6 flex flex-wrap justify-end gap-3">
            <button type="button" autofocus class="button-secondary" @click="$refs.dialog.close()">Batal</button>
            @if($confirmUrl)
                <a href="{{ $confirmUrl }}" class="button-primary">{{ $confirmLabel }}</a>
            @else
                <button type="button" class="button-primary" @click="$dispatch('example-confirmed'); $refs.dialog.close()">{{ $confirmLabel }}</button>
            @endif
        </div>
    </dialog>
    <noscript><p class="text-sm text-slate-600">Aktifkan JavaScript untuk membuka dialog contoh.</p></noscript>
</div>
