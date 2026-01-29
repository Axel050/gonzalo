<div class="flex flex-col gap-6  ">

    <a href="{{ route('home') }}" class=" over:scale-105 bg-ed-200  text-white">
        <svg fill="#fff" class="w-59 h-12 mx-auto">
            <use xlink:href="#casa-icon"></use>
        </svg>
    </a>

    {{-- <x-auth-header :title="__('Ingresa en tu cuenta')" :description="__('')" /> --}}
    <h2 class="text-casa-base-2 text-2xl text-start">Ingresa a tu cuenta</h2>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email')" type="email" required autofocus autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <div class="relative">
            <flux:input wire:model="password" :label="__('Password')" type="password" required
                autocomplete="current-password" :placeholder="__('Password')" viewable />

            @if (Route::has('password.request'))
                <flux:link class="absolute right-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                    {{ __('Olvidaste tu password?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
        <div class=" z-10 text-casa-base-2  flex items-center">
            {{-- <flux:checkbox wire:model="remember" :label="__('Recordarme')" /> --}}
            <input type="checkbox" wire:model="remenber" class="size-5 mr-2" />
            <label>Recordarme</label>
        </div>


        {{-- <flux:button variant="primary" type="submit" class="w-full">{{ __('Ingresar') }}</flux:button> --}}
        <button type="submit" class="bg-casa-base w-full py-2 rounded-lg hover:bg-casa-base-2">Ingresar</button>



        <a href="{{ route('adquirentes.create') }}"
            class="w-full text-center py-1 text-sm bg-casa-black border rounded-lg border-casa-base text-casa-base hover:bg-casa-black-h">¿
            Primera vez ?</a>

    </form>

    @if (Route::has('register'))
        {{-- <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400 z-10">
            {{ __('No tienes cuenta?') }}
            <flux:link :href="route('register')" wire:navigate>{{ __('Registrarme') }}</flux:link>
        </div> --}}
    @endif
</div>
