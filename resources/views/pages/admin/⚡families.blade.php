<?php

use App\Models\Family;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

new #[Layout('layouts::admin')] #[Title('Famílias')] class extends Component
{
    use WithPagination;

    public ?int $editingId = null;

    public string $name = '';

    public string $slug = '';

    public string $description = '';

    public string $search = '';

    public string $status = 'all';

    #[Url(as: 'family', except: '')]
    public string $showing = '';

    /**
     * Open the drawer of the family given in the URL (?family=slug).
     */
    public function mount(): void
    {
        if ($this->showing === '') {
            return;
        }

        if ($this->shownFamily === null) {
            $this->showing = '';

            return;
        }

        Flux::modal('family-show')->show();
    }

    /**
     * The families filtered by status and by the search term.
     *
     * @return LengthAwarePaginator<int, Family>
     */
    #[Computed]
    public function families(): LengthAwarePaginator
    {
        $query = match ($this->status) {
            'active' => Family::query(),
            'trashed' => Family::onlyTrashed(),
            default => Family::withTrashed(),
        };

        return $query
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('name')
            ->paginate(15);
    }

    /**
     * The family shown in the show drawer, including a soft deleted one.
     */
    #[Computed]
    public function shownFamily(): ?Family
    {
        return Family::withTrashed()->firstWhere('slug', $this->showing);
    }

    /**
     * Go back to the first page whenever the search term changes.
     */
    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Go back to the first page whenever the status filter changes.
     */
    public function updatedStatus(): void
    {
        $this->resetPage();
    }

    /**
     * Open the show drawer with the family's details.
     */
    public function show(int $id): void
    {
        $this->showing = Family::withTrashed()->findOrFail($id)->slug;

        Flux::modal('family-show')->show();
    }

    /**
     * Close the show drawer and remove the family from the URL.
     */
    public function closeShow(): void
    {
        $this->showing = '';

        Flux::modal('family-show')->close();
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

        $this->closeShow();
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
     * Soft delete the family.
     */
    public function delete(int $id): void
    {
        Family::findOrFail($id)->delete();

        $this->closeShow();

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

        $this->closeShow();

        Flux::toast(variant: 'danger', text: 'Família eliminada definitivamente.');
    }

    /**
     * Clear the form fields and validation errors.
     */
    protected function resetForm(): void
    {
        $this->reset('editingId', 'name', 'slug', 'description');
        $this->resetValidation();
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
        <div class="flex flex-wrap items-center gap-3 border-b border-stone-200 p-4">
            <flux:input
                wire:model.live.debounce.300ms="search"
                icon="magnifying-glass"
                placeholder="Pesquisar por nome ou descrição…"
                class="max-w-sm"
            />

            <flux:select wire:model.live="status" class="max-w-44">
                <flux:select.option value="all">Todas</flux:select.option>
                <flux:select.option value="active">Ativas</flux:select.option>
                <flux:select.option value="trashed">Removidas</flux:select.option>
            </flux:select>
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
                                        <button type="button" wire:click="show({{ $family->id }})" @class([
                                            'text-left font-medium hover:underline',
                                            'text-stone-900' => ! $family->trashed(),
                                            'text-red-700 line-through' => $family->trashed(),
                                        ])>{{ $family->name }}</button>
                                        <p @class(['text-xs', 'text-stone-500' => ! $family->trashed(), 'text-red-500' => $family->trashed()])>{{ $family->slug }}</p>
                                    </div>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell @class(['max-w-md whitespace-normal', 'text-red-600' => $family->trashed()])>
                                {{ Str::limit($family->description, 90) }}
                            </flux:table.cell>

                            <flux:table.cell>
                                @if ($family->trashed())
                                    <flux:badge size="sm" color="red">Removida</flux:badge>
                                @else
                                    <flux:badge size="sm" color="green">Ativa</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell align="end">
                                <div class="flex justify-end gap-2">
                                    @if ($family->trashed())
                                        <flux:button size="sm" icon="arrow-uturn-left" wire:click="restore({{ $family->id }})">Restaurar</flux:button>
                                        <flux:button size="sm" variant="danger" icon="trash" wire:click="confirmForceDelete({{ $family->id }})">Eliminar definitivamente</flux:button>
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

    <flux:modal name="family-show" flyout class="md:w-lg" @close="closeShow">
        @if ($shownFamily = $this->shownFamily)
            <div class="space-y-6">
                {{-- Imagem da família: o carregamento de imagens será implementado numa tarefa futura --}}
                <div class="flex aspect-video flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-stone-300 bg-stone-50 text-stone-400">
                    <flux:icon.photo class="size-10" />
                    <span class="text-sm">Imagem ainda não disponível</span>
                </div>

                <div>
                    <div class="flex items-center gap-3">
                        <flux:heading size="xl">{{ $shownFamily->name }}</flux:heading>

                        @if ($shownFamily->trashed())
                            <flux:badge size="sm" color="red">Removida</flux:badge>
                        @else
                            <flux:badge size="sm" color="green">Ativa</flux:badge>
                        @endif
                    </div>
                    <flux:text class="mt-1">{{ $shownFamily->slug }}</flux:text>
                </div>

                <div>
                    <flux:heading>Descrição</flux:heading>
                    <flux:text class="mt-2 whitespace-pre-line">{{ $shownFamily->description ?? 'Sem descrição.' }}</flux:text>
                </div>

                <dl class="grid grid-cols-2 gap-4 rounded-xl bg-stone-50 p-4 text-sm">
                    <div>
                        <dt class="text-stone-500">Criada em</dt>
                        <dd class="font-medium text-stone-900">{{ $shownFamily->created_at?->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">Atualizada em</dt>
                        <dd class="font-medium text-stone-900">{{ $shownFamily->updated_at?->format('d/m/Y H:i') }}</dd>
                    </div>
                    @if ($shownFamily->trashed())
                        <div>
                            <dt class="text-red-600">Removida em</dt>
                            <dd class="font-medium text-red-700">{{ $shownFamily->deleted_at?->format('d/m/Y H:i') }}</dd>
                        </div>
                    @endif
                </dl>

                <div class="flex flex-wrap justify-end gap-2">
                    @if ($shownFamily->trashed())
                        <flux:button icon="arrow-uturn-left" wire:click="restore({{ $shownFamily->id }})">Restaurar</flux:button>
                        <flux:button variant="danger" icon="trash" wire:click="confirmForceDelete({{ $shownFamily->id }})">Eliminar definitivamente</flux:button>
                    @else
                        <flux:button icon="pencil-square" wire:click="edit({{ $shownFamily->id }})">Editar</flux:button>
                        <flux:button variant="danger" icon="trash" wire:click="delete({{ $shownFamily->id }})">Remover</flux:button>
                    @endif

                    <flux:button variant="ghost" wire:click="closeShow">Fechar</flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

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
