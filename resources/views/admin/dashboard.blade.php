<x-layouts::admin title="Painel">

    <h2 class="text-2xl font-semibold tracking-tight text-stone-900">Painel de administração</h2>
    <p class="mt-1 text-sm text-stone-500">Vista geral do catálogo e da comunidade FloraHub.</p>

    <!-- Indicadores -->
    <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <x-stat-card :label="__('Total users')" :value="$usersCount" icon-class="bg-brand-100 text-brand-700">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>
        </x-stat-card>
        <x-stat-card :label="__('Species in the catalogue')" :value="$speciesCount" icon-class="bg-sky-100 text-sky-700">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z"/></svg>
        </x-stat-card>
        <x-stat-card label="Famílias botânicas" :value="$familiesCount" icon-class="bg-amber-100 text-amber-700">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z"/></svg>
        </x-stat-card>
        <x-stat-card label="Plantas registadas" value="512" icon-class="bg-stone-100 text-stone-600">
            <x-app-logo-icon class="h-4 w-4" />
        </x-stat-card>
    </div>

    <!-- Espécies recentes -->
    <div class="mt-6">
        <div class="flex items-center justify-between">
            <h3 class="text-sm font-semibold text-stone-900">Espécies adicionadas recentemente</h3>
            <a href="{{ route('admin.species.index') }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">{{ __('Manage species') }}</a>
        </div>
        <div class="mt-4 overflow-hidden rounded-t-2xl border border-stone-200 bg-white">
            <div class="border-b border-stone-200 p-4">
                <div class="relative max-w-sm">
                    <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-stone-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                    <input type="text" placeholder="Pesquisar espécie…" class="w-full rounded-lg border border-stone-300 bg-white py-2 pl-9 pr-3 text-sm text-stone-900 placeholder:text-stone-400 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/20" />
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-stone-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Espécie</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Família</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Adicionado por</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Data</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">Estado</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-200">
                    <tr class="hover:bg-stone-50">
                        <td class="px-5 py-3 font-medium text-stone-900">Monstera deliciosa</td>
                        <td class="px-5 py-3 text-stone-600">Araceae</td>
                        <td class="px-5 py-3 text-stone-600">Rui Mendes</td>
                        <td class="px-5 py-3 text-stone-500">28 set. 2026</td>
                        <td class="px-5 py-3"><span class="inline-flex items-center rounded-full bg-brand-100 px-2.5 py-1 text-xs font-medium text-brand-800">Publicado</span></td>
                    </tr>
                    <tr class="hover:bg-stone-50">
                        <td class="px-5 py-3 font-medium text-stone-900">Calathea orbifolia</td>
                        <td class="px-5 py-3 text-stone-600">Marantaceae</td>
                        <td class="px-5 py-3 text-stone-600">Rui Mendes</td>
                        <td class="px-5 py-3 text-stone-500">27 set. 2026</td>
                        <td class="px-5 py-3"><span class="inline-flex items-center rounded-full bg-stone-100 px-2.5 py-1 text-xs font-medium text-stone-600">Rascunho</span></td>
                    </tr>
                    <tr class="hover:bg-stone-50">
                        <td class="px-5 py-3 font-medium text-stone-900">Crassula ovata</td>
                        <td class="px-5 py-3 text-stone-600">Crassulaceae</td>
                        <td class="px-5 py-3 text-stone-600">Ana Ferreira</td>
                        <td class="px-5 py-3 text-stone-500">25 set. 2026</td>
                        <td class="px-5 py-3"><span class="inline-flex items-center rounded-full bg-brand-100 px-2.5 py-1 text-xs font-medium text-brand-800">Publicado</span></td>
                    </tr>
                    <tr class="hover:bg-stone-50">
                        <td class="px-5 py-3 font-medium text-stone-900">Sansevieria trifasciata</td>
                        <td class="px-5 py-3 text-stone-600">Asparagaceae</td>
                        <td class="px-5 py-3 text-stone-600">Ana Ferreira</td>
                        <td class="px-5 py-3 text-stone-500">22 set. 2026</td>
                        <td class="px-5 py-3"><span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700">Precisa de revisão</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="flex items-center justify-between rounded-b-2xl border-x border-b border-stone-200 bg-white px-5 py-4">
            <p class="text-sm text-stone-500">A mostrar <span class="font-medium text-stone-700">1–4</span> de <span class="font-medium text-stone-700">96</span></p>
            <nav class="flex items-center gap-1">
                <a href="#" class="rounded-lg px-3 py-1.5 text-sm text-stone-400">Anterior</a>
                <a href="#" class="rounded-lg bg-brand-600 px-3 py-1.5 text-sm font-medium text-white">1</a>
                <a href="#" class="rounded-lg px-3 py-1.5 text-sm text-stone-600 hover:bg-stone-100">2</a>
                <a href="#" class="rounded-lg px-3 py-1.5 text-sm text-stone-600 hover:bg-stone-100">3</a>
                <a href="#" class="rounded-lg px-3 py-1.5 text-sm font-medium text-stone-600 hover:bg-stone-100">Seguinte</a>
            </nav>
        </div>
    </div>

</x-layouts::admin>
