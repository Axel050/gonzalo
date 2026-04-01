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


        @if ($tab === 'facturas')
            <button
                class="border border-green-800 hover:text-gray-200 hover:bg-green-700 bg-green-600 px-2 py-0.5 rounded-lg text-white text-sm h-7 place-self-center flex items-center gap-x-2 cursor-pointer"
                wire:click="option('add')">
                <svg class="size-5 mr-0.5">
                    <use xlink:href="#agregar"></use>
                </svg>
                <span>
                    Nueva Factura
                </span>
            </button>
        @endif

    </div>

    <!-- TABS -->
    <div class="flex border-b border-gray-400 mt-6 mx-4">
        <button wire:click="setTab('facturas')"
            class="py-2 px-6 font-bold focus:outline-none transition-colors duration-200 {{ $tab === 'facturas' ? 'border-b-4 border-cyan-600 text-cyan-600' : 'text-gray-600 hover:text-cyan-600' }}">Historial
            Facturas</button>
        <button wire:click="setTab('por_facturar')"
            class="relative py-2 px-6 font-bold focus:outline-none transition-colors duration-200 {{ $tab === 'por_facturar' ? 'border-b-4 border-cyan-600 text-cyan-600' : 'text-gray-600 hover:text-cyan-600' }}">
            Adquirentes por Facturar
            @if (isset($pendientesCount) && $pendientesCount > 0)
                <span
                    class="absolute top-1 right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white shadow-sm border border-white">{{ $pendientesCount }}</span>
            @endif
        </button>
    </div>










    <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600 mx-auto rounded-md shadow-md relative">
        <div class="min-w-full inline-block align-middle ">
            <div class="overflow-hidden">

                @if ($tab === 'facturas')
                    <table class="min-w-full divide-y divide-gray-600 ">
                        <thead>
                            <tr
                                class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Adquirente</th>
                                <th>Concepto</th>
                                <th>Total</th>
                                <th>Orden(es)</th>
                                <th>CAE</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-400 text-gray-600 text-sm bg-gray-300">
                            @php
                                $facturasAgrupadas = $facturas->groupBy(function ($f) {
                                    if ($f->factura_asociada_id) {
                                        return min($f->id, $f->factura_asociada_id);
                                    }
                                    return $f->id;
                                });
                            @endphp

                            @forelse($facturasAgrupadas as $grupo)
                                @php
                                    $totalGrupo = $grupo->sum('monto_total');
                                @endphp

                                @foreach ($grupo as $factura)
                                    <tr
                                        class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start">
                                        <td class="px-6 py-4 font-bold text-cyan-800">#{{ $factura->id }}</td>
                                        <td>{{ $factura->fecha }}</td>
                                        <td>{{ $factura->nombre }} {{ $factura->apellido }}</td>
                                        <td>
                                            <span
                                                class="md:px-2 px-1 py-1 rounded-full text-xs font-bold 
                                            {{ $factura->tipo_concepto == 'comision' ? 'bg-blue-100 text-blue-700' : ($factura->tipo_concepto == 'martillo' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700') }}">
                                                {{ ucfirst(str_replace('_', ' ', $factura->tipo_concepto)) }}
                                            </span>
                                        </td>
                                        <td class="font-bold">${{ number_format($factura->monto_total, 0, ',', '.') }}
                                        </td>
                                        <td class="font-semibold text-gray-600">
                                            @forelse ($factura->ordenes as $item)
                                                #{{ $item->id }} @if (!$loop->last)
                                                    -
                                                @endif
                                            @empty
                                                -
                                            @endforelse
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($factura->cae)
                                                <span
                                                    class="text-green-600 font-bold text-xs">{{ $factura->cae }}</span>
                                            @else
                                                <span class="text-gray-400 italic text-xs">Sin CAE</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-1">
                                            <div class="flex items-center justify-center gap-1">
                                                <button wire:click="option('view', {{ $factura->id }})"
                                                    class="p-0.5 bg-green-500 rounded-full">
                                                    <svg class="size-5">
                                                        <use xlink:href="#ver"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr
                                    class="bg-gray-200 divide-x-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td class="py-1.5"><span
                                            class="md:px-2 px-0.5 py-1 rounded-full text-xs font-bold bg-blue-200 text-blue-800">TOTAL
                                            GRUPO</span></td>
                                    <td class="text-cyan-800 text-left font-black">
                                        ${{ number_format($totalGrupo, 0, ',', '.') }}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-6 py-10 text-gray-400 italic text-center">No se
                                            encontraron facturas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="m-4">{{ $facturas->links() }}</div>
                    @else
                        <!-- TABLA POR FACTURAR -->
                        <table class="min-w-full divide-y divide-gray-600">
                            <thead>
                                <tr
                                    class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">
                                    <th>Adquirente</th>
                                    <th>Órdenes Pagadas (Sin Factura)</th>
                                    <th>Monto Total Estimado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-400 text-gray-600 text-sm bg-gray-300">
                                @forelse($adquirentes_pendientes as $adquirente)
                                    <tr
                                        class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start hover:bg-gray-200">
                                        <td class="px-6 py-4 font-bold">{{ $adquirente->nombre }}
                                            {{ $adquirente->apellido }}</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="bg-blue-100 text-blue-800 font-bold px-2 py-1 rounded text-xs">{{ $adquirente->ordenes->count() }}
                                                Órdenes Pendientes</span>
                                        </td>
                                        <td class="px-6 py-4 font-semibold text-green-700">
                                            ${{ number_format($adquirente->ordenes->sum('total'), 2, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 flex justify-center gap-2">
                                            <button wire:click="option('add', null, {{ $adquirente->id }})"
                                                class="px-3 py-1 bg-cyan-600 text-white hover:bg-cyan-700 rounded-md shadow flex items-center gap-1 font-bold text-xs"
                                                title="Generar Facturas">
                                                Facturar a Adquirente
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-gray-500 italic text-center">No hay
                                            adquirentes con órdenes pagadas pendientes de facturar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="m-4">{{ $adquirentes_pendientes->links() }}</div>
                    @endif
                </div>
            </div>
        </div>

        @if ($method == 'add')
            @livewire('admin.facturas.modal', ['id' => $id, 'method' => $method, 'adquirente_id' => $adquirente_id_selected], key('modal-factura-' . $id . '-' . $method))
        @elseif ($method == 'view')
            @livewire('admin.facturas.modal-ver', ['id' => $id, 'method' => $method], key('modal-factura-' . $id . '-' . $method))
        @endif
    </div>
