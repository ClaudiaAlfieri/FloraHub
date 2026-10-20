@props([
    'title' => 'Painel',
])

<x-layouts::dashboard :title="$title">

    <x-slot:navigation>
        <<a href="{{ route('dashboard') }}" @class([
            'flex items-center gap-3 rounded-lg border-l-2 px-3 py-2 text-sm font-medium',
            'border-brand-600 bg-brand-50 text-brand-800' => request()->routeIs('dashboard'),
            'border-transparent text-stone-600 hover:bg-stone-50' => ! request()->routeIs('dashboard'),
        ])>

        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.122 0L22.28 12M4.5 9.75V19.5a1.5 1.5 0 001.5 1.5h3.75v-6h4.5v6h3.75a1.5 1.5 0 001.5-1.5V9.75"/></svg>
            Painel
        </a>
        <a href="#" class="flex items-center gap-3 rounded-lg border-l-2 border-transparent px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-50">
            <x-app-logo-icon class="h-5 w-5" />
            As minhas plantas
        </a>
        <a href="#" class="flex items-center gap-3 rounded-lg border-l-2 border-transparent px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-50">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
            Lembretes
            <span class="ml-auto inline-flex h-5 min-w-5 items-center justify-center rounded-full bg-amber-100 px-1.5 text-xs font-semibold text-amber-800">3</span>
        </a>
        <a href="#" class="flex items-center gap-3 rounded-lg border-l-2 border-transparent px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-50">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
            Notificações
        </a>
        <a href="#" class="flex items-center gap-3 rounded-lg border-l-2 border-transparent px-3 py-2 text-sm font-medium text-stone-600 hover:bg-stone-50">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg>
            Perfil / Definições
        </a>
    </x-slot:navigation>

    <x-slot:sidebarFooter>
        <div class="flex items-center gap-3 rounded-lg px-2 py-2">
            <span class="flex h-9 w-9 flex-none items-center justify-center rounded-full bg-brand-100 text-sm font-semibold text-brand-800">SA</span>
            <div class="min-w-0">
                <p class="truncate text-sm font-medium text-stone-900">Sofia Almeida</p>
                <p class="truncate text-xs text-stone-500">utilizador</p>
            </div>
        </div>
    </x-slot:sidebarFooter>

    <x-slot:actions>
        <details class="relative">
            <summary class="flex h-9 w-9 list-none items-center justify-center rounded-lg text-stone-600 hover:bg-stone-100 [&::-webkit-details-marker]:hidden">
                <span class="relative">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                    <span class="absolute -right-0.5 -top-0.5 h-2 w-2 rounded-full bg-red-500"></span>
                </span>
            </summary>
            <div class="absolute right-0 z-20 mt-2 w-72 rounded-xl border border-stone-200 bg-white p-2 shadow-lg">
                <p class="px-2 py-1.5 text-xs font-semibold uppercase tracking-wide text-stone-400">Notificações</p>
                <a href="#" class="flex items-start gap-3 rounded-lg px-2 py-2 hover:bg-stone-50">
                    <span class="mt-1 h-2 w-2 flex-none rounded-full bg-brand-600"></span>
                    <span><span class="block text-sm text-stone-800">Lembrete: regar a Figueira-lira</span><span class="block text-xs text-stone-500">há 2 horas</span></span>
                </a>
                <a href="#" class="flex items-start gap-3 rounded-lg px-2 py-2 hover:bg-stone-50">
                    <span class="mt-1 h-2 w-2 flex-none rounded-full bg-brand-600"></span>
                    <span><span class="block text-sm text-stone-800">Cuidado registado para a Costela-de-adão</span><span class="block text-xs text-stone-500">Ontem</span></span>
                </a>
                <a href="#" class="flex items-start gap-3 rounded-lg px-2 py-2 hover:bg-stone-50">
                    <span class="mt-1 h-2 w-2 flex-none rounded-full bg-stone-300"></span>
                    <span><span class="block text-sm text-stone-800">Bem-vinda ao FloraHub!</span><span class="block text-xs text-stone-500">há 3 dias</span></span>
                </a>
            </div>
        </details>

        <details class="relative">
            <summary class="flex list-none items-center gap-2 rounded-lg px-2 py-1.5 hover:bg-stone-100 [&::-webkit-details-marker]:hidden">
                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-100 text-xs font-semibold text-brand-800">SA</span>
                <svg class="h-4 w-4 text-stone-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
            </summary>
            <div class="absolute right-0 z-20 mt-2 w-52 rounded-xl border border-stone-200 bg-white p-1.5 shadow-lg">
                <a href="#" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-stone-50">Perfil</a>
                <a href="#" class="block rounded-lg px-3 py-2 text-sm text-stone-700 hover:bg-stone-50">Definições</a>
                <div class="my-1 border-t border-stone-200"></div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full rounded-lg px-3 py-2 text-left text-sm text-red-600 hover:bg-red-50">Terminar sessão</button>
                </form>

            </div>
        </details>
    </x-slot:actions>

    {{ $slot }}

</x-layouts::dashboard>
