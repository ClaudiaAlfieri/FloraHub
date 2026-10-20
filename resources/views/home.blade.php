<x-layouts::public title="Início">

    <!-- Destaque principal -->
    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <div class="grid items-center gap-12 lg:grid-cols-2">
            <div>
                <span class="inline-flex items-center rounded-full bg-brand-100 px-3 py-1 text-xs font-medium text-brand-800">Catálogo botânico e cuidado pessoal de plantas</span>
                <h1 class="mt-5 text-4xl font-semibold tracking-tight text-stone-900 sm:text-5xl">
                    Cultive a sua coleção de plantas com confiança.
                </h1>
                <p class="mt-5 max-w-xl text-lg text-stone-600">
                    O FloraHub reúne um catálogo botânico de espécies e um registo pessoal de plantas,
                    para que saiba sempre do que as suas plantas precisam e quando foram cuidadas pela última vez.
                </p>
                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="#" class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-5 py-3 text-sm font-semibold text-white hover:bg-brand-700">
                        Explorar o catálogo
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-stone-300 bg-white px-5 py-3 text-sm font-semibold text-stone-700 hover:bg-stone-50">
                        Criar conta gratuita
                    </a>
                </div>
                <dl class="mt-10 grid grid-cols-3 gap-6 border-t border-stone-200 pt-8">
                    <div>
                        <dt class="text-2xl font-semibold text-stone-900">1200+</dt>
                        <dd class="text-sm text-stone-500">espécies catalogadas</dd>
                    </div>
                    <div>
                        <dt class="text-2xl font-semibold text-stone-900">8</dt>
                        <dd class="text-sm text-stone-500">famílias botânicas</dd>
                    </div>
                    <div>
                        <dt class="text-2xl font-semibold text-stone-900">Grátis</dt>
                        <dd class="text-sm text-stone-500">registo pessoal de plantas</dd>
                    </div>
                </dl>
            </div>

            <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-3 rounded-2xl border border-stone-200 bg-stone-100 text-stone-400">
                <svg class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25zM10.5 8.25h.008v.008h-.008V8.25z"/></svg>
                <span class="text-xs">images/hero-plants-placeholder.jpg</span>
            </div>
        </div>
    </section>

    <!-- Espécies em destaque -->
    <section class="border-t border-stone-200 bg-white py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-semibold tracking-tight text-stone-900">Espécies em destaque</h2>
                    <p class="mt-1 text-stone-500">Algumas das plantas mais populares do catálogo para começar.</p>
                </div>
                <a href="#" class="hidden text-sm font-medium text-brand-700 hover:text-brand-800 sm:inline-flex">Ver todas as espécies →</a>
            </div>

            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <a href="#" class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-md">
                    <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-2 bg-stone-100 text-stone-400">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25zM10.5 8.25h.008v.008h-.008V8.25z"/></svg>
                        <span class="text-[11px]">images/species-placeholder.jpg</span>
                    </div>
                    <div class="flex flex-1 flex-col gap-2 p-5">
                        <span class="inline-flex w-fit items-center rounded-full bg-brand-100 px-2.5 py-0.5 text-xs font-medium text-brand-800">Araceae</span>
                        <h3 class="text-base font-semibold text-stone-900">Monstera deliciosa</h3>
                        <p class="text-sm italic text-stone-500">Costela-de-adão</p>
                    </div>
                </a>
                <a href="#" class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-md">
                    <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-2 bg-stone-100 text-stone-400">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25zM10.5 8.25h.008v.008h-.008V8.25z"/></svg>
                        <span class="text-[11px]">images/species-placeholder.jpg</span>
                    </div>
                    <div class="flex flex-1 flex-col gap-2 p-5">
                        <span class="inline-flex w-fit items-center rounded-full bg-brand-100 px-2.5 py-0.5 text-xs font-medium text-brand-800">Moraceae</span>
                        <h3 class="text-base font-semibold text-stone-900">Ficus lyrata</h3>
                        <p class="text-sm italic text-stone-500">Figueira-lira</p>
                    </div>
                </a>
                <a href="#" class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-md">
                    <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-2 bg-stone-100 text-stone-400">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25zM10.5 8.25h.008v.008h-.008V8.25z"/></svg>
                        <span class="text-[11px]">images/species-placeholder.jpg</span>
                    </div>
                    <div class="flex flex-1 flex-col gap-2 p-5">
                        <span class="inline-flex w-fit items-center rounded-full bg-brand-100 px-2.5 py-0.5 text-xs font-medium text-brand-800">Asparagaceae</span>
                        <h3 class="text-base font-semibold text-stone-900">Sansevieria trifasciata</h3>
                        <p class="text-sm italic text-stone-500">Espada-de-são-jorge</p>
                    </div>
                </a>
                <a href="#" class="group flex flex-col overflow-hidden rounded-2xl border border-stone-200 bg-white shadow-sm transition hover:-translate-y-0.5 hover:border-brand-200 hover:shadow-md">
                    <div class="flex aspect-[4/3] w-full flex-col items-center justify-center gap-2 bg-stone-100 text-stone-400">
                        <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 8.25V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18V8.25A2.25 2.25 0 0018.75 6H5.25A2.25 2.25 0 003 8.25zM10.5 8.25h.008v.008h-.008V8.25z"/></svg>
                        <span class="text-[11px]">images/species-placeholder.jpg</span>
                    </div>
                    <div class="flex flex-1 flex-col gap-2 p-5">
                        <span class="inline-flex w-fit items-center rounded-full bg-brand-100 px-2.5 py-0.5 text-xs font-medium text-brand-800">Araceae</span>
                        <h3 class="text-base font-semibold text-stone-900">Zamioculcas zamiifolia</h3>
                        <p class="text-sm italic text-stone-500">Zamioculca</p>
                    </div>
                </a>
            </div>
            <a href="#" class="mt-6 inline-flex text-sm font-medium text-brand-700 hover:text-brand-800 sm:hidden">Ver todas as espécies →</a>
        </div>
    </section>

    <!-- Funcionalidades -->
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold tracking-tight text-stone-900">Tudo o que a sua coleção precisa</h2>
            <div class="mt-8 grid gap-6 sm:grid-cols-3">
                <div class="rounded-2xl border border-stone-200 bg-white p-6">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-100 text-brand-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        </span>
                    <h3 class="mt-4 text-base font-semibold text-stone-900">Explorar o catálogo</h3>
                    <p class="mt-2 text-sm text-stone-600">Pesquise e filtre espécies botânicas por nome, família e características de cuidado.</p>
                </div>
                <div class="rounded-2xl border border-stone-200 bg-white p-6">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-100 text-brand-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21C7 21 3 17 3 11.5 3 6 7.5 3 12 3c1 4 5 5.5 5 10.5S15 21 12 21Z"/></svg>
                        </span>
                    <h3 class="mt-4 text-base font-semibold text-stone-900">Acompanhe a sua coleção</h3>
                    <p class="mt-2 text-sm text-stone-600">Mantenha todas as suas plantas organizadas, com fotografias e um histórico de cuidados.</p>
                </div>
                <div class="rounded-2xl border border-stone-200 bg-white p-6">
                        <span class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-100 text-brand-700">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        </span>
                    <h3 class="mt-4 text-base font-semibold text-stone-900">Nunca perca uma tarefa de cuidado</h3>
                    <p class="mt-2 text-sm text-stone-600">Defina lembretes para regas, fertilizações e podas, e veja o que está pendente.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Chamada para ação -->
    <section class="bg-brand-700">
        <div class="mx-auto max-w-7xl px-4 py-16 text-center sm:px-6 lg:px-8">
            <h2 class="text-2xl font-semibold tracking-tight text-white sm:text-3xl">Pronto para fazer crescer a sua coleção?</h2>
            <p class="mx-auto mt-3 max-w-xl text-brand-100">Crie uma conta gratuita e comece a acompanhar as suas plantas em minutos.</p>
            <a href="{{ route('register') }}" class="mt-7 inline-flex items-center justify-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-semibold text-brand-800 hover:bg-brand-50">
                Criar conta gratuita
            </a>
        </div>
    </section>

</x-layouts::public>
