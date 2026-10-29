@props([
    'label',
    'value',
    'iconClass' => 'bg-brand-100 text-brand-700',
])

<div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
    <div class="flex items-center justify-between">
        <p class="text-sm text-stone-500">{{ $label }}</p>
        <span class="flex h-8 w-8 items-center justify-center rounded-lg {{ $iconClass }}">
            {{ $slot }}
        </span>
    </div>
    <p class="mt-2 text-3xl font-semibold text-stone-900">{{ $value }}</p>
</div>
