<x-layouts::auth title="Verificar email">
    <div class="flex flex-col gap-6">
        <x-auth-header title="Verificar email" description="Confirme o seu endereço de email clicando na ligação que acabámos de lhe enviar." />

        @if (session('status') == 'verification-link-sent')
            <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
                Foi enviada uma nova ligação de verificação para o email que indicou no registo.
            </flux:text>
        @endif

        <div class="flex flex-col items-center justify-between space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <flux:button type="submit" variant="primary" class="w-full">
                    Reenviar email de verificação
                </flux:button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button variant="ghost" type="submit" class="text-sm cursor-pointer" data-test="logout-button">
                    Terminar sessão
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::auth>
