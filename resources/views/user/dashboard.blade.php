<x-layouts::user title="Painel">

    {{-- colar aqui o conteúdo de <main> de user-dashboard.html --}}
    <main class="flex-1 px-4 py-8 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-semibold tracking-tight text-stone-900">Bem-vindo de volta, {{ auth()->user()->name }}</h2>
        <p class="mt-1 text-sm text-stone-500">terça-feira, 30 de setembro de 2026</p>

        <!-- Stats -->
        <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <div class="rounded-2xl border border-stone-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between">
                    <p class="text-sm text-stone-500">As minhas plantas</p>
                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-brand-100 text-brand-700">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21C7 21 3 17 3 11.5 3 6 7.5 3 12 3c1 4 5 5.5 5 10.5S15 21 12 21Z"/></svg>
                            </span>
                </div>
                <p class="mt-2 text-3xl font-semibold text-stone-900">12</p>
            </div>
            <x-stat-card label="As minhas plantas" value="12" icon-class="bg-brand-100 text-brand-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21C7 21 3 17 3 11.5 3 6 7.5 3 12 3c1 4 5 5.5 5 10.5S15 21 12 21Z"/></svg>
            </x-stat-card>
            <x-stat-card label="As minhas plantas" value="12" icon-class="bg-brand-100 text-brand-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21C7 21 3 17 3 11.5 3 6 7.5 3 12 3c1 4 5 5.5 5 10.5S15 21 12 21Z"/></svg>
            </x-stat-card>
            <x-stat-card label="As minhas plantas" value="12" icon-class="bg-brand-100 text-brand-700">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21C7 21 3 17 3 11.5 3 6 7.5 3 12 3c1 4 5 5.5 5 10.5S15 21 12 21Z"/></svg>
            </x-stat-card>
        </div>

        <!-- Reminders & activity -->
        <div class="mt-6 grid gap-6 lg:grid-cols-2">
            <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-stone-200 px-6 py-4">
                    <h3 class="text-sm font-semibold text-stone-900">Lembretes próximos</h3>
                    <a href="#" class="text-sm font-medium text-brand-700 hover:text-brand-800">Ver tudo</a>
                </div>
                <ul class="divide-y divide-stone-200">
                    <li class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="text-sm font-medium text-stone-900">Regar — Figueira-lira</p>
                            <p class="text-xs text-stone-500">Sala</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">Em atraso</span>
                    </li>
                    <li class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="text-sm font-medium text-stone-900">Fertilizar — Costela-de-adão</p>
                            <p class="text-xs text-stone-500">Escritório</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-amber-100 px-2.5 py-1 text-xs font-medium text-amber-800">Vence amanhã</span>
                    </li>
                    <li class="flex items-center justify-between px-6 py-4">
                        <div>
                            <p class="text-sm font-medium text-stone-900">Podar — Jibóia</p>
                            <p class="text-xs text-stone-500">Cozinha</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-600">Daqui a 3 dias</span>
                    </li>
                </ul>
            </div>

            <div class="rounded-2xl border border-stone-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-stone-200 px-6 py-4">
                    <h3 class="text-sm font-semibold text-stone-900">Atividade de cuidados recente</h3>
                    <a href="#" class="text-sm font-medium text-brand-700 hover:text-brand-800">Ver tudo</a>
                </div>
                <ul class="divide-y divide-stone-200">
                    <li class="flex items-center gap-3 px-6 py-4">
                                <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-sky-100 text-sky-700">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a7.5 7.5 0 007.5-7.5c0-4.142-7.5-11.25-7.5-11.25S4.5 9.358 4.5 13.5A7.5 7.5 0 0012 21z"/></svg>
                                </span>
                        <div>
                            <p class="text-sm text-stone-800"><span class="font-medium">Regou</span> a Costela-de-adão</p>
                            <p class="text-xs text-stone-500">Hoje, 08:40</p>
                        </div>
                    </li>
                    <li class="flex items-center gap-3 px-6 py-4">
                                <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-brand-100 text-brand-700">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21C7 21 3 17 3 11.5 3 6 7.5 3 12 3c1 4 5 5.5 5 10.5S15 21 12 21Z"/></svg>
                                </span>
                        <div>
                            <p class="text-sm text-stone-800"><span class="font-medium">Fertilizou</span> a Zamioculca</p>
                            <p class="text-xs text-stone-500">Ontem, 18:15</p>
                        </div>
                    </li>
                    <li class="flex items-center gap-3 px-6 py-4">
                                <span class="flex h-8 w-8 flex-none items-center justify-center rounded-lg bg-stone-100 text-stone-600">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 6l12 12M6 18L18 6"/></svg>
                                </span>
                        <div>
                            <p class="text-sm text-stone-800"><span class="font-medium">Podou</span> a Jibóia</p>
                            <p class="text-xs text-stone-500">há 2 dias</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Recent plants -->
        <div class="mt-6">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-stone-900">Plantas recentes</h3>
                <a href="#" class="text-sm font-medium text-brand-700 hover:text-brand-800">Ver todas as plantas</a>
            </div>
            <div class="mt-4 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-2 bg-stone-100 text-stone-400">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.174C3.05 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.8-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/></svg>
                        <span class="text-[11px]">images/plant-placeholder.jpg</span>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-semibold text-stone-900">Costela-de-adão da Cozinha</p>
                        <p class="text-xs italic text-stone-500">Monstera deliciosa</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="inline-flex items-center rounded-full bg-stone-100 px-2 py-0.5 text-[11px] font-medium text-stone-600">Escritório</span>
                            <span class="text-[11px] text-stone-400">Regada há 3 dias</span>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-2 bg-stone-100 text-stone-400">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.174C3.05 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.8-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/></svg>
                        <span class="text-[11px]">images/plant-placeholder.jpg</span>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-semibold text-stone-900">Figueira da Sala</p>
                        <p class="text-xs italic text-stone-500">Ficus lyrata</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="inline-flex items-center rounded-full bg-stone-100 px-2 py-0.5 text-[11px] font-medium text-stone-600">Sala</span>
                            <span class="text-[11px] text-red-500">Rega em atraso</span>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-2 bg-stone-100 text-stone-400">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.174C3.05 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.8-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/></svg>
                        <span class="text-[11px]">images/plant-placeholder.jpg</span>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-semibold text-stone-900">Zamioculca da Janela</p>
                        <p class="text-xs italic text-stone-500">Zamioculcas zamiifolia</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="inline-flex items-center rounded-full bg-stone-100 px-2 py-0.5 text-[11px] font-medium text-stone-600">Quarto</span>
                            <span class="text-[11px] text-stone-400">Regada há 1 semana</span>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm">
                    <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-2 bg-stone-100 text-stone-400">
                        <svg class="h-7 w-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.174C3.05 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.8-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/></svg>
                        <span class="text-[11px]">images/plant-placeholder.jpg</span>
                    </div>
                    <div class="p-4">
                        <p class="text-sm font-semibold text-stone-900">Jibóia do Corredor</p>
                        <p class="text-xs italic text-stone-500">Epipremnum aureum</p>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="inline-flex items-center rounded-full bg-stone-100 px-2 py-0.5 text-[11px] font-medium text-stone-600">Corredor</span>
                            <span class="text-[11px] text-stone-400">Regada há 2 dias</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

</x-layouts::user>
