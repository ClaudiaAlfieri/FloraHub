@props(['type' => 'info', 'title' => null])

@php
    $styles = match ($type) {
        'success' => 'border-brand-200 bg-brand-50 text-brand-800',
        'error' => 'border-red-200 bg-red-50 text-red-800',
        default => 'border-sky-200 bg-sky-50 text-sky-800',
    };
@endphp

<div role="alert" {{ $attributes->class(['rounded-lg border p-4 text-sm', $styles]) }}>
    @if ($title)
        <p class="font-semibold">{{ $title }}</p>
    @endif

    <div>{{ $slot }}</div>
</div>
