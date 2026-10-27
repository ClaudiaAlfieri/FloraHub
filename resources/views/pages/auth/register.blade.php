<x-layouts::auth title="Criar conta">
    <div class="flex flex-col gap-6">
        <x-auth-header title="Crie a sua conta" description="Comece hoje a acompanhar a sua coleção de plantas." />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                label="Nome"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                placeholder="Nome completo"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                label="Email"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="voce@exemplo.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                label="Palavra-passe"
                type="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                label="Confirmar palavra-passe"
                type="password"
                required
                autocomplete="new-password"
                placeholder="••••••••"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    Criar conta
                </flux:button>
            </div>
        </form>

        <p class="text-center text-sm text-stone-500">
            Já tem conta?
            <a href="{{ route('login') }}" class="font-medium text-brand-700 hover:text-brand-800">Iniciar sessão</a>
        </p>
    </div>
</x-layouts::auth>
