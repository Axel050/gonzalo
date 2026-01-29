<div class="flex flex-col gap-6">


    <a href="{{ route('home') }}" class=" over:scale-105 bg-ed-200  text-white">
        <svg fill="#fff" class="w-59 h-10 mx-auto">
            <use xlink:href="#casa-icon"></use>
        </svg>
    </a>

    <h2 class="text-casa-base-2 text-2xl text-center">Crea tu nueva clave</h2>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="resetPassword" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

        <!-- Password -->
        <flux:input wire:model="password" :label="__('Password')" type="password" required autocomplete="new-password"
            :placeholder="__('Password')" viewable />

        <!-- Confirm Password -->
        <flux:input wire:model="password_confirmation" :label="__('Confirmar password')" type="password" required
            autocomplete="new-password" :placeholder="__('Confirmar password')" viewable />

        <div class="flex items-center justify-end">
            {{-- <flux:button type="submit" variant="primary" class="w-full">
                {{ __('Reset password') }}
            </flux:button> --}}
            <button type="submit" class="bg-casa-base w-full py-2 rounded-lg hover:bg-casa-base-2 font-bold">Guardar
                clave</button>

        </div>
    </form>
</div>
