<x-layouts::auth :title="__('Recover password')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Recover password')" :description="__('Enter your email to receive a password reset link.')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                label="{{ __('Email') }}"
                type="email"
                required
                autofocus
                placeholder="you@example.com"
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="email-password-reset-link-button">
                {{ __('Send reset link') }}
            </flux:button>
        </form>

        <p class="text-center text-sm text-stone-500">
            {{ __('Or return to') }}
            <a href="{{ route('login') }}" class="font-medium text-brand-700 hover:text-brand-800">{{ __('log in') }}</a>
        </p>
    </div>
</x-layouts::auth>
