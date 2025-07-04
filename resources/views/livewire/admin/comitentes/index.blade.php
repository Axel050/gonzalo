<div class=" w-full z-0  py-5">


    <x-action-message on="comitenteCreated" class="absolute  top-0 right-0 z-50 green-action"> Comitente creado con
        exitó.</x-action-message>
    <x-action-message on="comitenteUpdated" class="absolute  top-0 right-0 z-50 orange-action">Comitente actualizado con
        exitó.</x-action-message>
    <x-action-message on="comitenteDeleted" class="absolute  top-0 right-0 z-50 red-action">Comitente eliminado con
        exitó.</x-action-message>

    <x-action-message on="autorizadoCreated" class=" absolute  top-0 right-0 z-50  yellow-action">Autorizado agregado con
        exitó.</x-action-message>


    <div class="">
        <div
            class="w-full flex item-center justify-between order-4  lg:flex-row lg:items-center  mx-auto bg-gray-300 lg:py-4  py-2 lg:px-6 px-3 rounded-md  shadow-md">
            <div class="flex flex-col lg:flex-row lg:gap-4  text-gray-700">
                <div>
                    <label for="query" class="text-sm lg:text-base text-gray-600 ">Buscar</label>
                    <input type="{{ $inputType }}" nombre="query" wire:model.live="query"
                        class="lg:h-7 h-6 rounded-md border border-gray-400 w-40 lg:w-48 bg-gray-100">
                </div>

                <div class="text-xs flex gap-2 lg:gap-3 ">
                    <select wire:model.live="searchType"
                        class="lg:h-7 h-6 rounded-md border border-gray-400 lg:w-full w-fit ml-auto mt-1 lg:mt-0 text-gray-600 text-sm py-0.5 cursor-pointer bg-gray-200">
                        <option value="todos">Todos</option>
                        <option value="id">ID</option>
                        <option value="nombre">Nombre</option>
                        <option value="apellido">Apellido</option>
                        <option value="mail">Mail</option>
                        <option value="CUIT">CUIT</option>
                        <option value="telefono">Telefono</option>
                        <option value="alias">Alias</option>
                    </select>
                </div>

            </div>


            <button
                class="border border-white hover:text-gray-200 hover:bg-green-700 bg-green-500 px-2 py-0.5 rounded-lg text-white text-sm h-7 place-self-center flex items-center gap-x-2 cursor-pointer"
                wire:click="option('save')" title="Agregar comitente">
                <svg class="size-5 mr-0.5">
                    <use xlink:href="#agregar"></use>
                </svg>
                <span class="">
                    Agregar
                </span>
            </button>


        </div>


        @if ($method)
            @if ($method != 'autorizados')
                @livewire('admin.comitentes.modal', ['method' => $method, 'id' => $id])
            @else
                @livewire('admin.comitentes.modal-autorizados', ['id' => $id])
            @endif
        @endif



        <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600  mx-auto rounded-md  shadow-md relative">



            {{-- <x-action-message on="comitenteNotExits" class="bg-blue-500  border-blue-700 absolute left-0 z-10" >Barrio inexistente.</x-action-message>  --}}


            <div class="min-w-full inline-block align-middle ">
                <div class="overflow-hidden">

                    @if (count($comitentes))



                        <table class="min-w-full divide-y  divide-gray-600 ">
                            <thead>



                                <tr
                                    class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">


                                    <th scope="col" class="py-1">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">CUIT</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Alias</th>
                                    {{-- <th scope="col" >Estado</th> --}}
                                    <th scope="col">Lotes</th>


                                    <th scope="col" class="lg:w-[190px] w-[90px]">Accion</th>

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-400 text-gray-600  text-sm bg-gray-300">

                                @foreach ($comitentes as $comitente)
                                    <tr
                                        class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start ">


                                        <td class="py-2">{{ $comitente->id }}</td>
                                        <td class="py-2">{{ $comitente->nombre }}, {{ $comitente->apellido }}</td>
                                        <td class="py-2">{{ $comitente->telefono }}</td>
                                        <td class="py-2">{{ $comitente->CUIT }}</td>
                                        <td class="py-2">{{ $comitente->mail }}</td>
                                        <td class="py-2">{{ $comitente->alias?->nombre }}</td>

                                        {{-- <td class="py-2">{{\Carbon\Carbon::parse($comitente->fecha_fin)->format('Y-m-d H:i') }}</td> --}}
                                        {{-- <td class="py-2 font-semibold {{$comitente->estado ? "text-green-600" : "text-red-600"}}">{{$comitente->estado ? "On" : "Off"}}</td> --}}
                                        <td class="py-2">
                                            <a
                                                href="{{ route('admin.lotes', ['ids' => 'comitente-' . $comitente->id]) }}">
                                                <button
                                                    class="bg-cyan-900 text-white px-4 rounded-2xl cursor-pointer py-0.5 hover:bg-cyan-950"
                                                    title="Ver lotes">
                                                    {{ $comitente->Clotes->count() }}
                                                </button>
                                            </a>
                                        </td>





                                        <td>
                                            <div class="flex justfy-end lg:gap-x-6 gap-x-4 text-white text-xs">


                                                <button
                                                    class=" hover:text-gray-200  hover:bg-yellow-900 flex items-center py-0.5 bg-yellow-800 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('autorizados',{{ $comitente->id }})"
                                                    title="Ver autorizados">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#autorizados"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Autorizados</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-green-900 flex items-center py-0.5 bg-green-800 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('view',{{ $comitente->id }})"
                                                    title="Ver comitente">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#ver"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Ver</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('delete',{{ $comitente->id }})">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#eliminar"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Eliminar</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200 hover:bg-orange-700 flex items-center py-0.5 bg-orange-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('update',{{ $comitente->id }})">
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
                        <h3 class="w-full text-center py-8 px-3 rounded-md text-xl">¡Sin resultados para
                            "<strong>{{ $query }}</strong>"!</h3>
                    @endif
                </div>

            </div>
        </div>
        @if (count($comitentes))
            <div class="w-full  justify-between  lg:w-[75%]  mx-auto px-2 ">
                {{ $comitentes->links() }}
            </div>
        @endif
    </div>

</div> <!-- end card -->



</div>
