@props(['dark' => false])

<div {{ $attributes->class(['flex items-center gap-1 text-xs font-semibold']) }}>
    <a
        href="{{ route('locale.update', 'pt_PT') }}"
        @class([
            'rounded px-1.5 py-1 uppercase',
            'text-brand-700' => ! $dark && app()->getLocale() === 'pt_PT',
            'text-stone-400 hover:text-stone-600' => ! $dark && app()->getLocale() !== 'pt_PT',
            'text-white' => $dark && app()->getLocale() === 'pt_PT',
            'text-stone-400 hover:text-stone-200' => $dark && app()->getLocale() !== 'pt_PT',
        ])
    >PT</a>
    <span @class(['text-stone-300' => ! $dark, 'text-stone-600' => $dark])>/</span>
    <a
        href="{{ route('locale.update', 'en_GB') }}"
        @class([
            'rounded px-1.5 py-1 uppercase',
            'text-brand-700' => ! $dark && app()->getLocale() === 'en_GB',
            'text-stone-400 hover:text-stone-600' => ! $dark && app()->getLocale() !== 'en_GB',
            'text-white' => $dark && app()->getLocale() === 'en_GB',
            'text-stone-400 hover:text-stone-200' => $dark && app()->getLocale() !== 'en_GB',
        ])
    >EN</a>
</div>
