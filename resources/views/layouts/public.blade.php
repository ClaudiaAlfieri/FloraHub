<!DOCTYPE html>
<html lang="pt">
<head>
    @include('partials.head')
</head>
<body class="bg-stone-50 font-sans text-stone-800 antialiased">

<!-- Cabeçalho -->
<header class="sticky top-0 z-40 border-b border-stone-200 bg-white/90 backdrop-blur">
    <div class="relative mx-auto flex h-16 max-w-7xl items-center justify-between px-4 sm:px-6 lg:px-8">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-600 text-white">
                        <x-app-logo-icon class="h-5 w-5" />
                    </span>
            <span class="text-lg font-semibold tracking-tight text-stone-900">FloraHub</span>
        </a>

        <nav class="hidden items-center gap-8 md:flex">
            <a href="{{ route('home') }}" class="text-sm font-medium text-brand-700">Início</a>
            <a href="#" class="text-sm font-medium text-stone-600 hover:text-brand-700">Espécies</a>
        </nav>

        <div class="hidden items-center gap-3 md:flex">
            <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-semibold text-stone-700 hover:bg-stone-100">Iniciar sessão</a>
            <a href="{{ route('register') }}" class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700">Criar conta</a>
        </div>

        <details class="md:hidden">
            <summary class="flex h-9 w-9 list-none items-center justify-center rounded-lg text-stone-600 hover:bg-stone-100 [&::-webkit-details-marker]:hidden">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5"/></svg>
            </summary>
            <div class="absolute inset-x-0 top-16 border-b border-stone-200 bg-white px-4 py-4 shadow-lg">
                <div class="flex flex-col gap-1">
                    <a href="{{ route('home') }}" class="rounded-lg bg-brand-50 px-3 py-2 text-sm font-medium text-brand-700">Início</a>
                    <a href="#" class="rounded-lg px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Espécies</a>
                    <div class="my-2 border-t border-stone-200"></div>
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-stone-700 hover:bg-stone-50">Iniciar sessão</a>
                    <a href="{{ route('register') }}" class="rounded-lg bg-brand-600 px-3 py-2 text-center text-sm font-semibold text-white hover:bg-brand-700">Criar conta</a>
                </div>
            </div>
        </details>
    </div>
</header>

<!-- Conteúdo da página -->
<main>
    {{ $slot }}
</main>

<!-- Rodapé -->
<footer class="border-t border-stone-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-10 md:grid-cols-4">
            <div class="md:col-span-2">
                <div class="flex items-center gap-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-600 text-white">
                                <x-app-logo-icon class="h-4 w-4" />
                            </span>
                    <span class="text-base font-semibold text-stone-900">FloraHub</span>
                </div>
                <p class="mt-4 max-w-sm text-sm text-stone-500">Um catálogo botânico e um companheiro pessoal de cuidado de plantas, criado para ajudar a conhecer espécies e manter a sua própria coleção saudável.</p>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-stone-900">Explorar</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-stone-500">
                    <li><a href="{{ route('home') }}" class="hover:text-brand-700">Início</a></li>
                    <li><a href="#" class="hover:text-brand-700">Catálogo de espécies</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-sm font-semibold text-stone-900">Conta</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-stone-500">
                    <li><a href="{{ route('login') }}" class="hover:text-brand-700">Iniciar sessão</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-brand-700">Criar conta</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-10 border-t border-stone-200 pt-6 text-xs text-stone-400">
            © {{ date('Y') }} FloraHub — projeto educativo.
        </div>
    </div>
</footer>

</body>
</html>
