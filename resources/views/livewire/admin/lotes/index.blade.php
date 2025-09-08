<div class=" w-full  py-5">


    <x-action-message on="loteUpdated" class="fixed  top-0 right-0 z-50 orange-action">Lote actualizado con
        exitó.</x-action-message>
    <x-action-message on="loteDeleted" class="fixed  top-0 right-0 z-50 red-action">Lote eliminado con
        exitó.</x-action-message>

    <div class="">
        <div
            class="w-full flex item-center justify-between order-4  lg:flex-row lg:items-center  mx-auto bg-gray-300 lg:py-4  py-2 lg:px-6 px-3 rounded-md  shadow-md">
            <div class="flex flex-col lg:flex-row lg:gap-4  text-gray-700  ">

                <div class="flex bred-200 py-1 lg:px-4 px-2 bg-whit shadow-md shadow-gray-400 rounded-lg items-center">

                    <div class="flex items-center">
                        <label for="query" class="text-sm lg:text-base text-gray-600 mr-1">Buscar</label>
                        <input type="search" nombre="query" wire:model.live="query"
                            class=" h-6 rounded-md boder border-gray-400 w-40 lg:w-48 bg-gray-100   focus:outline-2 focus:outline-cyan-900">
                    </div>

                    <div class="text-xs ">
                        <select wire:model.live="searchType"
                            class=" h-6 rounded-md border border-gray-400 lg:w-full w-fit -auto lg:mt-0 text-gray-600 text-sm py-0 cursor-pointer bg-gray-200 ml-1">
                            <option value="todos">Todos</option>
                            <option value="id">ID</option>
                            <option value="titulo">Titulo</option>
                            <option value="comitente">Comitente</option>
                            <option value="alias">Alias</option>
                            <option value="tipo">Tipo</option>
                            <option value="subasta">Subasta</option>
                            <option value="contrato">Contrato</option>
                            {{-- <option value="estado">Estado</option> --}}
                            <option value="encargado">Encargado</option>
                        </select>
                    </div>
                </div>

                <div class="flex  justify-between">


                    <div
                        class="flex bred-200 py-1 lg:px-4 px-2 bg-whit shadow-md shadow-gray-400 rounded-lg lg:ml-8 items-center  w-fit">
                        <span class=" mr-1">
                            Estados
                        </span>
                        <div class="text-xs flex gap-2 lg:gap-3 ">
                            <select wire:model.live="estadoFilter"
                                class="h-6 rounded-md border border-gray-400 lg:w-full w-fit ml-auto mt-1 lg:mt-0 text-gray-600 text-sm  cursor-pointer bg-gray-200 py-0">
                                <option value="">Todos </option>
                                @foreach ($estados as $estado)
                                    <option value="{{ $estado['value'] }}">{{ $estado['label'] }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div
                        class="flex bred-200 py-1 lg:px-4 px-2 bg-whit shadow-md shadow-gray-400 rounded-lg lg:ml-12  items-center  w-fit ">
                        <span class=" mr-1">
                            Destacados
                        </span>
                        <div class="text-xs flex gap-2 lg:gap-3 ">
                            <input type="checkbox" class=" size-5 ml-1.5" wire:model.live="destacados">
                        </div>
                    </div>
                </div>

            </div>


        </div>


        @if ($method)

            @if ($method != 'history')
                @livewire('admin.lotes.modal', ['method' => $method, 'id' => $id], key('modal-contrato-lotes-' . $id))
            @else
                @livewire('admin.lotes.modal-history', ['id' => $id, 'index' => true], key('modal-contrato-lotes-' . $id))
            @endif

        @endif



        <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600  mx-auto rounded-md  shadow-md relative">



            <div class="min-w-full inline-block align-middle ">
                <div class="overflow-hidden">

                    @if (count($lotes))



                        <table class="min-w-full divide-y  divide-gray-600 ">
                            <thead>

                                <tr
                                    class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600  [&>th]:text-center text-sm ">
                                    <th scope="col" class="py-1">ID</th>
                                    <th scope="col">Titulo</th>
                                    <th scope="col">Comitente</th>
                                    <th scope="col">Alias</th>
                                    <th scope="col">Foto</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Encargado</th>
                                    <th scope="col">Base</th>
                                    <th scope="col">Valuacion</th>
                                    <th scope="col">Moneda</th>
                                    <th scope="col">Subasta</th>
                                    <th scope="col">Contrato</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-400 text-gray-600  text-sm bg-gray-300">

                                @foreach ($lotes as $lot)
                                    <tr class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:px-1 [&>td]:text-center ">

                                        <td class="py-2">{{ $lot->id }}</td>
                                        <td class="py-2">{{ $lot->titulo }}</td>
                                        <td class="py-2">
                                            <a href="{{ route('admin.comitentes', ['ids' => $lot->comitente?->id]) }}"
                                                class="cursor-pointer hover:font-bold">
                                                {{ $lot->comitente?->nombre }}
                                                {{ $lot->comitente?->apellido }}
                                            </a>
                                        </td>
                                        <td class="py-2">
                                            <a href="{{ route('admin.comitentes', ['alias' => $lot->comitente?->alias?->nombre]) }}"
                                                class="cursor-pointer hover:font-bold">
                                                {{ $lot->comitente?->alias?->nombre }}
                                            </a>
                                        </td>
                                        <td class="py-2 !px-0">
                                            @if ($lot->foto1 && Storage::disk('public')->exists('imagenes/lotes/thumbnail/' . $lot->foto1))
                                                <img class="max-w-[50px] max-h-[50px] hover:cursor-pointer hver:bg-white p-0.5 hover:outline mx-auto hover:scale-110 transition-transform"
                                                    src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lot->foto1) }}"
                                                    wire:click="$set('modal_foto', '{{ $lot->foto1 }}')">
                                            @else
                                                <svg class="mx-auto   size-10 ">
                                                    <use xlink:href="#default-img-input"></use>
                                                </svg>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.tipo-bien', ['ids' => $lot->tipo?->id]) }}"
                                                class="cursor-pointer hover:font-bold">
                                                {{ $lot->tipo?->nombre }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.usuarios', ['ids' => $lot->tipo?->encargado?->id]) }}"
                                                class="cursor-pointer hover:font-bold">
                                                {{ $lot->tipo?->encargado?->nombre }}
                                                {{ $lot->tipo?->encargado?->apellido }}
                                            </a>
                                        </td>
                                        <td>{{ (int) $lot->precio_base }}</td>
                                        <td>{{ (int) $lot->valuacion }}</td>
                                        <td>{{ $lot->ultimoConLote?->moneda?->titulo }}</td>
                                        <td>
                                            <a href="{{ route('admin.subastas', ['ids' => $lot->ultimoContrato?->subasta_id]) }}"
                                                class="cursor-pointer hover:font-extrabold">
                                                {{ $lot->ultimoContrato?->subasta_id }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.contratos', ['ids' => $lot->ultimo_contrato]) }}"
                                                class="cursor-pointer hover:font-extrabold">
                                                {{ $lot->ultimo_contrato }}
                                            </a>
                                        </td>

                                        <td>
                                            {{ collect($estados)->firstWhere('value', $lot->estado)['label'] ?? $lot->estado }}
                                        </td>

                                        <td>
                                            <div class="flex justify-center  gap-x-4 text-white text-xs mx-auto ">

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-cyan-800 flex items-center py-0.5 bg-cyan-700 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('history',{{ $lot->id }})"
                                                    title="Historial">
                                                    <svg class="size-5 ">
                                                        <use xlink:href="#history"></use>
                                                    </svg>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-green-800 flex items-center py-0.5 bg-green-700 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('view',{{ $lot->id }})" title="Ver">
                                                    <svg class="size-5 ">
                                                        <use xlink:href="#ver"></use>
                                                    </svg>
                                                </button>


                                                <button title="eliminar"
                                                    class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('delete',{{ $lot->id }})"
                                                    title="Eliminar">
                                                    <svg class="size-5 ">
                                                        <use xlink:href="#eliminar"></use>
                                                    </svg>
                                                    {{-- <span class="hidden lg:block">Eliminar</span> --}}
                                                </button>

                                                <button title="editar"
                                                    class=" hover:text-gray-200 hover:bg-orange-700 flex items-center py-0.5 bg-orange-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('update',{{ $lot->id }})" title="editar">
                                                    <svg class="size-5 ">
                                                        <use xlink:href="#editar"></use>
                                                    </svg>
                                                    {{-- <span class="hidden lg:block">Editar</span> --}}
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                        @if ($modal_foto)
                            {{-- <div class="min-h-screen min-w-screen  absolute inset-0"> --}}
                            <x-modal-foto :img="$modal_foto" />
                            {{-- </div> --}}
                        @endif
                    @else
                        <h3 class="w-full text-center py-2 px-3 rounded-md">Sin resultados para
                            "<strong>{{ $query }} </strong>"</h3>
                    @endif
                </div>

            </div>
        </div>
        @if (count($lotes))
            <div class="w-full  justify-between  lg:w-[75%]  mx-auto px-2 ">
                {{ $lotes->links() }}
            </div>
        @endif
    </div>

</div> <!-- end card -->



</div>
