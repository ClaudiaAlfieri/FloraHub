<?php

use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\Validate;

new #[Layout('layouts::dev')] #[Title('Livewire')] class extends Component {
    public int $count = 0;

    public string $search = '';

    public function increment(): void
    {
        $this->count++;
    }

    public function decrement(): void
    {
        $this->count--;
    }

    #[Computed]
    public function results(): array
    {
        $species = [
            'Rosa canina', 'Rosa gallica', 'Malus domestica', 'Fragaria vesca',
            'Lavandula angustifolia', 'Quercus robur', 'Olea europaea',
        ];

        return array_values(array_filter(
            $species,
            fn (string $name) => str_contains(mb_strtolower($name), mb_strtolower($this->search)),
        ));
    }

    #[Validate('required|min:3|max:50')]
    public string $suggestion = '';

    #[Validate('required|email')]
    public string $email = '';

    public ?string $saved = null;

    public function save(): void
    {
        $this->validate();

        usleep(800_000); // simula um processamento lento (só para ver o estado de carregamento)

        $this->saved = $this->suggestion;
        $this->reset('suggestion', 'email');
    }

};

?>

<div class="space-y-16">
    <h1 class="text-3xl font-bold tracking-tight text-stone-900">Laboratório de Livewire</h1>

    {{-- As secções seguintes são acrescentadas aqui --}}
    <section class="space-y-4">
        <h2 class="text-xl font-semibold text-stone-900">2. Contador</h2>

        <div class="flex items-center gap-4">
            <x-button variant="secondary" wire:click="decrement">−</x-button>
            <span class="w-12 text-center text-3xl font-bold text-stone-900">{{ $count }}</span>
            <x-button wire:click="increment">+</x-button>
        </div>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold text-stone-900">3. Pesquisa em tempo real</h2>

        <div class="grid gap-4 sm:grid-cols-2">
            <div class="space-y-1">
                <label class="text-sm font-medium">wire:model.live.debounce.300ms</label>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Escrever, p. ex. rosa"
                       class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/40">
                <p class="text-sm text-stone-500">Valor no servidor: <code>{{ $search }}</code></p>
            </div>

            <ul class="divide-y divide-stone-200 rounded-lg border border-stone-200 bg-white text-sm">
                @forelse ($this->results as $name)
                    <li class="px-4 py-2 italic">{{ $name }}</li>
                @empty
                    <li class="px-4 py-2 text-stone-500">Sem resultados.</li>
                @endforelse
            </ul>
        </div>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-semibold text-stone-900">4. Formulário com validação</h2>

        <form wire:submit="save" class="max-w-md space-y-4 rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <div class="space-y-1">
                <label for="suggestion" class="text-sm font-medium">Sugerir uma espécie</label>
                <input id="suggestion" type="text" wire:model="suggestion"
                       class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/40">
                @error('suggestion')
                <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="email" class="text-sm font-medium">O seu email</label>
                <input id="email" type="text" wire:model="email"
                       class="w-full rounded-lg border border-stone-300 px-3 py-2 text-sm focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/40">
                @error('email')
                <p class="text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <x-button type="submit" wire:loading.attr="disabled" wire:target="save">Enviar</x-button>
                <span wire:loading wire:target="save" class="text-sm text-stone-500">A guardar…</span>
            </div>

            @if ($saved)
                <x-ui.alert type="success" title="Recebido">Sugestão <strong>{{ $saved }}</strong> enviada.</x-ui.alert>
            @endif
        </form>
    </section>

</div>
