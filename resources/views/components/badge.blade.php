@props(['color' => 'brand'])

<span {{ $attributes->class([
    'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium',
    'bg-brand-100 text-brand-800' => $color === 'brand',
    'bg-red-100 text-red-800' => $color === 'red',
    'bg-amber-100 text-amber-800' => $color === 'amber',
]) }}>
    {{ $slot }}
</span>
