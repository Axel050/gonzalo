<x-modal>

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">



            <h2
                class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg bg-cyan-800 lg:px-6">
                Permisos para el rol <strong>{{ $rol->name }}</strong>
            </h2>

            <div class="lg:w-fit w-full overflow-x-auto lg:mx-8 ">
                <table
                    class=" lg:rounded-lg divide-y divide-gray-400 bg-white border lg:mb-4 mb-2 mt-2 shadow-lg mx-auto">

                    <thead>
                        <tr
                            class="bg-gray-100 relative text-gray-600 font-bold divide-x-2 [&>th]:lg:px-10 [&>th]:px-4  [&>th]:text-start text-sm">
                            <th scope="col" class="py-1.5 ">Modulo</th>
                            <th scope="col" class="py-1.5 ">Ver</th>
                            {{-- <th scope="col" class="mx-">Crear</th> --}}
                            {{-- <th scope="col" class="mx">Actualizar</th> --}}
                            {{-- <th scope="col" class="mx-">Eliminar</th> --}}
                        </tr>
                    </thead>

                    <tbody class="divide-y  divide-gray-300 text-gray-500 text-sm">

                        @foreach ($modules as $index => $module)
                            <tr class="text-center">
                                <td class="  py-2">{{ $module['name'] }}</td>
                                <td class="  py-2">
                                    <input type="checkbox" wire:model="modules.{{ $index }}.ver">
                                </td>
                                {{-- <td class=" px- py-2">
                                           <input type="checkbox" wire:model="modules.{{ $index }}.crear">
                                       </td> --}}
                                {{-- <td class="  py-2">
                                           <input type="checkbox" wire:model="modules.{{ $index }}.actualizar">
                                       </td> --}}
                                {{-- <td class="  py-2">
                                           <input type="checkbox" wire:model="modules.{{ $index }}.eliminar">
                                       </td> --}}
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <div class="flex gap-8 justify-center lg:text-base text-sm text-gray-100 hover:text-white">

                <button type="button" class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                    wire:click="$parent.$set('method',false)">
                    Cancelar
                </button>
                <button wire:click="save"
                    class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center ">
                    Guardar
                </button>

            </div>

        </div>
    </div>

</x-modal>
