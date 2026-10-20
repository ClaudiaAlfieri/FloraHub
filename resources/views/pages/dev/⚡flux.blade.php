<?php

use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Attributes\Validate;

new #[Layout('layouts::dev')] #[Title('Flux')] class extends Component {
    //

    #[Validate('required|min:3|max:50')]
    public string $commonName = '';

    #[Validate('required')]
    public string $family = '';

    #[Validate('required|min:10')]
    public string $notes = '';

    #[Validate('required|in:full,partial,shade')]
    public string $sun = 'partial';

    public bool $notify = true;

    #[Validate('accepted')]
    public bool $agree = false;

    public function save(): void
    {
        $this->validate();

        Flux::toast(heading: 'Guardado', text: "A planta «{$this->commonName}» foi registada.", variant: 'success');

        $this->reset('commonName', 'family', 'notes', 'agree');
    }

    public function toastSuccess(): void
    {
        Flux::toast(heading: 'Sucesso', text: 'A família foi guardada.', variant: 'success');
    }

    public function toastWarning(): void
    {
        Flux::toast(heading: 'Atenção', text: 'Verifique os dados.', variant: 'warning');
    }

    public function toastDanger(): void
    {
        Flux::toast(text: 'Não foi possível guardar.', variant: 'danger');
    }

    public function removePlant(): void
    {
        Flux::modal('remove-plant')->close();

        Flux::toast(heading: 'Removida', text: 'A planta foi removida.', variant: 'danger');
    }



};
?>

