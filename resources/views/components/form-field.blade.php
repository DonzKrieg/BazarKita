@props(['id', 'label', 'name' => null, 'type' => 'text', 'hint' => null, 'error' => null, 'value' => '', 'options' => []])
@php
    $describedBy = trim(($hint ? $id.'-hint ' : '').($error ? $id.'-error' : ''));
    $inputAttributes = $attributes->class(['form-control'])->merge([
        'id' => $id,
        'name' => $name ?? $id,
        'aria-describedby' => $describedBy ?: null,
        'aria-invalid' => $error ? 'true' : 'false',
    ]);
@endphp
<div class="space-y-2">
    <label for="{{ $id }}" class="block text-sm font-semibold">{{ $label }}@if($attributes->has('required')) <span class="font-normal text-slate-500">(wajib)</span>@endif</label>
    @if($hint)<p id="{{ $id }}-hint" class="text-sm text-slate-600">{{ $hint }}</p>@endif
    @if($type === 'textarea')
        <textarea {{ $inputAttributes }} rows="3">{{ $value }}</textarea>
    @elseif($type === 'select')
        <select {{ $inputAttributes }}>
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
            @endforeach
        </select>
    @else
        <input {{ $inputAttributes }} type="{{ $type }}" value="{{ $value }}">
    @endif
    @if($error)<p id="{{ $id }}-error" class="text-sm font-medium text-rose-800" aria-live="polite">{{ $error }}</p>@endif
</div>
