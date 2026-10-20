@props([
    'title' => 'Painel',
    'subtitle' => null,
    'dark' => false,
])

    <!DOCTYPE html>
<html lang="pt">
<head>
    @include('partials.head')

    {{-- O design dos painéis é apenas claro: remove o modo escuro sem alterar a preferência guardada --}}
    <script>
        window.Flux.applyAppearance = () => document.documentElement.classList.remove('dark');
        window.Flux.applyAppearance();
    </script>
</head>
<body class="bg-stone-50 font-sans text-stone-800 antialiased">

<div class="lg:flex lg:min-h-screen">

    <!-- Barra lateral (desktop) -->
    <aside @class([
                'hidden w-64 flex-none flex-col lg:flex',
                'border-r border-stone-200 bg-white' => ! $dark,
                'bg-stone-900' => $dark,
            ])>
        <div @class([
                    'flex h-16 items-center gap-2 border-b px-6',
                    'border-stone-200' => ! $dark,
                    'border-stone-800' => $dark,
                ])>
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-600 text-white">
                        <x-app-logo-icon class="h-5 w-5" />
                    </span>
            <span @class(['text-lg font-semibold tracking-tight', 'text-stone-900' => ! $dark, 'text-white' => $dark])>FloraHub</span>
            {{ $brandBadge ?? '' }}
        </div>

        <nav class="flex-1 space-y-1 px-3 py-6">
            {{ $navigation }}
        </nav>

        <div @class(['border-t p-4', 'border-stone-200' => ! $dark, 'border-stone-800' => $dark])>
            {{ $sidebarFooter }}
        </div>
    </aside>

    <div class="flex min-w-0 flex-1 flex-col">

        <!-- Barra superior -->
        <header class="sticky top-0 z-30 flex h-16 items-center gap-3 border-b border-stone-200 bg-white/90 px-4 backdrop-blur sm:px-6">
            <details class="lg:hidden">
                <summary class="flex h-9 w-9 list-none items-center justify-center rounded-lg text-stone-600 hover:bg-stone-100 [&::-webkit-details-marker]:hidden">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
                </summary>
                <div @class([
                            'absolute inset-x-0 top-16 z-20 border-b border-stone-200 px-4 py-4 shadow-lg',
                            'bg-white' => ! $dark,
                            'bg-stone-900' => $dark,
                        ])>
                    <nav class="flex flex-col gap-1">
                        {{ $navigation }}
                    </nav>
                </div>
            </details>

            <div>
                @if ($subtitle)
                    <p class="text-xs text-stone-400">{{ $subtitle }}</p>
                @endif
                <h1 class="text-base font-semibold text-stone-900">{{ $title }}</h1>
            </div>

            <div class="ml-auto flex items-center gap-2">
                {{ $actions }}
            </div>
        </header>

        <!-- Conteúdo da página -->
        <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
            {{ $slot }}
        </main>
    </div>
</div>

<flux:toast.group>
    <flux:toast />
</flux:toast.group>

@fluxScripts
</body>
</html>
