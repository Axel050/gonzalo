<x-modal>

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} caracteristica
            </h2>

            <form
                class="bg-red-80  w-full  flex flex-col gap-2 lg:text-lg  text-base lg:px-4 px-2 text-gray-200  [&>div]:flex
                            [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto"
                wire:submit={{ $method }}>

                @if ($method == 'delete')
                    <p class="text-center text-gray-600 lg:px-10 px-6"> Esta seguro de eliminar la caracteristica</p>
                    <p class="text-center text-gray-600"><strong>"{{ $caracteristica->nombre }}" </strong>?</p>
                @else
                    <x-form-item label="Nombre" model="nombre" />

                    <x-form-item-sel label="Tipo" model="tipo" live="true">
                        <option value="text">Texto</option>
                        <option value="file">Archivo</option>
                        <option value="select">Desplegable</option>
                    </x-form-item-sel>


                    @if ($tipo == 'select')
                        <div class="items-start  lg:w-60 w-[85%] mx-auto  relative">

                            <div class="flex  justify-around w-full ">
                                <label class="block text-sm font-medium text-gray-700 ">
                                    Opciones
                                </label>
                            </div>

                            <div class=" w-full">
                                @foreach ($opciones as $index => $opcion)
                                    <div class="flex items-center mt-2 bg-blue-200 w-full">
                                        <input type="text" wire:model.live="opciones.{{ $index }}"
                                            class=" lg:w-60 w-full h-6 rounded-md border border-gray-400  text-gray-500 pl-2 text-sm bg-gray-100 "
                                            placeholder="Opción {{ $index + 1 }}">

                                        <button type="button" wire:click="removeOpcion({{ $index }})"
                                            class=" hover:bg-red-700 bg-red-500 rounded-lg px-1 py-0.5 ml-2 lg:absolute right-[-40px] "
                                            title="quitar">
                                            <svg class="size-5 mr-0.5">
                                                <use xlink:href="#eliminar"></use>
                                            </svg>
                                        </button>

                                    </div>

                                    <x-input-error for="opciones.{{ $index }}"
                                        class="top-full py-0 leading-[12px] text-red-500" />
                                @endforeach
                                <div class="flex w-full">
                                    <button type="button" wire:click="addOpcion"
                                        class="bg-cyan-700 text-white px-2  mt-1 h-5  text-xs rounded-lg mx-auto hover:bg-cyan-900">
                                        Agregar Opción
                                    </button>
                                </div>
                            </div>

                        </div>
                    @endif


                @endif


                @error('tieneDatos')
                    <div class ='flex items-center !flex-row justify-center text-base text-red-600  '>
                        <svg class="w-4 h-3.5 mr-1">
                            <use xlink:href="#error-icon"></use>
                        </svg>
                        {{ $message }}
                    </div>
                @enderror




                <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm">
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


            </form>

        </div>
    </div>
</x-modal>
