<div class="w-full py-5">




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
                    <option value="fecha">Fecha</option>
                    <option value="adquirente">Adquirente</option>
                    <option value="orden">Orden</option>
                    <option value="cae">Cae</option>
                </select>
            </div>




        </div>


        <button
            class="border border-green-800 hover:text-gray-200 hover:bg-green-700 bg-green-600 px-2 py-0.5 rounded-lg text-white text-sm h-7 place-self-center flex items-center gap-x-2 cursor-pointer"
            wire:click="option('add')">
            <svg class="size-5 mr-0.5">
                <use xlink:href="#agregar"></use>
            </svg>
            <span>
                Crear
            </span>
        </button>


    </div>










    <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600  mx-auto rounded-md  shadow-md relative">

        {{-- @dump($sortField) --}}

        <div class="min-w-full inline-block align-middle ">
            <div class="overflow-hidden">

                <table class="min-w-full divide-y  divide-gray-600 ">
                    <thead>

                        <tr
                            class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Adquirente</th>
                            <th>Concepto</th>
                            <th>Total</th>
                            <th>Orden</th>
                            <th>CAE</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-400 text-gray-600  text-sm bg-gray-300">




                        @forelse($facturas as $factura)
                            <tr
                                class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start ">
                                <td class="px-6 py-4 font-bold text-cyan-800">#{{ $factura->id }}</td>
                                {{-- <td class="px-6 py-4">{{ $factura->fecha->format('d/m/Y') }}</td> --}}
                                <td>{{ $factura->fecha }}</td>
                                <td>{{ $factura->nombre }} {{ $factura->apellido }}</td>
                                <td>
                                    <span
                                        class="md:px-2 px-0.5 py-1 rounded-full text-xs font-bold 
                                {{ $factura->tipo_concepto == 'comision'
                                    ? 'bg-blue-100 text-blue-700'
                                    : ($factura->tipo_concepto == 'venta_lote'
                                        ? 'bg-green-100 text-green-700'
                                        : 'bg-orange-100 text-orange-700') }}">
                                        {{ ucfirst(str_replace('_', ' ', $factura->tipo_concepto)) }}
                                    </span>
                                </td>
                                <td class="font-bold">
                                    ${{ number_format($factura->monto_total, 2, ',', '.') }}
                                </td>
                                <td class="font-semibold text-gray-600">
                                    {{ $factura->orden_id ? '#' . $factura->orden_id : '-' }}</td>
                                <td class="px-6 py-4">
                                    @if ($factura->cae)
                                        <span class="text-green-600 font-bold text-xs">{{ $factura->cae }}</span>
                                    @else
                                        <span class="text-gray-400 italic text-xs">Sin CAE</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 flex justify-center gap-2">
                                    <button wire:click="option('view', {{ $factura->id }})"
                                        class="p-1 text-cyan-600 hover:bg-cyan-50 rounded">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-10 text-gray-400 italic">No se encontraron
                                    facturas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">
        {{ $facturas->links() }}
    </div>

    @if ($method != '')
        @livewire('admin.facturas.modal', ['id' => $id, 'method' => $method], key('modal-factura-' . $id . '-' . $method))
    @endif
</div>
