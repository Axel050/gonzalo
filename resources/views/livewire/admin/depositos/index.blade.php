<div class="bg-gay-50 w-full fullscreen py-5">

    <x-action-message on="depositoCreated" class="absolute  top-0 right-0 z-50 green-action ">Deposito creado con
        exitó.</x-action-message>
    <x-action-message on="depositoUpdated" class="absolute  top-0 right-0 z-50 orange-action">Deposito actualizado con
        exitó.</x-action-message>
    <x-action-message on="depositoDeleted" class="absolute  top-0 right-0 z-50 red-action">Deposito eliminado con
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
                        class="lg:h-7 h-6 rounded-md border border-gray-400 lg:w-full w-fit ml-auto mt-1 lg:mt-0 text-gray-500 text-sm py-0.5 cursor-pointer">
                        <option value="todos">Todos</option>
                        <option value="id">ID</option>
                        <option value="fecha">Fecha</option>
                        <option value="fecha_devolucion">Fecha devolucion</option>
                        <option value="adquirente">Adquirente</option>
                        <option value="subasta">Subasta</option>
                        <option value="estado">Estado</option>
                    </select>
                </div>

            </div>


            <button
                class="border border-green-800 hover:text-gray-200 hover:bg-green-700 bg-green-600 px-2 py-0.5 rounded-lg text-white text-sm h-7 place-self-center flex items-center gap-x-2 cursor-pointer"
                wire:click="option('save')">
                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    stroke="#ffffff">
                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                    <g id="SVGRepo_iconCarrier">
                        <path d="M7 12L12 12M12 12L17 12M12 12V7M12 12L12 17" stroke="#ffffff" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="12" cy="12" r="9" stroke="#ffffff" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                </svg>
                <span>
                    Agregar
                </span>
            </button>


        </div>

        @if ($method)
            @livewire('admin.depositos.modal', ['method' => $method, 'id' => $id])
        @endif



        <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600  mx-auto rounded-md  shadow-md relative">



            <div class="min-w-full inline-block align-middle ">
                <div class="overflow-hidden">

                    @if (count($depositos))



                        <table class="min-w-full divide-y  divide-gray-600 ">
                            <thead>

                                <tr
                                    class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">
                                    <th scope="col" class="py-1">ID</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Monto</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Fecha dev</th>
                                    <th scope="col">Adquirente</th>
                                    <th scope="col">Subasta</th>
                                    <th scope="col" class="lg:w-[190px] w-[90px]">Accion</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-400 text-gray-600  text-sm bg-gray-300">

                                @foreach ($depositos as $dep)
                                    <tr
                                        class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start ">

                                        <td class="py-2">{{ $dep->id }}</td>
                                        <td class="py-2">{{ $dep->fecha }}</td>
                                        <td class="py-2">{{ number_format($dep->monto, 0, ',', '.') }}</td>
                                        <td class="py-2">{{ $dep->estado }}</td>
                                        <td class="py-2">{{ $dep->fecha_devolucion }}</td>
                                        <td class="py-2">{{ $dep->adquirente?->nombre }}
                                            {{ $dep->adquirente?->apellido }} </td>
                                        <td class="py-2">{{ $dep->subasta?->id }}</td>

                                        <td>
                                            <div class="flex justfy-end lg:gap-x-6 gap-x-4 text-white text-xs">

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('delete',{{ $dep->id }})">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                                    <span class="hidden lg:block">Eliminar</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200 hover:bg-orange-700 flex items-center py-0.5 bg-orange-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('update',{{ $dep->id }})">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z"
                                                            fill="#ffffff" />
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
        @if (count($depositos))
            <div class="w-full  justify-between  lg:w-[75%]  mx-auto px-2 ">
                {{ $depositos->links() }}
            </div>
        @endif
    </div>

</div> <!-- end card -->



</div>
