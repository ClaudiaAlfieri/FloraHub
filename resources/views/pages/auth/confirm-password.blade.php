<x-layouts::auth title="Confirmar palavra-passe">
    <div class="flex flex-col gap-6">
        <x-auth-header
            title="Confirmar palavra-passe"
            description="Esta é uma área segura da aplicação. Confirme a sua palavra-passe antes de continuar."
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="password"
                label="Palavra-passe"
                type="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
                viewable
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                Confirmar
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
