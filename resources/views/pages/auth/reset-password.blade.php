<x-layouts::auth title="Repor palavra-passe">
    <div class="flex flex-col gap-6">
        <x-auth-header title="Repor palavra-passe" description="Indique a sua nova palavra-passe." />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <flux:input
                name="email"
                value="{{ request('email') }}"
                label="Email"
                type="email"
                required
                autocomplete="email"
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
                <flux:button type="submit" variant="primary" class="w-full" data-test="reset-password-button">
                    Repor palavra-passe
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts::auth>
