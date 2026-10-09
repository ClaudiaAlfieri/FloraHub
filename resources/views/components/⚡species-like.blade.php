<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public string $species = '';

    public bool $liked = false;

    public function toggle(): void
    {
        $this->liked = ! $this->liked;

        $this->dispatch('species-liked', species: $this->species, liked: $this->liked);
    }

    public int $likes = 0;

    #[On('species-liked')]
    public function onLiked(string $species, bool $liked): void
    {
        $this->likes += $liked ? 1 : -1;
    }

};
?>

<button type="button" wire:click="toggle"
    @class([
        'rounded-full border px-3 py-1 text-xs font-medium transition',
        'border-brand-600 bg-brand-600 text-white' => $liked,
        'border-stone-300 bg-white text-stone-700 hover:bg-stone-50' => ! $liked,
    ])>
    {{ $liked ? '♥ Gosto' : '♡ Gostar' }}
</button>
