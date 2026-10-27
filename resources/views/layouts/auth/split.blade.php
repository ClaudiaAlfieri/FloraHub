<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')

    {{-- O design de autenticação é apenas claro: remove o modo escuro sem alterar a preferência guardada --}}
    <script>
        window.Flux.applyAppearance = () => document.documentElement.classList.remove('dark');
        window.Flux.applyAppearance();
    </script>
</head>
<body class="bg-stone-50 font-sans text-stone-800 antialiased">

<div class="grid min-h-screen lg:grid-cols-2">

    <!-- Painel decorativo -->
    <div class="relative hidden flex-col justify-between overflow-hidden bg-brand-800 p-12 text-brand-50 lg:flex">
        <a href="{{ route('home') }}" class="relative flex items-center gap-2">
            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white ring-1 ring-inset ring-white/20">
                <x-app-logo-icon class="h-5 w-5" />
            </span>
            <span class="text-lg font-semibold tracking-tight text-white">FloraHub</span>
        </a>

        <div class="relative max-w-sm">
            <p class="text-2xl font-medium leading-relaxed text-white">
                "{{ __('Keep track of all your plants and never forget when they last needed water.') }}"
            </p>
            <p class="mt-4 text-sm text-brand-200">{{ __('Your personal botanical companion.') }}</p>
        </div>

        <p class="relative text-xs text-brand-300">© {{ __(':year FloraHub — educational project.', ['year' => date('Y')]) }}</p>
    </div>

    <!-- Painel do formulário -->
    <div class="flex flex-col justify-center px-6 py-12 sm:px-12 lg:px-16">
        <div class="mx-auto w-full max-w-sm">
            <div class="mb-10 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2 lg:hidden">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-600 text-white">
                        <x-app-logo-icon class="h-5 w-5" />
                    </span>
                    <span class="text-lg font-semibold tracking-tight text-stone-900">FloraHub</span>
                </a>

                <x-locale-switcher class="ml-auto" />
            </div>

            {{ $slot }}
        </div>
    </div>
</div>

@persist('toast')
<flux:toast.group>
    <flux:toast />
</flux:toast.group>
@endpersist

@fluxScripts
</body>
</html>
