<div class="flex  flex-col  items-center  w-full  lg:min-h-[95vh] ">

    @if ($method)
        @livewire('register.modal-success', ['pas' => $pasP, 'mail' => $mailP, 'from' => 'adquirentes'])
        {{-- @livewire('register.modal-success', ['pas' => '12345678', 'mail' => 'test@example.com', 'from' => 'adquirentes']) --}}
    @endif





    <div class="flex flex-col bg-casa-base-2 lg:p-8 p-4 border border-casa-black text-casa-black  lg:mt-[50px] mt-8">

        <h1 class="lg:text-3xl text-lg   font-bold  mb-4 text-start">Registrate</h1>
        <h2 class="font-bold lg:text-xl text-sm">Adquirentes</h2>
        <p class="lg:text-xl text-sm">Registrate para poder ver las subastas.</p>


        <form wire:submit.prevent="save" class="grid lg:grid-cols-2  grid-cols-1 gap-y-2 gap-x-8 mt-5">

            {{-- <div class= 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Foto</label>
            <div class="relative w-full ">
                <input type="file" wire:model="foto"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="foto" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div> --}}

            <div class= 'items-start  lg:w-60 w-full lg:mx-auto  '>
                <label class="w-full text-start text-casa-black  text-base  font-bold">Nombre</label>
                <div class="relative w-full mt-1">
                    <input wire:model="nombre"
                        class = 'lg:w-60  rounded-full border border-casa-black w-full text-gray-800 px-3  text-sm  py-1 lg:text-lg'
                        placeholder="Marta " />
                    <x-input-error for="nombre" class="top-full py-0 leading-[12px] text-red-500" />
                </div>
            </div>

            <div class= 'items-start  lg:w-60 w-full lg:mx-auto  '>
                <label class="w-full text-start text-casa-black  text-base mb-1.5 font-bold">Apellido</label>
                <div class="relative w-full mt-1">
                    <input wire:model="apellido"
                        class = 'lg:w-60  rounded-full border border-casa-black w-full text-gray-800 px-3  text-sm  py-1 lg:text-lg'
                        placeholder="Diaz">
                    <x-input-error for="apellido" class="top-full py-0 leading-[12px] text-red-500" />
                </div>
            </div>

            <div class= 'items-start  lg:w-60 w-full lg:mx-auto  '>
                <label class="w-full text-start text-casa-black  text-base mb-1.5 font-bold">Mail</label>
                <div class="relative w-full ">
                    <input wire:model="mail"
                        class = 'lg:w-60  rounded-full border border-casa-black w-full text-gray-800 px-3  text-sm  py-1 lg:text-lg'
                        placeholder="test@mail.com" />
                    <x-input-error for="mail" class="top-full py-0 leading-[12px] text-red-500" />
                </div>
            </div>

            {{-- <div class= 'items-start  lg:w-60 w-full mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">CUIT</label>
            <div class="relative w-full ">
                <input wire:model="CUIT"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="CUIT" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div> --}}

            <div class= 'items-start  lg:w-60 w-full lg:mx-auto '>
                <label class="w-full text-start text-casa-black  text-base mb-1.5 font-bold">Teléfono</label>
                <div class="relative w-full ">
                    <input wire:model="telefono"
                        class = 'lg:w-60  rounded-full border border-casa-black w-full text-gray-800 px-3  text-sm  py-1 lg:text-lg'
                        placeholder="1144553344" />
                    <x-input-error for="telefono" class="top-full py-0 leading-[12px] text-red-500" />
                </div>
            </div>

            {{-- <div class= 'items-start  lg:w-60 w-full mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Domicilio</label>
            <div class="relative w-full ">
                <input wire:model="domicilio"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="domicilio" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div> --}}

            {{-- <div class= 'items-start  lg:w-60 w-full mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Banco</label>
            <div class="relative w-full ">
                <input wire:model="banco"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="banco" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-full mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Numero de cuenta</label>
            <div class="relative w-full ">
                <input wire:model="numero_cuenta"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="numero_cuenta" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-full mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">CBU</label>
            <div class="relative w-full ">
                <input wire:model="CBU"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="CBU" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-full mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Alias bancario</label>
            <div class="relative w-full ">
                <input wire:model="alias_bancario"
                    class = 'lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600' />
                <x-input-error for="alias_bancario" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div>

        <div class= 'items-start  lg:w-60 w-full mx-auto  mb-[-5px] '>
            <label class="w-full text-start text-gray-500 leading-[16px] text-base">Condicion Iva</label>
            <div class="relative w-full ">
                <select wire:model="condicion_iva_id"
                    class =" h-6 py-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm disabled:text-gray-600 disabled:bg-gray-300"
                    @disabled($method === 'view')>
                    <option value="">Elija condicion </option>
                    @foreach ($condiciones as $cond)
                        <option value={{ $cond->id }}>{{ $cond->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error for="condicion_iva_id" class="top-full py-0 leading-[12px] text-red-500" />
            </div>
        </div> --}}

            <div class= 'items-start  lg:w-60 w-full lg:mx-auto  '>
                <label class="w-full text-start text-casa-black  text-base mb-1.5 font-bold">Password</label>
                <div class="relative w-full ">
                    <input wire:model="password"
                        class = 'lg:w-60  rounded-full border border-casa-black w-full text-gray-800 px-3  text-sm  py-1 lg:text-lg'
                        placeholder="********" />
                    <x-input-error for="password" class="top-full py-0 leading-[12px] text-red-500" />
                </div>
            </div>


            <div class= 'items-start  lg:w-60 w-full lg:mx-auto '>
                <label class="w-full text-start text-casa-black  text-base mb-1.5 font-bold">Password
                    Confirmación</label>
                <div class="relative w-full ">
                    <input wire:model="password_confirmation"
                        class = 'lg:w-60  rounded-full border border-casa-black w-full text-gray-800 px-3  text-sm  py-1 lg:text-lg'
                        placeholder="********">
                    <x-input-error for="password_confirmation" class="top-full py-0 leading-[12px] text-red-500" />
                </div>
            </div>


            <div wire:ignore class="relative mt-3 lg:col-span-2  mx-auto ">
                <div id="g-recaptcha" class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.key') }}"
                    data-callback="onRecaptchaSuccess" data-expired-callback="onRecaptchaExpired"></div>
            </div>
            <x-input-error for="g_recaptcha_response"
                class="top-full py-0 leading-[12px] text-red-500 mb-2 mx-auto lg:col-span-2" />



            <button type="submit"
                class="bg-casa-black  text-casa-base mx-auto px-4 py-1 rounded-3xl mt-3 w-full lg:col-span-2 flex justify-between items-center lg:text-xl text-sm font-bold">

                <span>Enviar</span>

                <svg fill="#fff" class="lg:size-8 size-7 ">
                    <use xlink:href="#arrow-right"></use>
                </svg>


            </button>



        </form>


    </div>


    <div
        class="flex  lg:flex-row flex-col w-full lg:justify-between   text-casa-fondo-h pt-6 lg:pb-6 pb-10 lg:px-24 px-4  border-casa-base-2  bg-casa-black   text-start  lg:mt-auto mt-12">
        <p>&copy; 2025 Creado por casablanca.ar</p>
        <p>&copy; Diseñado por
            <a href="https://www.crabbystudio.com/" target="_blank" class="underline"> CrabbyStudio</a>
        </p>
    </div>


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
