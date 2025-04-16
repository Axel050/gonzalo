<x-modal>

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2
                class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg bg-yellow-800">
                Campos de <b>{{ $tipo->nombre }}</b>
            </h2>

            <div
                class="bg-red-80  w-full  flex flex-col lg:grid lg:grid-cols-2 gap-2 lg:gap-x-8 llg:text-lg  text-base lg:px-10 px-2 text-gray-200  [&>div]:flex
                      [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto">


                <div class="items-start  lg:w-auto w-[90%] mx-auto col-span-2">
                    <label class="w-full text-start text-gray-500 leading-[16px] text-base">Campo</label>
                    <div class="relative w-full">
                        <select wire:model="camp"
                            class =" h-6 py-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm px-2">
                            <option>Elija campos</option>
                            @foreach ($caracteristicas as $car)
                                <option value="{{ $car->nombre }}-/{{ $car->tipo }}-/{{ $car->id }}">
                                    {{ $car->nombre }} | tipo={{ $car->tipo }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="camp" class="absotule top-full py-0 leading-[12px] text-red-500" />
                    </div>
                </div>

                <div class="items-start  lg:w-auto w-[90%] mx-auto col-span-2 ">
                    <label
                        class="w-full text-start text-gray-500 leading-[16px] text-base g-red-300 flex items-center">Requerido
                        <input type="checkbox" wire:model="requerido" class="size-4 ml-2" />
                    </label>

                </div>

                <div class="col-span-2">
                    <button wire:click="add"
                        class="bg-yellow-600 hover:bg-yellow-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 w-3/4 mx-auto cursor-pointer">Agregar</button>
                </div>


                <table class="table-auto min-w-full divide-y  divide-gray-600 shadow-lg  col-span-2 mt-2  rounded-3xl">
                    <caption class="caption-top text-gray-700">
                        Listado de caracteristicas
                    </caption>
                    <thead>
                        <tr
                            class="bg-gray-400 relative font-bold divide-x-2 divide-gray-600  text-sm text-gray-900 text-center">
                            <th class="py-1">Nombre</th>
                            <th>Tipo</th>
                            <th>Requerido</th>
                            <th>Accion</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300 text-gray-600  text-sm rounded-full">

                        @foreach ($tempCampos as $index => $item)
                            <tr
                                class="bg-gray-100 relative font-bold divide-x-2 divide-gray-300 text-center [&>td]:lg:px-8 [&>td]:px-2 ">
                                <td class="py-1">{{ $item['nombre'] }}</td>
                                <td>{{ $item['tipo'] }} </td>
                                <td>{{ $item['pivot']['requerido'] ? 'Sí' : 'No' }}</td>
                                <td>
                                    <div class="flex justfy-end lg:gap-x-6 gap-x-3 text-white text-xs">
                                        <button
                                            class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0 bg-red-600 rounded-lg px-1 cursor-pointer"
                                            wire:click="quitar({{ $index }})">
                                            <svg width="20px" height="18px" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <g id="SVGRepo_iconCarrier">
                                                    <path
                                                        d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                                                        stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </g>
                                            </svg>
                                            <span class="hidden lg:block">Quitar</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>




                <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm lg:col-span-2">
                    <button type="button"
                        class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                        wire:click="$parent.$set('method',false)">
                        Cancelar
                    </button>


                    <button
                        class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                        wire:click="save">
                        Guardar
                    </button>



                </div>


            </div>

        </div>
    </div>
</x-modal>
