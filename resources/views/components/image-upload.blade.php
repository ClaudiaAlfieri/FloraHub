@props([
    'label' => null,
    'description' => null,
    'file' => null,
    'current' => null,
    'remove' => null,
])

@php
    // Nome da propriedade Livewire ligada ao campo (ex.: wire:model="image" → "image")
    $name = $attributes->wire('model')->value();

    // Pré-visualização: o ficheiro acabado de escolher (se for válido) ou, se não houver, a imagem atual
    $previewUrl = $file?->isPreviewable() && ! $errors->has($name) ? $file->temporaryUrl() : $current;
@endphp

<flux:field {{ $attributes->whereDoesntStartWith('wire:model') }}>
    <flux:label>{{ $label ?? __('Image') }}</flux:label>

    <div
        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        class="space-y-3"
    >
        <div class="relative aspect-video overflow-hidden rounded-xl border border-dashed border-stone-300 bg-stone-50">
            @if ($previewUrl)
                <img src="{{ $previewUrl }}" alt="" class="h-full w-full object-cover">
            @else
                <div class="flex h-full flex-col items-center justify-center gap-2 text-stone-400">
                    <flux:icon.photo class="size-10" />
                    <span class="text-sm">{{ __('No image') }}</span>
                </div>
            @endif

            <div x-show="uploading" style="display: none" class="absolute inset-x-0 bottom-0 h-1.5 bg-stone-200">
                <div class="h-full bg-brand-600 transition-all" x-bind:style="`width: ${progress}%`"></div>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-2">
            <label class="inline-flex h-8 cursor-pointer items-center gap-2 rounded-md border border-zinc-200 bg-white px-3 text-sm font-medium text-zinc-800 shadow-xs hover:bg-zinc-50 focus-within:ring-2 focus-within:ring-brand-500">
                <flux:icon.arrow-up-tray variant="micro" />
                {{ $previewUrl ? __('Replace image') : __('Choose image') }}
                <input type="file" accept="image/jpeg,image/png,image/webp" class="sr-only" {{ $attributes->wire('model') }}>
            </label>

            @if ($remove && $previewUrl)
                <flux:button size="sm" variant="ghost" icon="x-mark" wire:click="{{ $remove }}">{{ __('Remove image') }}</flux:button>
            @endif
        </div>
    </div>

    @if ($description)
        <flux:description>{{ $description }}</flux:description>
    @endif

    <flux:error :name="$name" />
</flux:field>
