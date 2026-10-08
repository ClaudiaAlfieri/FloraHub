<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-stone-50 font-sans text-stone-800 antialiased">
<nav class="border-b border-stone-200 bg-white">
    <div class="mx-auto flex max-w-5xl items-center gap-6 px-4 py-3 text-sm">
        <span class="font-semibold text-stone-900">Laboratório</span>

        @foreach (['tailwind' => 'Tailwind', 'components' => 'Componentes', 'livewire' => 'Livewire', 'flux' => 'Flux'] as $name => $label)
            @if (Route::has('dev.'.$name))
                <a href="{{ route('dev.'.$name) }}" class="text-stone-600 hover:text-stone-900">{{ $label }}</a>
            @endif
        @endforeach
    </div>
</nav>

<main class="mx-auto max-w-5xl px-4 py-10">
    {{ $slot }}
</main>

<flux:toast.group>
    <flux:toast />
</flux:toast.group>

@fluxScripts
</body>
</html>
