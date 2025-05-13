<div class="w-full  py-5 ">

    <x-action-message on="monedaCreated" class="absolute  top-0 right-0 z-50 green-action ">Moneda creada con
        exitó.</x-action-message>
    <x-action-message on="monedaUpdated" class="absolute  top-0 right-0 z-50 orange-action">Moneda actualizada con
        exitó.</x-action-message>
    <x-action-message on="monedaDeleted" class="absolute  top-0 right-0 z-50 red-action">Moneda eliminada con
        exitó.</x-action-message>

    <div class="">
        <div
            class="w-full flex item-center justify-between order-4  lg:flex-row lg:items-center  mx-auto bg-gray-300 lg:py-4  py-2 lg:px-6 px-3 rounded-md  shadow-md">
            <div class="flex flex-col lg:flex-row lg:gap-4  text-gray-700 ">
                <div>
                    <label for="query" class="text-sm lg:text-base text-gray-600 ">Buscar</label>
                    <input type="search" nombre="query" wire:model.live="query"
                        class="lg:h-7 h-6 rounded-md boder border-gray-400 w-40 lg:w-48 bg-gray-100 px-1  focus:outline-2 focus:outline-cyan-900">
                </div>

                <div class="text-xs flex gap-2 lg:gap-3 ">
                    <select wire:model.live="searchType"
                        class="lg:h-7 h-6 rounded-md border border-gray-400 lg:w-full w-fit ml-auto mt-1 lg:mt-0 text-gray-600 text-sm py-0.5 cursor-pointer bg-gray-200">
                        <option value="todos">Todos</option>
                        <option value="id">ID</option>
                        <option value="titulo">Titulo</option>
                    </select>
                </div>

            </div>


            <button
                class="border border-green-800 hover:text-gray-200 hover:bg-green-700 bg-green-600 px-2 py-0.5 rounded-lg text-white text-sm h-7 place-self-center flex items-center gap-x-2 cursor-pointer"
                wire:click="option('save')">
                <svg class="size-5 mr-0.5">
                    <use xlink:href="#agregar"></use>
                </svg>
                <span>
                    Agregar
                </span>
            </button>


        </div>

        @if ($method)
            @livewire('admin.auxiliares.monedas.modal', ['method' => $method, 'id' => $id])
        @endif



        <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600  mx-auto rounded-md  shadow-md relative">



            <div class="min-w-full inline-block align-middle ">
                <div class="overflow-hidden">

                    @if (count($monedas))



                        <table class="min-w-full divide-y  divide-gray-600 ">
                            <thead>

                                <tr
                                    class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">
                                    <th scope="col" class="py-1">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col" class="lg:w-[190px] w-[90px]">Accion</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-400 text-gray-600  text-sm bg-gray-300">

                                @foreach ($monedas as $moneda)
                                    <tr
                                        class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start ">

                                        <td class="py-2">{{ $moneda->id }}</td>
                                        <td class="py-2">{{ $moneda->titulo }}</td>

                                        <td>
                                            <div class="flex justfy-end lg:gap-x-6 gap-x-4 text-white text-xs">

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('delete',{{ $moneda->id }})">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#eliminar"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Eliminar</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200 hover:bg-orange-700 flex items-center py-0.5 bg-orange-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('update',{{ $moneda->id }})">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#editar"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Editar</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    @else
                        <h3 class="w-full text-center py-2 px-3 rounded-md">Sin resultados para
                            "<strong>{{ $query }} </strong>"</h3>
                    @endif
                </div>

            </div>
        </div>
        @if (count($monedas))
            <div class="w-full  justify-between  lg:w-[75%]  mx-auto px-2 ">
                {{ $monedas->links() }}
            </div>
        @endif
    </div>

</div> <!-- end card -->



</div>
