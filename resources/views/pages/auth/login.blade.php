<x-layouts::auth title="Iniciar sessão">
    <div class="flex flex-col gap-6">
        <x-auth-header title="Bem-vindo de volta" description="Inicie sessão para gerir a sua coleção de plantas." />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                label="Email"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="voce@exemplo.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    label="Palavra-passe"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        Esqueceu-se da palavra-passe?
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" label="Lembrar-me" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    Iniciar sessão
                </flux:button>
            </div>
        </form>

        <p class="text-center text-sm text-stone-500">
            Ainda não tem conta?
            <a href="{{ route('register') }}" class="font-medium text-brand-700 hover:text-brand-800">Criar uma</a>
        </p>

        @env('local')
            <div class="rounded-2xl border border-dashed border-amber-300 bg-amber-50 p-5">
                <span class="inline-flex items-center rounded-full bg-amber-200 px-2 py-0.5 text-[11px] font-semibold uppercase tracking-wide text-amber-900">Apenas em desenvolvimento</span>
                <h2 class="mt-3 text-sm font-semibold text-amber-900">Início de sessão rápido</h2>
                <p class="mt-1 text-xs text-amber-800">Entra com os utilizadores criados pelo <code>DevelopmentUserSeeder</code>.</p>
                <div class="mt-4 flex flex-col gap-2 sm:flex-row">
                    <form method="POST" action="{{ route('dev.login', 'user') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full rounded-lg border border-amber-300 bg-white px-4 py-2.5 text-sm font-semibold text-amber-900 hover:bg-amber-100">
                            Entrar como Utilizador
                        </button>
                    </form>
                    <form method="POST" action="{{ route('dev.login', 'admin') }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full rounded-lg border border-amber-300 bg-white px-4 py-2.5 text-sm font-semibold text-amber-900 hover:bg-amber-100">
                            Entrar como Administrador
                        </button>
                    </form>
                </div>
            </div>
        @endenv
    </div>
</x-layouts::auth>
