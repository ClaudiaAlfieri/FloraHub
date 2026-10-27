<x-layouts::auth title="Recuperar palavra-passe">
    <div class="flex flex-col gap-6">
        <x-auth-header title="Recuperar palavra-passe" description="Indique o seu email para receber uma ligação de reposição da palavra-passe." />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                label="Email"
                type="email"
                required
                autofocus
                placeholder="voce@exemplo.com"
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                Enviar ligação de reposição
            </flux:button>
        </form>

        <p class="text-center text-sm text-stone-500">
            Ou regressar ao
            <a href="{{ route('login') }}" class="font-medium text-brand-700 hover:text-brand-800">início de sessão</a>
        </p>
    </div>
</x-layouts::auth>
