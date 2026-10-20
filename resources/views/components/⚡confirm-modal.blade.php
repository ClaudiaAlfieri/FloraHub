<?php

use Flux\Flux;
use Livewire\Attributes\Locked;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public string $heading = '';
    public string $message = '';
    public string $confirmLabel = '';

    #[Locked]
    public string $confirmEvent = '';

    /** @var array<string, mixed> */
    #[Locked]
    public array $params = [];

    /**
     * Open the modal with the text and the event to dispatch when the action is confirmed.
     *
     * @param  array<string, mixed>  $params
     */
    #[On('confirm-action')]
    public function open(string $heading, string $message, string $confirmEvent, array $params = [], string $confirmLabel = 'Confirmar'): void
    {
        $this->heading = $heading;
        $this->message = $message;
        $this->confirmEvent = $confirmEvent;
        $this->params = $params;
        $this->confirmLabel = $confirmLabel;

        Flux::modal('confirm-action')->show();
    }

    /**
     * Dispatch the confirmed action's event and close the modal.
     */
    public function confirm(): void
    {
        $this->dispatch($this->confirmEvent, ...$this->params);

        Flux::modal('confirm-action')->close();

        $this->reset();
    }
};
?>

<div>
    <flux:modal name="confirm-action" class="max-w-lg">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">{{ $heading }}</flux:heading>
                <flux:text class="mt-2">{{ $message }}</flux:text>
            </div>

            <div class="flex justify-end gap-2">
                <flux:modal.close>
                    <flux:button variant="ghost">Cancelar</flux:button>
                </flux:modal.close>

                <flux:button variant="danger" wire:click="confirm">{{ $confirmLabel }}</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
