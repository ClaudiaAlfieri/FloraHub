<?php

use App\Models\Family;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;
use Flux\Flux;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

new #[Layout('layouts::admin')] #[Title('Famílias')] class extends Component
{
    use WithPagination;
    public ?int $editingId = null;
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public string $search = '';

    /**
     * Soft delete the family.
     */
    public function delete(int $id): void
    {
        Family::findOrFail($id)->delete();

        Flux::toast(variant: 'warning', text: 'Família removida.');
    }

    /**
     * Restore a soft deleted family.
     */
    public function restore(int $id): void
    {
        Family::onlyTrashed()->findOrFail($id)->restore();

        Flux::toast(variant: 'success', text: 'Família restaurada.');
    }

    /**
     * Ask for confirmation before permanently deleting a soft deleted family.
     */
    public function confirmForceDelete(int $id): void
    {
        $family = Family::onlyTrashed()->findOrFail($id);

        $this->dispatch('confirm-action',
            heading: 'Eliminar definitivamente',
            message: "A família «{$family->name}» será eliminada definitivamente. Esta operação não pode ser desfeita.",
            confirmEvent: 'family-force-delete-confirmed',
            params: ['id' => $family->id],
            confirmLabel: 'Eliminar',
        );
    }

    /**
     * Permanently delete a soft deleted family.
     */
    #[On('family-force-delete-confirmed')]
    public function forceDelete(int $id): void
    {
        Family::onlyTrashed()->findOrFail($id)->forceDelete();

        Flux::toast(variant: 'danger', text: 'Família eliminada definitivamente.');
    }

    /**
     * Open the drawer with an empty form.
     */
    public function create(): void
    {
        $this->resetForm();

        Flux::modal('family-form')->show();
    }

    /**
     * Open the drawer with the family's data.
     */
    public function edit(int $id): void
    {
        $family = Family::findOrFail($id);

        $this->resetForm();
        $this->editingId = $family->id;
        $this->name = $family->name;
        $this->slug = $family->slug;
        $this->description = $family->description ?? '';

        Flux::modal('family-form')->show();
    }

    /**
     * Create or update the family.
     */
    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('families', 'name')->ignore($this->editingId)],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('families', 'slug')->ignore($this->editingId)],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $validated['description'] = $validated['description'] ?: null;

        if ($this->editingId === null) {
            Family::create($validated);

            Flux::toast(variant: 'success', text: 'Família criada.');
        } else {
            Family::findOrFail($this->editingId)->update($validated);

            Flux::toast(variant: 'success', text: 'Família atualizada.');
        }

        Flux::modal('family-form')->close();

        $this->resetForm();
    }

    /**
     * Keep the slug in sync with the name until the admin edits the slug by hand.
     */
    public function updatingName(string $value): void
    {
        if ($this->slug === Str::slug($this->name)) {
            $this->slug = Str::slug($value);
        }
    }

    /**
     * Clear the form fields and validation errors.
     */
    protected function resetForm(): void
    {
        $this->reset('editingId', 'name', 'slug', 'description');
        $this->resetValidation();
    }

    /**
     * All families, including the soft deleted ones, filtered by the search term.
     *
     * @return LengthAwarePaginator<int, Family>
     */
    #[Computed]
    public function families(): LengthAwarePaginator
    {
        return Family::withTrashed()
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query){
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('description','LIKE',"%{$this->search}%");
                });

            })
            ->orderBy('name')
            ->paginate(15);
    }

    /**
     * Go back to the first page whenever the search term changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }
};
?>

<div>
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-stone-900">Famílias botânicas</h2>
            <p class="mt-1 text-sm text-stone-500">Gerir as famílias usadas para organizar as espécies do catálogo.</p>
        </div>

        <flux:button wire:click="create" variant="primary" icon="plus">Nova família</flux:button>
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-stone-200 bg-white">
        <div class="border-b border-stone-200 p-4">
            <flux:input
                wire:model.live.debounce.300ms="search"
                icon="magnifying-glass"
                placeholder="Pesquisar por nome ou descrição…"
                class="max-w-sm"
            />
        </div>

        <div class="px-4 [--flux-bleed:1rem]">
            <flux:table bleed :paginate="$this->families">
                <flux:table.columns>
                    <flux:table.column>Família</flux:table.column>
                    <flux:table.column>Descrição</flux:table.column>
                    <flux:table.column>Estado</flux:table.column>
                    <flux:table.column align="end">Ações</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->families as $family)
                        <flux:table.row :key="$family->id" @class(['bg-red-50' => $family->trashed()])>
                            <flux:table.cell>
                                <div class="flex items-center gap-3">
                                    {{-- Imagem da família: o carregamento de imagens será implementado numa tarefa futura --}}
                                    <span @class([
                                        'flex h-10 w-10 flex-none items-center justify-center rounded-lg',
                                        'bg-brand-100 text-brand-700' => ! $family->trashed(),
                                        'bg-red-100 text-red-600' => $family->trashed(),
                                    ])>
                                        <flux:icon.photo variant="mini" />
                                    </span>
                                    <div>
                                        <p @class([
                                            'font-medium',
                                            'text-stone-900' => ! $family->trashed(),
                                            'text-red-700 line-through' => $family->trashed(),
                                        ])>{{ $family->name }}</p>
                                        <p @class(['text-xs', 'text-stone-500' => ! $family->trashed(), 'text-red-500' => $family->trashed()])>{{ $family->slug }}</p>
                                    </div>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell @class(['max-w-md whitespace-normal', 'text-red-600' => $family->trashed()])>
                                {{ Str::limit($family->description, 90) }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:table.cell>
                                    @if ($family->trashed())
                                        <flux:badge size="sm" color="red">Removida</flux:badge>
                                    @else
                                        <flux:badge size="sm" color="green">Ativa</flux:badge>
                                    @endif
                                </flux:table.cell>
                            </flux:table.cell>

                            <flux:table.cell align="end">
                                <div class="flex justify-end gap-2">
                                    @if ($family->trashed())
                                        {{-- Próxima tarefa: pedir confirmação num modal antes de eliminar definitivamente --}}
                                        <flux:button size="sm" icon="arrow-uturn-left" wire:click="restore({{ $family->id }})">Restaurar</flux:button>
                                        <flux:button size="sm" variant="danger" icon="trash"  wire:click="confirmForceDelete({{ $family->id }})">Eliminar definitivamente</flux:button>
                                    @else
                                        <flux:button size="sm" icon="pencil-square" wire:click="edit({{ $family->id }})">Editar</flux:button>
                                        <flux:button size="sm" variant="ghost" icon="trash" wire:click="delete({{ $family->id }})">Remover</flux:button>
                                    @endif
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="4" class="py-10 text-center text-stone-500">
                                Nenhuma família encontrada.
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>
    </div>
    <flux:modal name="family-form" flyout class="md:w-lg">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editingId ? 'Editar família' : 'Nova família' }}</flux:heading>
                <flux:text class="mt-2">Os campos marcados com * são obrigatórios.</flux:text>
            </div>

            <flux:input wire:model.blur="name" label="Nome *" placeholder="Ex.: Araceae" />

            <flux:input
                wire:model="slug"
                label="Slug *"
                description="Identificador usado nos endereços. É gerado a partir do nome, mas pode ser alterado."
                placeholder="Ex.: araceae"
            />

            <flux:textarea wire:model="description" label="Descrição" rows="5" />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">Guardar</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
