<div class="w-full z-10  py-5">
    <x-action-message on="subastaCreated" class="  absolute  top-0 right-0 z-50 green-action">Subasta creada con
        exitó.</x-action-message>
    <x-action-message on="subastaUpdated" class="  absolute  top-0 right-0 z-50 orange-action">Subasta actualizada con
        exitó.</x-action-message>
    <x-action-message on="subastaDeleted" class="  absolute  top-0 right-0 z-50 red-action">Subasta eliminada con
        exitó.</x-action-message>

    <div class="">
        <div
            class="w-full flex item-center justify-between order-4  lg:flex-row lg:items-center  mx-auto bg-gray-300 lg:py-4  py-2 lg:px-6 px-3 rounded-md  shadow-md z-20">
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
                        <option value="titulo">Titulo</option>
                        <option value="inicio">Inicio</option>
                        <option value="fin">Fin</option>
                    </select>
                </div>

            </div>


            <button
                class="border border-green-800 hover:text-gray-200 hover:bg-green-700 bg-green-600 px-2 py-0.5 rounded-lg text-white text-sm h-7 place-self-center flex items-center gap-x-2 cursor-pointer"
                wire:click="option('save')">
                <svg width="20px" height="20px">
                    <use xlink:href="#agregar"></use>
                </svg>
                <span>
                    Agregar
                </span>
            </button>


        </div>

        {{-- @if ($method)
            @livewire('admin.subastas.modal', ['method' => $method, 'id' => $id])
        @endif --}}

        {{-- @dump($method) --}}
        @if ($method)
            @if ($method != 'pujas')
                @livewire('admin.subastas.modal', ['method' => $method, 'id' => $id])
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Livewire.dispatch('modalOpened');
                    });
                </script>
            @else
                @livewire('admin.subastas.modal-pujas', ['id' => $id], key('modal-pujas' . $id))
            @endif
        @endif





        <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600  mx-auto rounded-md  shadow-md relative">



            {{-- <x-action-message on="subastaNotExits" class="bg-blue-500  border-blue-700 absolute left-0 z-10" >Barrio inexistente.</x-action-message>  --}}


            <div class="min-w-full inline-block align-middle ">
                <div class="overflow-hidden">

                    @if (count($subastas))



                        <table class="min-w-full divide-y  divide-gray-600 ">
                            <thead>



                                <tr
                                    class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">


                                    <th scope="col" class="py-1">ID</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Fecha inicio</th>
                                    <th scope="col">Fecha fin</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Lotes</th>


                                    <th scope="col" class="lg:w-[190px] w-[90px]">Accion</th>

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-400 text-gray-600  text-sm bg-gray-300">

                                @foreach ($subastas as $subasta)
                                    <tr
                                        class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start ">




                                        <td class="py-2">{{ $subasta->id }}</td>
                                        <td class="py-2">{{ $subasta->titulo }}</td>
                                        <td class="py-2">
                                            {{ \Carbon\Carbon::parse($subasta->fecha_inicio)->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="py-2">
                                            {{ \Carbon\Carbon::parse($subasta->fecha_fin)->format('Y-m-d H:i') }}</td>

                                        @php

                                            switch ($subasta->estado) {
                                                case 'activa':
                                                    $color = 'text-green-600';
                                                    $text = 'Activa';
                                                    break;
                                                case 'inactiva':
                                                    $color = 'text-red-500';
                                                    $text = 'Inactiva';
                                                    break;
                                                case 'enpuja':
                                                    $color = 'text-yellow-700';
                                                    $text = 'En puja';
                                                    break;
                                                case 'finalizada':
                                                    $color = 'text-cyan-700';
                                                    $text = 'Finalizada';
                                                    break;
                                                case 'pausada':
                                                    $color = 'text-purple-700';
                                                    $text = 'Pausada';
                                                    break;
                                                default:
                                                    $color = '';
                                                    $text = '';
                                                    break;
                                            }
                                        @endphp

                                        <td {{-- class="py-2 font-semibold {{ $subasta->estado ? 'text-green-600' : 'text-red-600' }}" --}} class="py-2 font-semibold  {{ $color }}">
                                            {{-- {{ $subasta->estado ? 'On' : 'Off' }} --}}
                                            {{ $text }}
                                        </td>
                                        <td class="py-2">
                                            <a href="{{ route('admin.lotes', ['ids' => 'subasta-' . $subasta->id]) }}"
                                                class="bg-cyan-900 text-white px-4 rounded-2xl cursor-pointer py-0.5 hover:bg-cyan-950 "
                                                title="Ver lotes">
                                                {{-- {{ $subasta->lotes->count() }} --}}
                                                {{ $subasta->contarLotes() }}
                                            </a>
                                        </td>






                                        <td>
                                            <div class="flex justfy-end lg:gap-x-6 gap-x-4 text-white text-xs">





                                                <button
                                                    class=" hover:text-gray-200  hover:bg-purple-950 flex items-center py-0.5 bg-purple-900 rounded-lg px-1 cursor-pointer"
                                                    title="Ver pujas" wire:click="option('pujas',{{ $subasta->id }})">
                                                    @if ($subasta->pujas_count > 0)
                                                        <x-hammer-admin />
                                                    @else
                                                        <x-hammer-icon />
                                                    @endif
                                                    <span class="hidden lg:block">Pujas</span>
                                                </button>


                                                <a href="{{ route('admin.garantias', ['ids' => $subasta->id]) }}"
                                                    class=" hover:text-gray-200  hover:bg-yellow-900 flex items-center py-0.5 bg-yellow-800 rounded-lg px-1 cursor-pointer"
                                                    title="Ver garantias">
                                                    <svg fill="#fff" class="size-5 mr-0.5">
                                                        <use xlink:href="#garantias"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Garantias</span>
                                                </a>

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-green-900 flex items-center py-0.5 bg-green-800 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('view',{{ $subasta->id }})"
                                                    title="Ver subasta">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#ver"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Ver</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('delete',{{ $subasta->id }})">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#eliminar"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Eliminar</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200 hover:bg-orange-700 flex items-center py-0.5 bg-orange-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('update',{{ $subasta->id }})">
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
        @if (count($subastas))
            <div class="w-full  justify-between  lg:w-[75%]  mx-auto px-2 ">
                {{ $subastas->links() }}
            </div>
        @endif
    </div>

</div> <!-- end card -->



</div>
