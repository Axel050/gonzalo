<div class="flex flex-col gap-6 ">

    <x-auth-header :title="__('Ingresa en tu cuenta')" :description="__('')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email')" type="email" required autofocus autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <div class="relative">
            <flux:input wire:model="password" :label="__('Password')" type="password" required
                autocomplete="current-password" :placeholder="__('Password')" />

            {{-- @if (Route::has('password.request'))
                <flux:link class="absolute right-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Ovida your password?') }}
                </flux:link>
            @endif --}}
        </div>

        <!-- Remember Me -->
        <div class=" z-10">
            <flux:checkbox wire:model="remember" :label="__('Recordarme')" />
        </div>

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Ingresar') }}</flux:button>
        </div>
    </form>

    @if (Route::has('register'))
        {{-- <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400 z-10">
            {{ __('No tienes cuenta?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Registrarme') }}</flux:link>
        </div> --}}
    @endif
</div>
