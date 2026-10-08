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

        <section class="space-y-4">
            <h2 class="text-xl font-semibold text-stone-900">4. x-card</h2>

            <div class="grid gap-6 md:grid-cols-3">
                <x-card>
                    Só com o conteúdo por omissão.
                </x-card>

                <x-card>
                    <x-slot:header>Rosaceae</x-slot:header>
                    Família das rosas, macieiras e morangueiros.
                </x-card>

                <x-card>
                    <x-slot:header>Rosaceae <x-badge>Ativa</x-badge></x-slot:header>
                    Cartão completo.
                    <x-slot:footer>12 espécies registadas</x-slot:footer>
                </x-card>
            </div>
        </section>

</div>
