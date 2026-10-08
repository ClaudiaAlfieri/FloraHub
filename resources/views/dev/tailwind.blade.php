<x-layouts::dev title="Tailwind">
    <div class="space-y-16">

        <h1 class="text-3xl font-bold tracking-tight text-stone-900">Laboratório de Tailwind</h1>

        <section class="space-y-6">
            <h2 class="text-xl font-semibold text-stone-900">Primeiro Teste</h2>
            <div class="flex items-center gap-4">
                <button>Sem classes</button>
                <button class="uppercase tracking-wider rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 cursor-pointer">
                    Com classes
                </button>
            </div>
        </section>

        {{-- As secções seguintes são acrescentadas aqui, uma a seguir à outra --}}
        <section class="space-y-6">
            <h2 class="text-xl font-semibold text-stone-900">3. Utility-first, espaçamento e tipografia</h2>

            <div class="flex flex-wrap items-start gap-6">
                <div class="bg-brand-100"><div class="bg-brand-300 p-2">p-2</div></div>
                <div class="bg-brand-100"><div class="bg-brand-300 p-4">p-4</div></div>
                <div class="bg-brand-100"><div class="bg-brand-300 p-8">p-8</div></div>
                <div class="bg-brand-100"><div class="bg-brand-300 px-8 py-2">px-8 py-2</div></div>
            </div>

            <div class="space-y-2">
                <div class="bg-stone-200 p-2">space-y-2</div>
                <div class="bg-stone-200 p-2">espaço entre cada filho</div>
                <div class="bg-stone-200 p-2">do contentor</div>
            </div>

            <div class="grid gap-4 md:grid-cols-3">
                <p class="text-left text-sm">text-sm text-left</p>
                <p class="text-center text-xl font-semibold uppercase tracking-widest">centrado</p>
                <p class="text-right text-3xl font-bold italic">text-3xl</p>
            </div>

            <p class="max-w-md truncate">truncate: um texto muito comprido que não cabe numa só linha e é cortado com reticências.</p>
        </section>

        <section class="space-y-6">
            <h2 class="text-xl font-semibold text-stone-900">4. Cores e caixas</h2>

            <div class="grid grid-cols-6 gap-1 text-center text-xs">
                <div class="bg-brand-100 py-4">100</div>
                <div class="bg-brand-300 py-4">300</div>
                <div class="bg-brand-500 py-4 text-white">500</div>
                <div class="bg-brand-600 py-4 text-white">600</div>
                <div class="bg-brand-800 py-4 text-white">800</div>
                <div class="bg-brand-950 py-4 text-white">950</div>
            </div>

            <div class="rounded-lg bg-brand-900 p-6">
                <div class="flex flex-wrap gap-3 text-sm font-medium">
                    <span class="rounded bg-white px-3 py-2 text-brand-900">bg-white</span>
                    <span class="rounded bg-white/50 px-3 py-2 text-brand-900">bg-white/50</span>
                    <span class="rounded bg-white/10 px-3 py-2 text-white">bg-white/10</span>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <div class="size-16 rounded-none bg-brand-600"></div>
                <div class="size-16 rounded-md bg-brand-600"></div>
                <div class="size-16 rounded-2xl bg-brand-600"></div>
                <div class="size-16 rounded-full bg-brand-600"></div>
            </div>

            <div class="grid gap-6 sm:grid-cols-3">
                <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-xs">shadow-xs</div>
                <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-md">shadow-md</div>
                <div class="rounded-xl border border-stone-200 bg-white p-4 shadow-xl">shadow-xl</div>
            </div>

            <div class="max-w-md rounded-xl border border-brand-200 bg-brand-50 p-6 shadow-sm ring-2 ring-brand-500">
                <h3 class="text-lg font-semibold text-stone-900">Rosaceae</h3>
                <p class="mt-1 text-sm text-stone-600">Este é o padrão base dos cartões do FloraHub.</p>
            </div>
        </section>

        <section class="space-y-6">
            <h2 class="text-xl font-semibold text-stone-900">5. Flexbox e Grid</h2>

            <p class="text-sm text-stone-600"><code>flex</code> põe os filhos em linha; <code>justify-between</code> + <code>items-center</code>:</p>
            <div class="flex h-20 items-center justify-between rounded-lg bg-stone-100 px-4">
                <span class="font-semibold">FloraHub</span>
                <span class="text-sm text-stone-600">Menu</span>
            </div>

            <p class="text-sm text-stone-600"><code>justify-*</code> (eixo principal) e <code>items-*</code> (eixo cruzado):</p>
            <div class="grid grid-cols-3 gap-2 text-sm">
                <div class="flex h-24 items-start justify-start rounded bg-stone-100 p-2"><span class="rounded bg-brand-300 px-3 py-1">start</span></div>
                <div class="flex h-24 items-center justify-center rounded bg-stone-100 p-2"><span class="rounded bg-brand-300 px-3 py-1">center</span></div>
                <div class="flex h-24 items-end justify-end rounded bg-stone-100 p-2"><span class="rounded bg-brand-300 px-3 py-1">end</span></div>
            </div>

            <p class="text-sm text-stone-600"><code>flex-col</code> e <code>flex-1</code> (um item ocupa o espaço restante):</p>
            <div class="flex gap-4">
                <div class="flex w-40 flex-col gap-2 rounded-lg bg-stone-100 p-2 text-sm">
                    <span class="rounded bg-brand-300 px-3 py-1">Item 1</span>
                    <span class="rounded bg-brand-300 px-3 py-1">Item 2</span>
                </div>
                <div class="flex flex-1 items-center rounded-lg bg-brand-100 px-4 text-sm">flex-1</div>
            </div>

            <p class="text-sm text-stone-600"><code>grid grid-cols-3</code> e <code>col-span-2</code>:</p>
            <div class="grid grid-cols-3 gap-4 text-center">
                <div class="col-span-2 rounded bg-brand-500 p-4 text-white">col-span-2</div>
                <div class="rounded bg-brand-300 p-4">1</div>
                <div class="rounded bg-brand-300 p-4">2</div>
                <div class="rounded bg-brand-300 p-4">3</div>
                <div class="rounded bg-brand-300 p-4">4</div>
                <div class="col-span-2 rounded bg-brand-500 p-4 text-white">col-span-2</div>
            </div>
        </section>

        <section class="space-y-6">
            <h2 class="text-xl font-semibold text-stone-900">6. Design responsivo</h2>

            <p class="rounded-lg bg-stone-900 px-4 py-3 font-mono text-sm text-white">
                Largura atual:
                <span class="sm:hidden">base (&lt; 640)</span>
                <span class="hidden sm:inline md:hidden">sm (≥ 640)</span>
                <span class="hidden md:inline lg:hidden">md (≥ 768)</span>
                <span class="hidden lg:inline xl:hidden">lg (≥ 1024)</span>
                <span class="hidden xl:inline">xl (≥ 1280)</span>
            </p>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-xl border border-stone-200 bg-white p-4">Cartão 1</div>
                <div class="rounded-xl border border-stone-200 bg-white p-4">Cartão 2</div>
                <div class="rounded-xl border border-stone-200 bg-white p-4">Cartão 3</div>
                <div class="rounded-xl border border-stone-200 bg-white p-4">Cartão 4</div>
            </div>

            <div class="flex flex-col gap-2 md:flex-row md:items-center md:justify-between">
                <p class="font-semibold">Coluna no telemóvel, linha a partir de md</p>
                <button class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white">Ação</button>
            </div>

            <p class="rounded-lg bg-amber-100 p-3 text-sm text-amber-800 md:hidden">Só em ecrãs pequenos (<code>md:hidden</code>).</p>
            <p class="hidden rounded-lg bg-sky-100 p-3 text-sm text-sky-800 md:block">Só a partir de md (<code>hidden md:block</code>).</p>
        </section>

        <section class="space-y-6">
            <h2 class="text-xl font-semibold text-stone-900">7. Estados, group e peer</h2>

            <div class="flex flex-wrap items-center gap-4">
                <button class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:shadow-lg active:translate-y-0 active:scale-95">
                    hover + active
                </button>
                <button class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white disabled:cursor-not-allowed disabled:opacity-50" disabled>
                    disabled
                </button>
                <input type="text" placeholder="Clicar aqui (focus)"
                       class="w-64 rounded-lg border border-stone-300 px-3 py-2 text-sm placeholder:text-stone-400 focus:border-brand-500 focus:outline-hidden focus:ring-2 focus:ring-brand-500/40">
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <a href="#" class="group block rounded-xl border border-stone-200 bg-white p-5 transition hover:border-brand-500 hover:shadow-md">
                    <h3 class="font-semibold text-stone-800 group-hover:text-brand-700">Rosaceae</h3>
                    <p class="mt-1 text-sm text-stone-500">Passar o rato no cartão.</p>
                    <span class="mt-3 inline-block text-sm font-medium text-brand-700 opacity-0 transition group-hover:opacity-100">Ver detalhes →</span>
                </a>

                <div class="space-y-3 rounded-xl border border-stone-200 bg-white p-5">
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" class="peer size-4 accent-brand-600">
                        <span class="text-stone-500 peer-checked:font-semibold peer-checked:text-brand-700">Aceito os termos</span>
                    </label>

                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border border-stone-200 p-3 text-sm has-checked:border-brand-500 has-checked:bg-brand-50">
                        <input type="radio" name="plano" class="accent-brand-600">
                        <span>has-checked: o contentor reage</span>
                    </label>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <h2 class="text-xl font-semibold text-stone-900">8. Escuro, arbitrários e armadilha</h2>

            <div class="dark">
                <div class="rounded-xl border border-stone-200 bg-white p-6 text-stone-800 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-100">
                    <p class="font-semibold">Dentro de &lt;div class="dark"&gt;</p>
                    <p class="text-sm text-stone-500 dark:text-stone-400">Classes <code>dark:</code> ativas porque um ascendente tem a classe <code>dark</code>.</p>
                </div>
            </div>

            <div class="grid grid-cols-[8rem_1fr_auto] gap-2 text-center text-sm">
                <div class="rounded bg-brand-300 p-2">8rem</div>
                <div class="rounded bg-brand-200 p-2">1fr</div>
                <div class="rounded bg-brand-300 p-2 text-[13px]">text-[13px]</div>
            </div>

            @php
                $color = 'slate';
                $isError = true;
            @endphp

            <div class="rounded-lg p-4 bg-{{ $color }}-100 text-{{ $color }}-800">ERRADO: classe montada em PHP</div>

            <div class="{{ $isError ? 'bg-rose-100 text-rose-800' : 'bg-brand-100 text-brand-800' }} rounded-lg p-4">
                CERTO: classes completas, escolhidas por uma condição
            </div>
        </section>


    </div>
</x-layouts::dev>