<div class="space-y-16">
    <flux:heading size="xl" level="1">Laboratório de Flux</flux:heading>

    {{-- As secções seguintes são acrescentadas aqui --}}

    <section class="space-y-4">
        <flux:heading size="lg">2. Botões e ícones</flux:heading>

        <div class="flex flex-wrap items-center gap-3">
            <flux:button>Predefinido</flux:button>
            <flux:button variant="primary">Primário</flux:button>
            <flux:button variant="filled">Preenchido</flux:button>
            <flux:button variant="outline">Contorno</flux:button>
            <flux:button variant="ghost">Fantasma</flux:button>
            <flux:button variant="danger">Perigo</flux:button>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <flux:button size="sm" variant="primary">Pequeno</flux:button>
            <flux:button variant="primary">Normal</flux:button>
            <flux:button variant="primary" icon="pencil-square">Com ícone</flux:button>
            <flux:button variant="outline" icon-trailing="arrow-right">Seguinte</flux:button>
            <flux:button variant="ghost" icon="trash" size="sm" aria-label="Remover" />
            <flux:button href="{{ route('dev.tailwind') }}" variant="outline">É um link</flux:button>
            <flux:button variant="primary" disabled>Desativado</flux:button>
        </div>

        <div class="flex items-center gap-4 text-stone-600">
            <flux:icon.home />
            <flux:icon.magnifying-glass />
            <flux:icon.check-circle class="text-brand-600" />
            <flux:icon.exclamation-triangle class="size-8 text-amber-500" />
        </div>
    </section>

    <section class="space-y-4">
        <flux:heading size="lg">3. Formulários</flux:heading>

        <form wire:submit="save" class="max-w-lg space-y-6 rounded-xl border border-stone-200 bg-white p-6 shadow-sm">
            <flux:input wire:model="commonName" label="Nome comum" placeholder="Ex.: Rosa-brava" />

            <flux:select wire:model="family" label="Família" placeholder="Escolher família…">
                <flux:select.option value="rosaceae">Rosaceae</flux:select.option>
                <flux:select.option value="lamiaceae">Lamiaceae</flux:select.option>
                <flux:select.option value="fagaceae">Fagaceae</flux:select.option>
            </flux:select>

            <flux:textarea wire:model="notes" label="Notas" rows="3" description="Mínimo 10 caracteres." />

            <flux:radio.group wire:model="sun" label="Exposição solar">
                <flux:radio value="full" label="Sol direto" />
                <flux:radio value="partial" label="Meia-sombra" />
                <flux:radio value="shade" label="Sombra" />
            </flux:radio.group>

            <flux:switch wire:model="notify" label="Receber lembretes de rega" />

            <flux:checkbox wire:model="agree" label="Confirmo que os dados estão corretos" />

            <div class="flex gap-3">
                <flux:button type="submit" variant="primary">Guardar</flux:button>
                <flux:button type="reset" variant="ghost">Limpar</flux:button>
            </div>
        </form>
    </section>

    <section class="space-y-4">
        <flux:heading size="lg">4. Badges, callouts e toasts</flux:heading>

        <div class="flex flex-wrap items-center gap-2">
            <flux:badge color="green">Ativa</flux:badge>
            <flux:badge color="red">Removida</flux:badge>
            <flux:badge color="amber">Pendente</flux:badge>
            <flux:badge color="sky" size="sm">Info</flux:badge>
            <flux:badge color="zinc" icon="lock-closed">Privada</flux:badge>
        </div>

        <div class="space-y-3">
            <flux:callout icon="information-circle" heading="Informação" text="Um aviso neutro, com ícone e título." />
            <flux:callout variant="success" icon="check-circle" heading="Guardado" text="A operação foi concluída." />
            <flux:callout variant="warning" icon="exclamation-triangle" heading="Atenção" text="Esta ação não pode ser desfeita." />
            <flux:callout variant="danger" icon="x-circle" heading="Erro" text="Não foi possível guardar." />
        </div>

        <div class="flex flex-wrap gap-3">
            <flux:button wire:click="toastSuccess">Toast de sucesso</flux:button>
            <flux:button wire:click="toastWarning">Toast de aviso</flux:button>
            <flux:button wire:click="toastDanger">Toast de erro</flux:button>
        </div>
    </section>

    <section class="space-y-4">
        <flux:heading size="lg">5. Modal, menu e tooltip</flux:heading>

        <div class="flex flex-wrap items-center gap-3">
            <flux:modal.trigger name="remove-plant">
                <flux:button variant="danger" icon="trash">Remover planta</flux:button>
            </flux:modal.trigger>

            <flux:dropdown>
                <flux:button icon-trailing="chevron-down">Opções</flux:button>

                <flux:menu>
                    <flux:menu.item icon="eye">Ver</flux:menu.item>
                    <flux:menu.item icon="pencil-square">Editar</flux:menu.item>
                    <flux:menu.separator />
                    <flux:menu.item icon="trash" variant="danger">Remover</flux:menu.item>
                </flux:menu>
            </flux:dropdown>

            <flux:tooltip content="Os tooltips aparecem ao passar o rato">
                <flux:button icon="question-mark-circle" variant="ghost" aria-label="Ajuda" />
            </flux:tooltip>
        </div>

        <flux:modal name="remove-plant" class="min-w-[22rem]">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Remover planta?</flux:heading>
                    <flux:text class="mt-2">Esta ação não pode ser desfeita.</flux:text>
                </div>

                <div class="flex gap-2">
                    <flux:spacer />
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancelar</flux:button>
                    </flux:modal.close>
                    <flux:button variant="danger" wire:click="removePlant">Remover</flux:button>
                </div>
            </div>
        </flux:modal>
    </section>

    <section class="space-y-6">
        <flux:heading size="lg">6. Texto, avatares e tabelas</flux:heading>

        <div>
            <flux:heading size="lg" level="3">Rosaceae</flux:heading>
            <flux:subheading>Família das rosas, macieiras e morangueiros</flux:subheading>
            <flux:text class="mt-2">Texto de corpo no estilo do Flux. Usa as cores e o tamanho certos, também no modo escuro.</flux:text>
        </div>

        <flux:separator text="ou" />

        <div class="flex items-center gap-3">
            <flux:avatar name="Ana Silva" />
            <flux:avatar name="Rui Costa" color="auto" />
            <flux:avatar name="Maria Lopes" color="auto" size="lg" />
        </div>

        <flux:table>
            <flux:table.columns>
                <flux:table.column>Família</flux:table.column>
                <flux:table.column>Espécies</flux:table.column>
                <flux:table.column>Estado</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                <flux:table.row>
                    <flux:table.cell variant="strong">Rosaceae</flux:table.cell>
                    <flux:table.cell>12</flux:table.cell>
                    <flux:table.cell><flux:badge size="sm" color="green">Ativa</flux:badge></flux:table.cell>
                </flux:table.row>
                <flux:table.row>
                    <flux:table.cell variant="strong">Lamiaceae</flux:table.cell>
                    <flux:table.cell>7</flux:table.cell>
                    <flux:table.cell><flux:badge size="sm" color="red">Removida</flux:badge></flux:table.cell>
                </flux:table.row>
            </flux:table.rows>
        </flux:table>
    </section>




</div>
