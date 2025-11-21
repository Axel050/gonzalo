<x-modal class="lg:max-w-[80%] lg:w-auto ">

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} comitente
            </h2>

            <form
                class="bg-red-80  w-full  flex flex-col lg:grid lg:grid-cols-3 gap-2 lg:gap-x-12 llg:text-lg  text-base lg:px-10 px-2 text-gray-200  [&>div]:flex
                      [&>div]:flex-col  pt-4 max-h-[85vh] overflow-y-auto"
                wire:submit={{ $method }}>

                @if ($method == 'delete')
                    <div class="relative col-span-3 flex flex-col justify-center items-center">
                        <p class="text-center text-gray-600 lg:px-10 px-6 col-span-3"> Esta seguro de eliminar el
                            comitente
                            <strong>"{{ $nombre }} , {{ $apellido }}" </strong>?
                        </p>

                        @error('tieneContratos')
                            <div class ='flex items-center text-base text-red-600'>
                                <svg class="w-4 h-3.5 mr-1">
                                    <use xlink:href="#error-icon"></use>
                                </svg>
                                <p class="lg:max-w-80 leading-[12px]">
                                    {{ $message }}
                                </p>
                            </div>
                        @enderror

                    </div>
                @else
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



                    @if (!$owner)
                        <x-form-item label="Mail  (alias)" method="view" model="email_alias" wire:show="existe" />

                        <x-form-item label="Telefono (alias)" method="view" model="telefono_alias"
                            wire:show="existe" />
                    @endif

                    <x-form-item label="CUIT" :method="$method" model="CUIT" />


                    <x-form-item label="Mail" :method="$method" model="mail" />

                    <x-form-item label="Telefono" :method="$method" model="telefono" />


                    <x-form-item label="Domicilio" :method="$method" model="domicilio" />

                    <x-form-item label="Comision" :method="$method" model="comision" type="number" step="0.1"
                        min=0 />

                    <x-form-item label="Banco" :method="$method" model="banco" />

                    <x-form-item label="Numero de cuenta" :method="$method" model="numero_cuenta" />

                    <x-form-item label="CBU" :method="$method" model="CBU" />

                    <x-form-item label="Alias bancario" :method="$method" model="alias_bancario" />

                    <x-form-item-area label="Observaciones" :method="$method" model="observaciones" />




                    {{-- }}}}}}}}}}}}}}}}}}}}} --}}
                    <div class="items-start  lg:w-auto w-[85%] mx-auto">

                        <div class="pl-2">
                            <label class="w-full text-start text-gray-500 mt-2 leading-[16px] text-base">Foto</label>
                            <div class="mt-0.5">

                                @php
                                    $url =
                                        $foto && method_exists($foto, 'temporaryUrl')
                                            ? $foto->temporaryUrl()
                                            : ($foto
                                                ? Storage::url('imagenes/comitentes/' . $foto)
                                                : asset('004b.jpg'));
                                @endphp

                                <img src="{{ $url }}" alt="Previsualización"
                                    style="max-width: 100px; max-height: 100px; object-fit: cover; display: block;"
                                    class="mx-auto border">

                            </div>


                            <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
                                x-on:livewire-upload-finish="uploading = false"
                                x-on:livewire-upload-cancel="uploading = false"
                                x-on:livewire-upload-error="uploading = false"
                                x-on:livewire-upload-progress="progress = $event.detail.progress">


                                <input
                                    class=" mt-2  mr-2 text-gray-700 text-xs flex flex-col border border-cyan-800 rounded-xl pr-1 lg:w-60
                                                                  file:bg-gradient-to-r file:from-cyan-800 file:to-cyan-950 file:rounded-l-xl file:px-2 file:text-gray-100 file:text-xs
                                                                  hover:file:bg-gradient-to-l hover:file:from-cyan-900 hover:file:to-cyan-950 hover:file:text-white 
                                                                  cursor-pointer file:cursor-pointer disabled:cursor-not-allowed disabled:file:cursor-not-allowed"
                                    id="file_input" type="file" wire:model="foto" accept=".jpg, .jpeg, .png"
                                    @disabled($method === 'view') />


                                <div class="mb-1" style="height: 7px;">
                                    <x-input-error for="foto" style="font-size: 13px" />
                                </div>

                                <!-- Progress Bar -->
                                <div x-show="uploading" class="text-center">
                                    <progress max="100" x-bind:value="progress"></progress>
                                </div>

                            </div>



                        </div>
                    </div>

                    @if ($method == 'save')
                        <label class="w-fit text-start text-gray-500 leading-[16px] text-base  lg:m-2">
                            <input type="checkbox" wire:model="autorizados" class="mr-2" />Agregar autorizados
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
                        <button
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center ">
                            {{ $btnText }}
                        </button>
                    @endif


                </div>

                {{-- </div> --}}
            </form>

        </div>
    </div>
</x-modal>
