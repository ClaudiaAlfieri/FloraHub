@props(['variant' => 'primary', 'href' => null])

@php
    $variants = match ($variant) {
        'secondary' => 'border border-stone-300 bg-white text-stone-800 hover:bg-stone-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700',
        default => 'bg-brand-600 text-white hover:bg-brand-700',
    };
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->class(['inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold transition', $variants]) }}>
        {{ $slot }}
    </a>
@else
    <button {{ $attributes->class(['inline-flex items-center rounded-lg px-4 py-2 text-sm font-semibold transition', $variants])->merge(['type' => 'button']) }}>
        {{ $slot }}
    </button>
@endif

