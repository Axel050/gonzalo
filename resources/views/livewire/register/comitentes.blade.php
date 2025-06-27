<div class="flex j flex-col ustify-center items-center h-lvh w-full ">

    @if ($method)
        @livewire('register.modal-success')
    @endif

    <h1 class="text-2xl text-white mx-auto font-bold mt-6 mb-4 ">Nuevo Comitente</h1>

    <a href="{{ route('home') }}"
        class="px-3 py-1 rounded-2xl bg-cyan-700 text-white absolute lg:top-5 lg:left-5 top-3 left-3 lg:text-base text-xs  ">Home</a>

    <form wire:submit.prevent="save" class="grid lg:grid-cols-2  grid-cols-1 gap-y-2 gap-x-8">

        {{-- <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Foto</label>
            <div class="relative w-full ">
                <input type="file" wire:model="foto"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="foto" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div> --}}

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Nombre</label>
            <div class="relative w-full ">
                <input wire:model="nombre"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="nombre" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Apellido</label>
            <div class="relative w-full ">
                <input wire:model="apellido"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="apellido" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Mail</label>
            <div class="relative w-full ">
                <input wire:model="mail"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="mail" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">CUIT</label>
            <div class="relative w-full ">
                <input wire:model="CUIT"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="CUIT" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Telefono</label>
            <div class="relative w-full ">
                <input wire:model="telefono"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="telefono" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Domicilio</label>
            <div class="relative w-full ">
                <input wire:model="domicilio"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="domicilio" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Banco</label>
            <div class="relative w-full ">
                <input wire:model="banco"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="banco" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Numero de cuenta</label>
            <div class="relative w-full ">
                <input wire:model="numero_cuenta"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="numero_cuenta" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">CBU</label>
            <div class="relative w-full ">
                <input wire:model="CBU"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="CBU" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Alias bancario</label>
            <div class="relative w-full ">
                <input wire:model="alias_bancario"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="alias_bancario" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Foto</label>
            <div class="relative w-full ">
                <input type="file" wire:model="foto"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="foto" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>


        <div wire:ignore class="relative mt-3 lg:col-span-2  mx-auto ">
            <div id="g-recaptcha" class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"
                data-callback="onRecaptchaSuccess" data-expired-callback="onRecaptchaExpired"></div>
        </div>
        <x-input-error for="g_recaptcha_response"
            class="top-full py-0 leading-[12px] text-red-500 mb-2 mx-auto lg:col-span-2" />

        <button type="submit"
            class="bg-cyan-700 text-white mx-auto px-4 py-1 rounded-3xl mt-3 lg:col-span-2 mb-4">Enviar</button>


    </form>

    @push('captcha')
        <script>
            function onRecaptchaSuccess(token) {
                @this.set('g_recaptcha_response', token);
            }

            function onRecaptchaExpired() {
                @this.set('g_recaptcha_response', '');
            }
        </script>
    @endpush


</div>
