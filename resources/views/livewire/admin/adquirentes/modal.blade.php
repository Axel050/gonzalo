<x-modal class="lg:max-w-[80%] lg:w-auto ">

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} adquirente
            </h2>

            <div
                class=" w-full  flex flex-col lg:grid lg:grid-cols-3 gap-2 lg:gap-x-12 llg:text-lg  text-base lg:px-10 px-2 text-gray-200  [&>div]:flex
                      [&>div]:flex-col   pt-4 max-h-[85vh] overflow-y-auto">

                @if ($method == 'delete')

                    <div class="relative col-span-3 flex flex-col justify-center items-center">

                        <p class="text-center text-gray-600 lg:px-10 px-6 col-span-3"> Esta seguro de eliminar el
                            adquirente
                            <strong>"{{ $nombre }} , {{ $apellido }}" </strong>?
                        </p>


                        @error('tieneDatos')
                            <div class ='flex items-center text-base text-red-600  '>

                                <svg class="w-4 h-3.5 mr-1">
                                    <use xlink:href="#error-icon"></use>
                                </svg>
                                <p class="lg:max-w-100 leading-[12px]">
                                    {{ $message }}
                                </p>
                            </div>
                        @enderror

                    </div>
                @else
                    <div class="col-span-3">
                        <x-form-item-foto label="" :method="$method" model="foto" :foto="$foto" w="150"
                            h="150" folder="adquirentes" />

                    </div>
                    <x-form-item label="Nombre" :method="$method" model="nombre" />

                    <x-form-item label="Apellido" :method="$method" model="apellido" />


                    <div class="items-start lg:w-auto w-[85%] mx-auto " x-data="{ existe: false }">
                        <div class="flex w-full justify-between bg-ed-100 py-0 items-end">
                            <label class="text-start text-gray-500 leading-[16px] text-base">Alias</label>
                            <label class="text-gray-500 bgred-100 py-0 leading-[16px]">
                                Existe
                                <input type="checkbox" wire:model="existe" wire:change="$set('alias_id','')"
                                    @disabled($method === 'view') />
                            </label>
                        </div>
                        <div class="relative w-full">
                            <input
                                class="lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 p-2 text-sm bg-gray-100 disabled:text-gray-600 disabled:bg-gray-300"
                                wire:model="alias_id" wire:show="!existe" @disabled($method === 'view') />
                            <select
                                class="h-6 py-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm disabled:text-gray-600 disabled:bg-gray-300"
                                wire:model.live="alias_id" wire:show="existe" @disabled($method === 'view')>
                                <option value="">Seleccione alias</option>
                                @foreach ($aliases as $alias)
                                    <option value={{ $alias->id }}>{{ $alias->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-input-error for="alias_id" />

                    </div>


                    {{-- <x-form-item label="Alias" :method="$method" model="alias" /> --}}


                    @if (!$owner)
                        <x-form-item label="Mail  (alias)" method="view" model="email_alias" wire:show="existe" />

                        <x-form-item label="Telefono (alias)" method="view" model="telefono_alias"
                            wire:show="existe" />
                    @endif

                    <x-form-item label="CUIT" :method="$method" model="CUIT" />
                    <x-form-item label="Mail  (user)" :method="$method" model="mail" />

                    <x-form-item label="Telefono" :method="$method" model="telefono" />


                    <x-form-item label="Domicilio real" :method="$method" model="domicilio" />

                    <x-form-item label="Domicilio envio" :method="$method" model="domicilio_envio" />

                    <x-form-item label="Comision" :method="$method" model="comision" type="number" step="0.1"
                        min=0 />

                    <div class=" items-start  lg:w-auto w-[85%] mx-auto ">
                        <label class="w-full text-start text-gray-500  leading-[16px] text-base">Estado</label>
                        <div class="relative w-full">
                            <select wire:model="estado_id"
                                class =" h-6 py-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm disabled:text-gray-600 disabled:bg-gray-300"
                                @disabled($method === 'view')>
                                <option>Elija estado </option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado->id }}"> {{ $estado->nombre }}</option>
                                @endforeach

                            </select>
                            <x-input-error for="estado_id" class="absotule top-full py-0 leading-[12px] text-red-500" />
                        </div>
                    </div>


                    <div class=" items-start  lg:w-auto w-[85%] mx-auto ">
                        <label class="w-full text-start text-gray-500  leading-[16px] text-base">Condicion
                            IVA</label>
                        <div class="relative w-full">
                            <select wire:model="condicion_iva_id"
                                class =" h-6 py-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm disabled:text-gray-600 disabled:bg-gray-300"
                                @disabled($method === 'view')>
                                <option>Elija condicion </option>
                                @foreach ($condiciones as $cond)
                                    <option value={{ $cond->id }}>{{ $cond->nombre }}</option>
                                @endforeach

                            </select>
                            <x-input-error for="condicion_iva_id"
                                class="absotule top-full py-0 leading-[12px] text-red-500" />
                        </div>
                    </div>

                    <x-form-item label="Banco" :method="$method" model="banco" />
                    <x-form-item label="Alias bancario" :method="$method" model="alias_bancario" />
                    <x-form-item label="CBU" :method="$method" model="CBU" />
                    <x-form-item label="Numero de cuenta" :method="$method" model="numero_cuenta" />

                    @if ($method != 'view')
                        <div class="items-start  lg:w-auto w-[85%] mx-auto">
                            <div class="flex justify-between w-full">
                                <label class="w-full text-start text-gray-500 leading-[16px] text-base">Password
                                </label>
                                <button type="button" wire:click="$toggle('ver')" class="cursor-pointer pr-1">

                                    <svg width="20px" height="20px" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" wire:show="!ver">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M0 8L3.07945 4.30466C4.29638 2.84434 6.09909 2 8 2C9.90091 2 11.7036 2.84434 12.9206 4.30466L16 8L12.9206 11.6953C11.7036 13.1557 9.90091 14 8 14C6.09909 14 4.29638 13.1557 3.07945 11.6953L0 8ZM8 11C9.65685 11 11 9.65685 11 8C11 6.34315 9.65685 5 8 5C6.34315 5 5 6.34315 5 8C5 9.65685 6.34315 11 8 11Z"
                                            fill="#6a7282" />
                                    </svg>

                                    <svg width="20px" height="20px" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" wire:show="ver">
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                            d="M16 16H13L10.8368 13.3376C9.96488 13.7682 8.99592 14 8 14C6.09909 14 4.29638 13.1557 3.07945 11.6953L0 8L3.07945 4.30466C3.14989 4.22013 3.22229 4.13767 3.29656 4.05731L0 0H3L16 16ZM5.35254 6.58774C5.12755 7.00862 5 7.48941 5 8C5 9.65685 6.34315 11 8 11C8.29178 11 8.57383 10.9583 8.84053 10.8807L5.35254 6.58774Z"
                                            fill="#6a7282" />
                                        <path
                                            d="M16 8L14.2278 10.1266L7.63351 2.01048C7.75518 2.00351 7.87739 2 8 2C9.90091 2 11.7036 2.84434 12.9206 4.30466L16 8Z"
                                            fill="#6a7282" />
                                    </svg>


                                </button>
                            </div>

                            <div class="relative w-full">
                                <input type={{ $typePass }} wire:model="password"
                                    class="lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 bg-gray-100 pl-2 text-sm"
                                    @disabled($method === 'view') name="new-password" autocomplete="new-password" />

                                <x-input-error for="password"
                                    class="absotule top-full py-0 leading-[12px] text-red-500" />
                            </div>
                        </div>

                        <x-form-item label="Repita contraseña" :method="$method" model="password_confirmation"
                            type="password" />
                    @endif


                    @if ($method == 'save')
                        <label class="w-fit text-start text-gray-500 leading-[16px] text-base  lg:m-2">
                            <input type="checkbox" wire:model="autorizados" class="mr-2" />Agregar
                            autorizados
                        </label>
                    @endif




                @endif

                <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm lg:col-span-3">

                    <button type="button"
                        class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                        wire:click="$parent.$set('method',false)">
                        Cancelar
                    </button>

                    @if ($method != 'view')
                        <button wire:click="{{ $method }}"
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center ">
                            {{ $btnText }}
                        </button>
                    @endif


                </div>


            </div>

        </div>
    </div>


</x-modal>
