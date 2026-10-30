<?php

use App\Enums\Difficulty;
use App\Enums\Light;
use App\Enums\Watering;
use App\Models\Family;
use App\Models\Species;
use App\Services\Gbif\GbifClient;
use App\Services\Gbif\GbifSpecies;
use App\Services\Gbif\GbifUnavailableException;
use Flux\Flux;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

new #[Layout('layouts::admin')] #[Title('Species')] class extends Component
{
    use WithFileUploads, WithPagination;

    #[Locked]
    public ?int $editingId = null;

    public string $family_id = '';

    public string $scientific_name = '';

    public string $common_name = '';

    public string $slug = '';

    public string $description = '';

    public string $light = '';

    public string $watering = '';

    public string $difficulty = '';

    public bool $toxic_to_pets = false;

    public string $care_notes = '';

    #[Locked]
    public ?int $gbif_key = null;

    /**
     * The species proposed by GBIF, shown to the admin before it is applied to the form.
     *
     * @var array{usage_key: int, canonical_name: string, family: string|null, family_id: int|null, match_type: string, confidence: int, uncertain: bool, url: string}|null
     */
    #[Locked]
    public ?array $gbifProposal = null;

    #[Locked]
    public bool $gbifNotFound = false;

    public ?TemporaryUploadedFile $image = null;

    #[Locked]
    public ?string $currentImageUrl = null;

    #[Locked]
    public bool $imageRemoved = false;

    public string $search = '';

    public string $status = 'all';

    public string $familyFilter = '';

    #[Url(as: 'species', except: '')]
    public string $showing = '';

    /**
     * Open the drawer of the species given in the URL (?species=slug).
     */
    public function mount(): void
    {
        if ($this->showing === '') {
            return;
        }

        if ($this->shownSpecies === null) {
            $this->showing = '';

            return;
        }

        $this->authorize('view', $this->shownSpecies);

        Flux::modal('species-show')->show();
    }

    /**
     * The species filtered by status, by family and by the search term.
     *
     * @return LengthAwarePaginator<int, Species>
     */
    #[Computed]
    public function speciesList(): LengthAwarePaginator
    {
        $query = match ($this->status) {
            'active' => Species::query(),
            'trashed' => Species::onlyTrashed(),
            default => Species::withTrashed(),
        };

        return $query
            ->with('family')
            ->when($this->familyFilter !== '', function ($query) {
                $query->where('family_id', $this->familyFilter);
            })
            ->when($this->search !== '', function ($query) {
                $query->where(function ($query) {
                    $query->where('scientific_name', 'like', "%{$this->search}%")
                        ->orWhere('common_name', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->orderBy('scientific_name')
            ->paginate(15);
    }

    /**
     * The active families, used in the family filter and in the form.
     *
     * @return Collection<int, Family>
     */
    #[Computed]
    public function families(): Collection
    {
        return Family::orderBy('name')->get();
    }

    /**
     * The species shown in the show drawer, including a soft deleted one.
     */
    #[Computed]
    public function shownSpecies(): ?Species
    {
        return Species::withTrashed()->with('family')->firstWhere('slug', $this->showing);
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
     * Go back to the first page whenever the family filter changes.
     */
    public function updatedFamilyFilter(): void
    {
        $this->resetPage();
    }

    /**
     * Open the show drawer with the species' details.
     */
    public function show(int $id): void
    {
        $species = $this->findSpecies($id);

        $this->authorize('view', $species);

        $this->showing = $species->slug;

        Flux::modal('species-show')->show();
    }

    /**
     * Close the show drawer and remove the species from the URL.
     */
    public function closeShow(): void
    {
        $this->showing = '';

        Flux::modal('species-show')->close();
    }

    /**
     * Open the drawer with an empty form.
     */
    public function create(): void
    {
        $this->authorize('create', Species::class);

        $this->resetForm();

        Flux::modal('species-form')->show();
    }

    /**
     * Open the drawer with the species' data.
     */
    public function edit(int $id): void
    {
        $species = $this->findSpecies($id);

        $this->authorize('update', $species);

        $this->closeShow();
        $this->resetForm();
        $this->editingId = $species->id;
        $this->family_id = (string) $species->family_id;
        $this->scientific_name = $species->scientific_name;
        $this->common_name = $species->common_name;
        $this->slug = $species->slug;
        $this->description = $species->description ?? '';
        $this->light = $species->light->value;
        $this->watering = $species->watering->value;
        $this->difficulty = $species->difficulty->value;
        $this->toxic_to_pets = $species->toxic_to_pets;
        $this->care_notes = $species->care_notes ?? '';
        $this->gbif_key = $species->gbif_key;
        $this->currentImageUrl = $species->image_url;

        Flux::modal('species-form')->show();
    }

    /**
     * Create or update the species.
     */
    public function save(): void
    {
        $species = $this->authorizeForm();

        $validated = $this->validate([
            'family_id' => ['required', 'integer', Rule::exists('families', 'id')->withoutTrashed()],
            'scientific_name' => ['required', 'string', 'max:255', Rule::unique('species', 'scientific_name')->ignore($this->editingId)],
            'common_name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/', Rule::unique('species', 'slug')->ignore($this->editingId)],
            'description' => ['nullable', 'string', 'max:2000'],
            'light' => ['required', Rule::enum(Light::class)],
            'watering' => ['required', Rule::enum(Watering::class)],
            'difficulty' => ['required', Rule::enum(Difficulty::class)],
            'toxic_to_pets' => ['boolean'],
            'care_notes' => ['nullable', 'string', 'max:5000'],
            'gbif_key' => ['nullable', 'integer'],
            'image' => $this->imageRules(),
        ]);

        unset($validated['image']);

        $validated['description'] = $validated['description'] ?: null;
        $validated['care_notes'] = $validated['care_notes'] ?: null;

        if ($this->image !== null) {
            $validated['image'] = $this->image->store('species', 'public');
        } elseif ($this->imageRemoved) {
            $validated['image'] = null;
        }

        $oldImage = $species?->image;

        if ($species === null) {
            $created = Species::create($validated);

            Log::channel('audit')->info('Species created', ['species_id' => $created->id]);

            Flux::toast(variant: 'success', text: __('Species created.'));
        } else {
            $species->update($validated);

            Log::channel('audit')->info('Species updated', ['species_id' => $species->id]);

            Flux::toast(variant: 'success', text: __('Species updated.'));
        }

        if (array_key_exists('image', $validated) && $oldImage !== null) {
            Storage::disk('public')->delete($oldImage);
        }

        Flux::modal('species-form')->close();

        $this->resetForm();
    }

    /**
     * Keep the slug in sync with the scientific name until the admin edits the slug by hand.
     */
    public function updatingScientificName(string $value): void
    {
        if ($this->slug === Str::slug($this->scientific_name)) {
            $this->slug = Str::slug($value);
        }

        // A new name is no longer the one GBIF matched.
        $this->gbif_key = null;
        $this->gbifProposal = null;
        $this->gbifNotFound = false;
    }

    /**
     * Authorize the form: creating a new species or updating the one being edited, which is returned.
     */
    protected function authorizeForm(): ?Species
    {
        $species = $this->editingId === null ? null : $this->findSpecies($this->editingId);

        if ($species === null) {
            $this->authorize('create', Species::class);
        } else {
            $this->authorize('update', $species);
        }

        return $species;
    }

    /**
     * Look up the scientific name on GBIF and show the proposal. The form is only changed by applyGbif().
     */
    public function lookupGbif(GbifClient $gbif): void
    {
        $this->authorizeForm();

        $this->validateOnly('scientific_name', ['scientific_name' => ['required', 'string', 'max:255']]);

        $this->gbifProposal = null;
        $this->gbifNotFound = false;

        // At most 10 lookups per minute for each admin: GBIF is a free service shared by everyone.
        $key = 'gbif-lookup:'.auth()->id();

        if (RateLimiter::tooManyAttempts($key, 10)) {
            Flux::toast(variant: 'warning', text: __('Too many GBIF lookups. Try again in :seconds seconds.', ['seconds' => RateLimiter::availableIn($key)]));

            return;
        }

        RateLimiter::hit($key, 60);

        try {
            $species = $gbif->match($this->scientific_name);
        } catch (GbifUnavailableException) {
            Flux::toast(variant: 'warning', text: __('GBIF is unavailable. Try again later.'));

            return;
        }

        if ($species === null) {
            $this->gbifNotFound = true;

            return;
        }

        $this->gbifProposal = [
            'usage_key' => $species->usageKey,
            'canonical_name' => $species->canonicalName,
            'family' => $species->family,
            'family_id' => $species->family ? Family::where('name', $species->family)->value('id') : null,
            'match_type' => $species->matchType,
            'confidence' => $species->confidence,
            'uncertain' => $species->isUncertain(),
            'url' => $species->url(),
        ];
    }

    /**
     * Fill the form with the GBIF proposal. The family is only chosen when it is an active family of the catalogue.
     */
    public function applyGbif(): void
    {
        $this->authorizeForm();

        $proposal = $this->gbifProposal;

        if ($proposal === null) {
            return;
        }

        $this->updatingScientificName($proposal['canonical_name']);
        $this->scientific_name = $proposal['canonical_name'];
        $this->gbif_key = $proposal['usage_key'];

        if ($proposal['family_id'] !== null) {
            $this->family_id = (string) $proposal['family_id'];
        } elseif ($proposal['family'] !== null) {
            Flux::toast(variant: 'warning', text: __('The family :name is not in the catalogue.', ['name' => $proposal['family']]));
        }
    }

    /**
     * Close the GBIF proposal without changing the form.
     */
    public function dismissGbif(): void
    {
        $this->gbifProposal = null;
        $this->gbifNotFound = false;
    }

    /**
     * Validate the image as soon as it is uploaded.
     */
    public function updatedImage(): void
    {
        $this->imageRemoved = false;

        $this->validateOnly('image', ['image' => $this->imageRules()]);
    }

    /**
     * Remove the chosen or current image from the form. The file is only deleted when the form is saved.
     */
    public function clearImage(): void
    {
        $this->image = null;
        $this->currentImageUrl = null;
        $this->imageRemoved = true;
    }

    /**
     * Soft delete the species.
     */
    public function delete(int $id): void
    {
        $species = $this->findSpecies($id);

        $this->authorize('delete', $species);

        $species->delete();

        Log::channel('audit')->info('Species removed', ['species_id' => $species->id]);

        $this->closeShow();

        Flux::toast(variant: 'warning', text: __('Species removed.'));
    }

    /**
     * Restore a soft deleted species.
     */
    public function restore(int $id): void
    {
        $species = $this->findSpecies($id);

        $this->authorize('restore', $species);

        $species->restore();

        Log::channel('audit')->info('Species restored', ['species_id' => $species->id]);

        Flux::toast(variant: 'success', text: __('Species restored.'));
    }

    /**
     * Ask for confirmation before permanently deleting a soft deleted species.
     */
    public function confirmForceDelete(int $id): void
    {
        $species = $this->findSpecies($id);

        $this->authorize('forceDelete', $species);

        $this->dispatch('confirm-action',
            heading: __('Delete permanently'),
            message: __('The species «:name» will be permanently deleted. This action cannot be undone.', ['name' => $species->scientific_name]),
            confirmEvent: 'species-force-delete-confirmed',
            params: ['id' => $species->id],
            confirmLabel: __('Delete'),
        );
    }

    /**
     * Permanently delete a soft deleted species.
     */
    #[On('species-force-delete-confirmed')]
    public function forceDelete(int $id): void
    {
        $species = $this->findSpecies($id);

        $this->authorize('forceDelete', $species);

        $species->forceDelete();

        Log::channel('audit')->info('Species force deleted', ['species_id' => $species->id]);

        if ($species->image !== null) {
            Storage::disk('public')->delete($species->image);
        }

        $this->closeShow();

        Flux::toast(variant: 'danger', text: __('Species permanently deleted.'));
    }

    /**
     * Find a species by id, including the soft deleted ones. The policy decides what can be done with it.
     */
    protected function findSpecies(int $id): Species
    {
        return Species::withTrashed()->findOrFail($id);
    }

    /**
     * The validation rules for the species' image.
     *
     * @return array<int, string>
     */
    protected function imageRules(): array
    {
        return ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048', 'dimensions:min_width=800'];
    }

    /**
     * Clear the form fields and validation errors.
     */
    protected function resetForm(): void
    {
        $this->reset(
            'editingId', 'family_id', 'scientific_name', 'common_name', 'slug', 'description',
            'light', 'watering', 'difficulty', 'toxic_to_pets', 'care_notes',
            'gbif_key', 'gbifProposal', 'gbifNotFound',
            'image', 'currentImageUrl', 'imageRemoved',
        );
        $this->resetValidation();
    }
};

?>

<div>
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="text-2xl font-semibold tracking-tight text-stone-900">{{ __('Species') }}</h2>
            <p class="mt-1 text-sm text-stone-500">{{ __('Manage the species of the catalogue.') }}</p>
        </div>

        @can('create', App\Models\Species::class)
            <flux:button variant="primary" icon="plus" wire:click="create">{{ __('New species') }}</flux:button>
        @endcan
    </div>

    <div class="mt-6 overflow-hidden rounded-2xl border border-stone-200 bg-white">
        <div class="flex flex-wrap items-center gap-3 border-b border-stone-200 p-4">
            <flux:input
                wire:model.live.debounce.300ms="search"
                icon="magnifying-glass"
                placeholder="{{ __('Search by name or description…') }}"
                class="max-w-sm"
            />

            <flux:select wire:model.live="status" class="max-w-44">
                <flux:select.option value="all">{{ __('All') }}</flux:select.option>
                <flux:select.option value="active">{{ __('Active') }}</flux:select.option>
                <flux:select.option value="trashed">{{ __('Removed') }}</flux:select.option>
            </flux:select>

            <flux:select wire:model.live="familyFilter" class="max-w-56">
                <flux:select.option value="">{{ __('All families') }}</flux:select.option>
                @foreach ($this->families as $family)
                    <flux:select.option :value="$family->id" wire:key="filter-family-{{ $family->id }}">{{ $family->name }}</flux:select.option>
                @endforeach
            </flux:select>
        </div>

        <div class="px-4 [--flux-bleed:1rem]">
            <flux:table bleed :paginate="$this->speciesList">
                <flux:table.columns>
                    <flux:table.column>{{ __('Scientific name') }}</flux:table.column>
                    <flux:table.column>{{ __('Common name') }}</flux:table.column>
                    <flux:table.column>{{ __('Family') }}</flux:table.column>
                    <flux:table.column>{{ __('Difficulty') }}</flux:table.column>
                    <flux:table.column>{{ __('Status') }}</flux:table.column>
                    <flux:table.column align="end">{{ __('Actions') }}</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse ($this->speciesList as $species)
                        <flux:table.row :key="$species->id" @class(['bg-red-50' => $species->trashed()])>
                            <flux:table.cell>
                                <div class="flex items-center gap-3">
                                    @if ($species->image_url)
                                        <img src="{{ $species->image_url }}" alt="" @class([
                                            'h-10 w-10 flex-none rounded-lg object-cover',
                                            'opacity-50 grayscale' => $species->trashed(),
                                        ])>
                                    @else
                                        <span @class([
                                            'flex h-10 w-10 flex-none items-center justify-center rounded-lg',
                                            'bg-brand-100 text-brand-700' => ! $species->trashed(),
                                            'bg-red-100 text-red-600' => $species->trashed(),
                                        ])>
                                            <flux:icon.photo variant="mini" />
                                        </span>
                                    @endif
                                    <div>
                                        <button type="button" wire:click="show({{ $species->id }})" @class([
                                            'text-left font-medium italic hover:underline',
                                            'text-stone-900' => ! $species->trashed(),
                                            'text-red-700 line-through' => $species->trashed(),
                                        ])>{{ $species->scientific_name }}</button>
                                        <p @class(['text-xs', 'text-stone-500' => ! $species->trashed(), 'text-red-500' => $species->trashed()])>{{ $species->slug }}</p>
                                    </div>
                                </div>
                            </flux:table.cell>

                            <flux:table.cell @class(['text-red-600' => $species->trashed()])>
                                {{ $species->common_name }}
                            </flux:table.cell>

                            <flux:table.cell @class(['text-red-600' => $species->trashed()])>
                                {{ $species->family->name }}
                            </flux:table.cell>

                            <flux:table.cell>
                                <flux:badge size="sm" :color="match ($species->difficulty) { Difficulty::Easy => 'green', Difficulty::Medium => 'amber', Difficulty::Hard => 'red' }">
                                    {{ $species->difficulty->label() }}
                                </flux:badge>
                            </flux:table.cell>

                            <flux:table.cell>
                                @if ($species->trashed())
                                    <flux:badge size="sm" color="red">{{ __('Removed') }}</flux:badge>
                                @else
                                    <flux:badge size="sm" color="green">{{ __('Active') }}</flux:badge>
                                @endif
                            </flux:table.cell>

                            <flux:table.cell align="end">
                                <div class="flex justify-end gap-2">
                                    @can('restore', $species)
                                        <flux:button size="sm" icon="arrow-uturn-left" wire:click="restore({{ $species->id }})">{{ __('Restore') }}</flux:button>
                                    @endcan

                                    @can('forceDelete', $species)
                                        <flux:button size="sm" variant="danger" icon="trash" wire:click="confirmForceDelete({{ $species->id }})">{{ __('Delete permanently') }}</flux:button>
                                    @endcan

                                    @can('update', $species)
                                        <flux:button size="sm" icon="pencil-square" wire:click="edit({{ $species->id }})">{{ __('Edit') }}</flux:button>
                                    @endcan

                                    @can('delete', $species)
                                        <flux:button size="sm" variant="ghost" icon="trash" wire:click="delete({{ $species->id }})">{{ __('Remove') }}</flux:button>
                                    @endcan
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="6" class="py-10 text-center text-stone-500">
                                {{ __('No species found.') }}
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>
        </div>
    </div>

    <flux:modal name="species-show" flyout class="md:w-lg" @close="closeShow">
        @if ($shownSpecies = $this->shownSpecies)
            <div class="space-y-6">
                @if ($shownSpecies->image_url)
                    <img src="{{ $shownSpecies->image_url }}" alt="{{ $shownSpecies->scientific_name }}" class="aspect-video w-full rounded-xl object-cover">
                @else
                    <div class="flex aspect-video flex-col items-center justify-center gap-2 rounded-xl border border-dashed border-stone-300 bg-stone-50 text-stone-400">
                        <flux:icon.photo class="size-10" />
                        <span class="text-sm">{{ __('No image') }}</span>
                    </div>
                @endif

                <div>
                    <div class="flex items-center gap-3">
                        <flux:heading size="xl" class="italic">{{ $shownSpecies->scientific_name }}</flux:heading>

                        @if ($shownSpecies->trashed())
                            <flux:badge size="sm" color="red">{{ __('Removed') }}</flux:badge>
                        @else
                            <flux:badge size="sm" color="green">{{ __('Active') }}</flux:badge>
                        @endif
                    </div>
                    <flux:text class="mt-1">{{ $shownSpecies->common_name }} · {{ $shownSpecies->slug }}</flux:text>
                </div>

                <dl class="grid grid-cols-2 gap-4 rounded-xl border border-stone-200 p-4 text-sm">
                    <div>
                        <dt class="text-stone-500">{{ __('Family') }}</dt>
                        <dd class="font-medium text-stone-900">
                            {{ $shownSpecies->family->name }}
                            @if ($shownSpecies->family->trashed())
                                <flux:badge size="sm" color="red" class="ml-1">{{ __('Removed') }}</flux:badge>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">{{ __('Light exposure') }}</dt>
                        <dd class="font-medium text-stone-900">{{ $shownSpecies->light->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">{{ __('Watering') }}</dt>
                        <dd class="font-medium text-stone-900">{{ $shownSpecies->watering->label() }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">{{ __('Difficulty') }}</dt>
                        <dd class="font-medium text-stone-900">{{ $shownSpecies->difficulty->label() }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-stone-500">{{ __('Toxicity') }}</dt>
                        <dd @class(['font-medium', 'text-red-700' => $shownSpecies->toxic_to_pets, 'text-stone-900' => ! $shownSpecies->toxic_to_pets])>
                            {{ $shownSpecies->toxic_to_pets ? __('Toxic to pets') : __('Not toxic to pets') }}
                        </dd>
                    </div>
                    @if ($shownSpecies->gbif_url)
                        <div class="col-span-2">
                            <dt class="text-stone-500">GBIF</dt>
                            <dd>
                                <a href="{{ $shownSpecies->gbif_url }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1 font-medium text-brand-700 hover:underline">
                                    {{ __('View on GBIF') }}
                                    <flux:icon.arrow-top-right-on-square variant="micro" />
                                </a>
                            </dd>
                        </div>
                    @endif
                </dl>

                <div>
                    <flux:heading>{{ __('Description') }}</flux:heading>
                    <flux:text class="mt-2 whitespace-pre-line">{{ $shownSpecies->description ?? __('No description.') }}</flux:text>
                </div>

                <div>
                    <flux:heading>{{ __('Care guide') }}</flux:heading>
                    <flux:text class="mt-2 whitespace-pre-line">{{ $shownSpecies->care_notes ?? __('No care notes.') }}</flux:text>
                </div>

                <dl class="grid grid-cols-2 gap-4 rounded-xl bg-stone-50 p-4 text-sm">
                    <div>
                        <dt class="text-stone-500">{{ __('Created at') }}</dt>
                        <dd class="font-medium text-stone-900">{{ $shownSpecies->created_at?->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-stone-500">{{ __('Updated at') }}</dt>
                        <dd class="font-medium text-stone-900">{{ $shownSpecies->updated_at?->format('d/m/Y H:i') }}</dd>
                    </div>
                    @if ($shownSpecies->trashed())
                        <div>
                            <dt class="text-red-600">{{ __('Removed at') }}</dt>
                            <dd class="font-medium text-red-700">{{ $shownSpecies->deleted_at?->format('d/m/Y H:i') }}</dd>
                        </div>
                    @endif
                </dl>

                <div class="flex flex-wrap justify-end gap-2">
                    @can('restore', $shownSpecies)
                        <flux:button icon="arrow-uturn-left" wire:click="restore({{ $shownSpecies->id }})">{{ __('Restore') }}</flux:button>
                    @endcan

                    @can('forceDelete', $shownSpecies)
                        <flux:button variant="danger" icon="trash" wire:click="confirmForceDelete({{ $shownSpecies->id }})">{{ __('Delete permanently') }}</flux:button>
                    @endcan

                    @can('update', $shownSpecies)
                        <flux:button icon="pencil-square" wire:click="edit({{ $shownSpecies->id }})">{{ __('Edit') }}</flux:button>
                    @endcan

                    @can('delete', $shownSpecies)
                        <flux:button variant="danger" icon="trash" wire:click="delete({{ $shownSpecies->id }})">{{ __('Remove') }}</flux:button>
                    @endcan

                    <flux:button variant="ghost" wire:click="closeShow">{{ __('Close') }}</flux:button>
                </div>
            </div>
        @endif
    </flux:modal>

    <flux:modal name="species-form" flyout class="md:w-lg">
        <form wire:submit="save" class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $editingId ? __('Edit species') : __('New species') }}</flux:heading>
                <flux:text class="mt-2">{{ __('Fields marked with * are required.') }}</flux:text>
            </div>

            <flux:select wire:model="family_id" label="{{ __('Family *') }}" placeholder="{{ __('Choose a family…') }}">
                @foreach ($this->families as $family)
                    <flux:select.option :value="$family->id" wire:key="form-family-{{ $family->id }}">{{ $family->name }}</flux:select.option>
                @endforeach
            </flux:select>

            <div class="space-y-3">
                <div class="flex items-start gap-2">
                    <div class="flex-1">
                        <flux:input wire:model.blur="scientific_name" label="{{ __('Scientific name *') }}" placeholder="{{ __('E.g.: Monstera deliciosa') }}" />
                    </div>

                    <flux:button type="button" icon="magnifying-glass" class="mt-6" wire:click="lookupGbif" wire:loading.attr="disabled" wire:target="lookupGbif">
                        {{ __('Look up on GBIF') }}
                    </flux:button>
                </div>

                @if ($gbif_key)
                    <flux:text class="text-xs">
                        {{ __('Linked to GBIF') }}:
                        <a href="{{ GbifSpecies::urlFor($gbif_key) }}" target="_blank" rel="noopener" class="font-medium text-brand-700 hover:underline">{{ $gbif_key }}</a>
                    </flux:text>
                @endif

                @if ($gbifProposal)
                    <div @class([
                        'space-y-3 rounded-xl border p-4 text-sm',
                        'border-amber-300 bg-amber-50' => $gbifProposal['uncertain'],
                        'border-brand-200 bg-brand-50' => ! $gbifProposal['uncertain'],
                    ])>
                        <p class="font-semibold text-stone-900">{{ __('GBIF proposal') }}</p>

                        <dl class="grid grid-cols-2 gap-3">
                            <div>
                                <dt class="text-stone-500">{{ __('Scientific name') }}</dt>
                                <dd class="font-medium italic text-stone-900">{{ $gbifProposal['canonical_name'] }}</dd>
                            </div>
                            <div>
                                <dt class="text-stone-500">{{ __('Family') }}</dt>
                                <dd class="font-medium text-stone-900">{{ $gbifProposal['family'] ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-stone-500">{{ __('Match') }}</dt>
                                <dd class="font-medium text-stone-900">{{ $gbifProposal['match_type'] }} · {{ $gbifProposal['confidence'] }}%</dd>
                            </div>
                            <div>
                                <dt class="text-stone-500">{{ __('GBIF key') }}</dt>
                                <dd><a href="{{ $gbifProposal['url'] }}" target="_blank" rel="noopener" class="font-medium text-brand-700 hover:underline">{{ $gbifProposal['usage_key'] }}</a></dd>
                            </div>
                        </dl>

                        @if ($gbifProposal['uncertain'])
                            <p class="text-amber-800">{{ __('Uncertain match: check the name before applying it.') }}</p>
                        @endif

                        @if ($gbifProposal['family'] !== null && $gbifProposal['family_id'] === null)
                            <p class="text-amber-800">{{ __('The family :name is not in the catalogue.', ['name' => $gbifProposal['family']]) }}</p>
                        @endif

                        <div class="flex justify-end gap-2">
                            <flux:button type="button" size="sm" variant="ghost" wire:click="dismissGbif">{{ __('Dismiss') }}</flux:button>
                            <flux:button type="button" size="sm" variant="primary" icon="check" wire:click="applyGbif">{{ __('Apply') }}</flux:button>
                        </div>
                    </div>
                @elseif ($gbifNotFound)
                    <div class="flex items-start justify-between gap-3 rounded-xl border border-stone-200 bg-stone-50 p-4 text-sm text-stone-600">
                        <p>{{ __('GBIF does not know this name. Check the spelling.') }}</p>
                        <flux:button type="button" size="sm" variant="ghost" wire:click="dismissGbif">{{ __('Dismiss') }}</flux:button>
                    </div>
                @endif
            </div>

            <flux:input wire:model="common_name" label="{{ __('Common name *') }}" placeholder="{{ __('E.g.: Swiss cheese plant') }}" />

            <flux:input
                wire:model="slug"
                label="{{ __('Slug *') }}"
                description="{{ __('Identifier used in addresses. It is generated from the scientific name, but can be changed.') }}"
                placeholder="{{ __('E.g.: monstera-deliciosa') }}"
            />

            <div class="grid gap-4 sm:grid-cols-3">
                <flux:select wire:model="light" label="{{ __('Light exposure *') }}" placeholder="{{ __('Choose…') }}">
                    @foreach (Light::cases() as $option)
                        <flux:select.option :value="$option->value">{{ $option->label() }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="watering" label="{{ __('Watering *') }}" placeholder="{{ __('Choose…') }}">
                    @foreach (Watering::cases() as $option)
                        <flux:select.option :value="$option->value">{{ $option->label() }}</flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select wire:model="difficulty" label="{{ __('Difficulty *') }}" placeholder="{{ __('Choose…') }}">
                    @foreach (Difficulty::cases() as $option)
                        <flux:select.option :value="$option->value">{{ $option->label() }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <flux:checkbox wire:model="toxic_to_pets" label="{{ __('Toxic to pets') }}" />

            <flux:textarea wire:model="description" label="{{ __('Description') }}" rows="4" />

            <flux:textarea wire:model="care_notes" label="{{ __('Care guide') }}" description="{{ __('Watering, light, substrate, temperature, fertilisation…') }}" rows="5" />

            <x-image-upload
                wire:model="image"
                :file="$image"
                :current="$currentImageUrl"
                remove="clearImage"
                description="{{ __('JPG, PNG or WebP, up to 2 MB, at least 800 px wide.') }}"
            />

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">{{ __('Cancel') }}</flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>
            </div>
        </form>
    </flux:modal>
</div>
