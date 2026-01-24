 <div class="flex flex-col gap-6">


     <a href="{{ route('home') }}" class=" over:scale-105 bg-ed-200  text-white">
         <svg fill="#fff" class="w-59 h-10 mx-auto">
             <use xlink:href="#casa-icon"></use>
         </svg>
     </a>

     <h2 class="text-casa-base-2 text-2xl text-center">Clave ovidada </h2>
     <h3 class="text-casa-base-2 text-lg text-center">Ingresa tu email y recibiras un mail para crear una
         nueva clave </h3>


     <!-- Session Status -->
     <x-auth-session-status class="text-center" :status="session('status')" />

     <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
         <!-- Email Address -->
         <flux:input wire:model="email" :label="__('Email ')" type="email" required autofocus
             placeholder="email@ejemplo.com" />

         <button type="submit" class="bg-casa-base w-full py-2 rounded-lg hover:bg-casa-base-2 font-bold">Enviar
             email</button>
     </form>

     <div class="space-x-1 text-center text-sm text-zinc-400">

         <a href="{{ route('login') }}" wire:navigate class="border border-zinc-400 px-6 py-1 rounded-xl">Volver al Log
             in </a>


     </div>


 </div>
