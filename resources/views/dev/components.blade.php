<x-layouts::dev title="Componentes">
    <div class="space-y-16">

        <h1 class="text-3xl font-bold tracking-tight text-stone-900">Laboratório de Componentes</h1>

        {{-- As secções seguintes são acrescentadas aqui --}}

    </div>


    <section class="space-y-4">
        <h2 class="text-xl font-semibold text-stone-900">2. x-badge</h2>

        <div class="flex flex-wrap gap-2">
            <x-badge>Ativa</x-badge>
            <x-badge>Pública</x-badge>
            <x-badge color="red">Removida</x-badge>
            <x-badge color="amber">Pendente</x-badge>
        </div>

        @php
            $estados = ['Ativa' => 'brand', 'Pendente' => 'amber', 'Removida' => 'red'];
        @endphp

        <div class="flex flex-wrap gap-2">
            @foreach ($estados as $nome => $cor)
                <x-badge :color="$cor">{{ $nome }}</x-badge>
            @endforeach
        </div>

        <section class="space-y-4">
            <h2 class="text-xl font-semibold text-stone-900">3. Atributos</h2>

            <div class="flex flex-wrap items-center gap-2">
                <x-badge class="uppercase tracking-wide">uppercase</x-badge>
                <x-badge class="px-4 py-2 text-sm" color="amber">maior</x-badge>
                <x-badge id="meu-badge" title="Passe o rato" data-origem="teste">id + title + data-*</x-badge>
            </div>
        </section>

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

        <section class="space-y-4">
            <h2 class="text-xl font-semibold text-stone-900">5. x-button</h2>

            <div class="flex flex-wrap items-center gap-3">
                <x-button>Guardar</x-button>
                <x-button variant="secondary">Cancelar</x-button>
                <x-button variant="danger">Eliminar</x-button>
                <x-button href="{{ route('dev.tailwind') }}">Ir para Tailwind (link)</x-button>
                <x-button type="submit" class="w-48 justify-center">type="submit"</x-button>
            </div>
        </section>


    </section>

</x-layouts::dev>

