<div class="mt-4 flex flex-col gap-6">


    <a href="{{ route('home') }}" class=" text-center mx-auto">
        <svg fill="#fff" class="w-59  h-7  l flex  text-white">
            <use xlink:href="#casa-icon"></use>
        </svg>
    </a>

    <h1 class="text-casa-base text-center text-base">Por favor verifique su dirección de email para continuar.</h1>

    @if (session('status') == 'verification-link-sent')
        <p class="text-center font-medium  !text-green-600">
            Un nuevo email de verificación ha sido enviado a su correo.
        </p>
    @endif

    <div class="flex flex-col items-center justify-between space-y-3">
        <button wire:click="sendVerification"
            class="w-full bg-casa-base-2 py-1 px-3 rounded-full hover:bg-casa-base mt-2">
            Reenviar email de verificación
        </button>


        <button
            class="text-sm cursor-pointer border border-casa-base rounded-full px-3 py-1 mt-2 text-casa-base hover:bg-casa-black-h"
            wire:click="logout">
            Cerrar sesión </button>
    </div>
</div>
