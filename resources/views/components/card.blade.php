<div {{ $attributes->class('rounded-xl border border-stone-200 bg-white shadow-sm') }}>
    @isset($header)
        <div class="border-b border-stone-200 px-5 py-3 font-semibold text-stone-900">
            {{ $header }}
        </div>
    @endisset

    <div class="p-5">
        {{ $slot }}
    </div>

    @isset($footer)
        <div class="border-t border-stone-200 bg-stone-50 px-5 py-3 text-sm text-stone-600">
            {{ $footer }}
        </div>
    @endisset


</div>
