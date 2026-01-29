<div class="flex  flex-col  items-center w-full   px-3">

    <div
        class="flex flex-col bg-casa-base-2 lg:p-8 lg:pb-10 p-4 pb-7 border border-casa-black text-casa-black  lg:mt-[50px] mt-8  lg:mb-8 relative md:w-fit w-full ">

        <h1 class="lg:text-3xl text-xl   font-bold  md:mb-4 mb-3 text-start">Tu perfil</h1>
        <p class="lg:text-xl text-base">Gestiona la información de tu cuenta.</p>




        <form wire:submit.prevent="edit"
            class="grid  md:grid-cols-2 lg:grid-cols-3  grid-cols-1 gap-y-2 md:gap-x-8 gap-x-2 mt-5   pb-4">



            <x-front.input-perfil label="Mail" model="mail" :disabled="true" />

            <x-front.input-perfil label="Nombre" model="nombre" :disabled="!$editing" />
            <x-front.input-perfil label="Apellido" model="apellido" :disabled="!$editing" />

            <x-front.input-perfil label="Teléfono" model="telefono" :disabled="!$editing" />




            <x-front.input-perfil label="CUIT" model="CUIT" :disabled="!$editing" />

            <div class= 'items-start  lg:w-64 w-full mx-auto  mb-[-5px] '>
                <label class="w-full text-start text-casa-black leading-[16px] text-base">Condicion Iva</label>
                <div class="relative w-full mt-1">
                    <select wire:model="condicion_iva_id"
                        class ="md:h-8.5  h-8 py-1 rounded-full border border-casa-black lg:w-64 w-full disabled:text-gray-600 text-gray-800  pl-2  pr-5 md:text-md text-sm  disabled:cursor-not-allowed disabled:bg-gray-100 bg-casa-base disabled:opacity-70 "
                        {{ !$editing ? 'disabled' : '' }}>
                        <option value="">Elija condicion </option>
                        @foreach ($condiciones as $cond)
                            <option value={{ $cond->id }}>{{ $cond->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="condicion_iva_id" class="top-full py-0 leading-[12px] text-red-500" />
                </div>
            </div>



            <x-front.input-perfil label="Domicilio" model="domicilio" :disabled="!$editing" />
            <x-front.input-perfil label="Domicilio envío" model="domicilio_envio" :disabled="!$editing" />
            <x-front.input-perfil label="Banco" model="banco" :disabled="!$editing" />
            <x-front.input-perfil label="Número de cuenta" model="numero_cuenta" :disabled="!$editing" />
            <x-front.input-perfil label="CBU" model="CBU" :disabled="!$editing" />
            <x-front.input-perfil label="Alias bancario" model="alias_bancario" :disabled="!$editing" />



            {{-- <div class= 'items-start  lg:w-60 w-full lg:mx-auto  '>
                <label class="w-full text-start text-casa-black  text-base mb-1.5 font-bold">Foto</label>
                <div class="relative w-full ">
                    <input type="file" wire:model="foto"
                        class = 'lg:w-60  rounded-full border border-casa-black w-full text-gray-800 px-3  text-sm  py-1 '
                        placeholder="3022211550111" />
                    <x-input-error for="foto" class="top-full py-0 leading-[12px] text-red-500" />
                </div>
            </div> --}}





            @if (!$editing)
                <button type="button" wire:click="$set('editing', true)"
                    class="bg-casa-black text-casa-base px-6 py-2 rounded-full font-bold flex items-center gap-2 hover:opacity-80 transition mx-auto md:grid-cols-2 lg:col-span-3 md:mt-8 mt-5">
                    <svg class="w-5 h-5  mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Editar Perfil
                </button>
            @else
                <button type="submit"
                    class="bg-casa-black text-casa-base px-6 py-2 rounded-full font-bold flex items-center gap-2 hover:opacity-80 transition mx-auto md:grid-cols-2 lg:col-span-3 md:mt-8 mt-5">

                    <span>Guardar cambios</span>

                    <svg fill="#fff" class="lg:size-7 size-6  ml-8 ">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </button>
            @endif

            <div x-data="{ show: false, message: '' }"
                x-on:show-message.window="
        message = $event.detail.message; 
        show = true; 
        setTimeout(() => { show = false }, 5000);
        console.log('aedad')
    "
                x-show="show" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-90"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="md:px-6 px-2 md:py-2 py-1.5 md:text-base text-sm rounded-full bg-green-100 border border-green-500 text-green-700  text-center font-bold absolute bottom-1  left-1/2 transform -translate-x-1/2  text-nowrap "
                style="display: none;">
                <span x-text="message"></span>
            </div>




        </form>
    </div>








</div>
