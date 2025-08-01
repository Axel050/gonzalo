<div class="w-full z-10  py-5">
    <x-action-message on="auditoriaDeleted" class="  absolute  top-0 right-0 z-50 red-action">Auditoria eliminada con
        exitó.</x-action-message>
    <x-action-message on="auditoriaNotExits" class="  absolute  top-0 right-0 z-50 red-action">Auditoria no
        encontrada.</x-action-message>

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
                        <option value="tipo">Tipo</option>
                        <option value="tipo_id">Tipo ID</option>
                        <option value="usuario">Usuario</option>
                        <option value="fecha">Fecha</option>
                    </select>
                </div>

                <div class="flex bred-200 py-1 px-4 bg-whit shadow-md shadow-gray-400 rounded-lg lg:ml-8 items-center ">
                    <span class=" mr-1">
                        Evento
                    </span>
                    <div class="text-xs flex gap-2 lg:gap-3 ">
                        <select wire:model.live="eventFilter"
                            class="h-6 rounded-md border border-gray-400 lg:w-full w-fit ml-auto mt-1 lg:mt-0 text-gray-600 text-sm  cursor-pointer bg-gray-200 py-0">
                            <option value="">Todos </option>
                            <option value="created">Crear </option>
                            <option value="updated">Editar </option>
                            <option value="deleted">Eliminar </option>
                        </select>
                    </div>
                </div>

            </div>





        </div>

        @if ($method)
            @livewire('admin.auditorias.modal', ['method' => $method, 'id' => $id])
        @endif



        <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600  mx-auto rounded-md  shadow-md relative">






            <div class="min-w-full inline-block align-middle ">
                <div class="overflow-hidden">

                    @if (count($auditorias))


                        <table class="min-w-full divide-y  divide-gray-600 ">
                            <thead>

                                <tr
                                    class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">

                                    <th scope="col" class="py-1">ID</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Tipo ID</th>
                                    <th scope="col">Antiguo</th>
                                    <th scope="col">Nuevo</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Evento</th>

                                    <th scope="col" class="lg:w-[190px] w-[90px]">Accion</th>

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-400 text-gray-600  text-sm bg-gray-300">


                                @foreach ($auditorias as $aud)
                                    <tr
                                        class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start ">


                                        <td class="py-2">{{ $aud->id }}</td>
                                        <td class="py-2">{{ class_basename($aud->auditable_type) }}</td>
                                        <td class="py-2">{{ $aud->auditable_id }}</td>
                                        <td class="py-2">
                                            @foreach ($aud->old_values as $key => $value)
                                                @if ($loop->index < 2)
                                                    {{ ucfirst($key) }}:
                                                    {{ is_string($value) && \Carbon\Carbon::hasFormat($value, 'Y-m-d H:i:s') ? \Carbon\Carbon::parse($value)->format('d/m/Y H:i') : $value }}<br>
                                                @endif
                                            @endforeach
                                            @if (count($aud->old_values) > 2)
                                                <b>... más info en VER</b>
                                            @endif

                                        </td>
                                        <td class="py-2">
                                            @foreach ($aud->new_values as $key => $value)
                                                @if ($loop->index < 2)
                                                    {{ ucfirst($key) }}:
                                                    {{ is_string($value) && \Carbon\Carbon::hasFormat($value, 'Y-m-d H:i:s') ? \Carbon\Carbon::parse($value)->format('d/m/Y H:i') : $value }}<br>
                                                @endif
                                            @endforeach
                                            @if (count($aud->new_values) > 2)
                                                <b>... más info en VER</b>
                                            @endif

                                        </td>

                                        <td class="py-2">
                                            {{ \Carbon\Carbon::parse($aud->created_at)->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="py-2">
                                            {{ $aud->user->name }} {{ $aud->user?->personal?->apellido }}</td>


                                        @php

                                            switch ($aud->event) {
                                                case 'created':
                                                    $color = 'text-green-500';
                                                    $event = 'Crear';
                                                    break;
                                                case 'updated':
                                                    $color = 'text-red-500';
                                                    $event = 'Editar';
                                                    break;
                                                case 'deleted':
                                                    $color = 'text-yellow-700';
                                                    $event = 'Eliminar';
                                                    break;
                                                case 'finalizada':
                                                    $color = 'text-cyan-700';
                                                    $event = 'Finalizada';
                                                    break;
                                                default:
                                                    $color = '';
                                                    $event = '';
                                                    break;
                                            }
                                        @endphp

                                        <td class="py-2 font-semibold !pl-0 !text-center">
                                            {{ $event }}
                                        </td>

                                        <td>
                                            <div class="flex justfy-end lg:gap-x-6 gap-x-4 text-white text-xs">

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-green-900 flex items-center py-0.5 bg-green-800 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('view',{{ $aud->id }})" title="Ver aud">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#ver"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Ver</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('delete',{{ $aud->id }})">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#eliminar"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Eliminar</span>
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
        @if (count($auditorias))
            <div class="w-full  justify-between  lg:w-[75%]  mx-auto px-2 ">
                {{ $auditorias->links() }}
            </div>
        @endif
    </div>

</div> <!-- end card -->



</div>
