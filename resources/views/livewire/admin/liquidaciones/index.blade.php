<div class="w-full py-5">

    <x-action-message on="liquidacionCreated" class="absolute  top-0 right-0 z-50 green-action ">Liquidación creada con
        exitó.</x-action-message>
    <x-action-message on="liquidacionUpdated" class="absolute  top-0 right-0 z-50 orange-action">Liquidación actualizada
        con exitó.
    </x-action-message>
    <x-action-message on="liquidacionDeleted" class="absolute  top-0 right-0 z-50 red-action">Liquidación eliminada con
        exitó.</x-action-message>



    <div
        class="w-full flex flex-col md:flex-row md:gap-4  text-gray-700 md:items-center item-center justify-between order-4  lg:flex-row lg:items-center  mx-auto bg-gray-300 lg:py-4  py-2 lg:px-6 px-2 rounded-md  shadow-md">



        <div class="flex md:flex gap-2 ">
            <div>
                <label for="query" class="text-sm lg:text-base text-gray-600 ">Buscar</label>
                <input type="search" nombre="query" wire:model.live="query"
                    class="lg:h-7 h-6 rounded-md border border-gray-400 w-30 md:w-48 bg-gray-100 px-1  focus:outline-2 focus:outline-cyan-900">
            </div>

            <div class="text-xs flex gap-2 lg:gap-3 ">
                <select wire:model.live="searchType"
                    class="lg:h-7 h-6 rounded-md border border-gray-400 lg:w-full w-fit ml-auto  text-gray-600 text-sm py-0.5 cursor-pointer bg-gray-200">
                    <option value="todos">Todos</option>
                    <option value="id">ID</option>
                    <option value="comitente">Nombre</option>
                </select>
            </div>
        </div>



        @if ($tab === 'liquidaciones')
            <div class="flex gap-2 md:gap-5 items-end ml-0 md:ml-2 mt-2 md:mt-0  justify-center">
                <div class="flex items-center md:gap-1 gap-0.5">
                    <label for="dateFrom" class="text-[10px] lg:text-sm text-gray-600 block">Desde</label>
                    <input type="date" wire:model.live="dateFrom"
                        class="lg:h-7 h-6 rounded-md border border-gray-400 w-25 lg:w-32 bg-gray-100 px-1 focus:outline-2 focus:outline-cyan-900 md:text-sm text-xs text-gray-700">
                </div>
                <div class="flex items-center md:gap-1 gap-0.5">
                    <label for="dateTo" class="text-[10px] lg:text-sm text-gray-600 block">Hasta</label>
                    <input type="date" wire:model.live="dateTo"
                        class="lg:h-7 h-6 rounded-md border border-gray-400 w-25 lg:w-32 bg-gray-100 px-1 focus:outline-2 focus:outline-cyan-900 md:text-sm text-xs text-gray-700">
                </div>
            </div>
        @endif



    </div>









    <!-- TABS -->
    <div
        class="flex border-b border-gray-400 md:mt-4 mt-3 mx-4 md:justify-start justify-between md:w-fit md:gap-8 gap-4">

        <button wire:click="setTab('liquidaciones')"
            class="md:w-fit w-1/2  py-0.5 md:py-2 px-3 md:px-6 md:text-base text-sm font-bold focus:outline-none transition-colors duration-200 {{ $tab === 'liquidaciones' ? 'md:border-b-4 border-b-3 border-cyan-600 text-cyan-600' : 'text-gray-600 hover:text-cyan-600' }}">
            Historial
        </button>

        <button wire:click="setTab('por_liquidar')"
            class="md:w-fit w-1/2  relative py-0.5 md:py-2 px-3 md:px-6 md:text-base text-sm font-bold focus:outline-none transition-colors duration-200 {{ $tab === 'por_liquidar' ? 'md:border-b-4 border-b-3 border-cyan-600 text-cyan-600' : 'text-gray-600 hover:text-cyan-600' }}">
            Por Liquidar
            @if (isset($pendientesCount) && $pendientesCount > 0)
                <span
                    class="absolute   md:top-1 md:right-1 -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white shadow-sm border border-white">{{ $pendientesCount }}</span>
            @endif
        </button>
    </div>

    @if ($tab === 'liquidaciones' && ($dateFrom || $dateTo))
        <div
            class="md:mx-4 mt-6 mb-2 md:py-3 py-1.5 md:px-6 px-2 bg-blue-50 border border-blue-300 rounded-md shadow-sm">

            <div class=" md:flex  grid  grid-cols-2 md:gap-8 gap-1  items-center justify-between md:justify-center">
                <div class="flex flex-col text-green-700">
                    <span class="text-[11px] md:text-sm font-semibold uppercase">Total Martillos</span>
                    <span class="md:text-lg text-base font-bold ">+
                        ${{ number_format($global_lotes, 0, ',', '.') }}</span>
                </div>
                <div class="flex flex-col text-red-700">
                    <span class="text-[11px] md:text-sm font-semibold uppercase">Total Deducciones</span>
                    <span class="md:text-lg text-base font-bold">-
                        ${{ number_format($global_deducciones, 0, ',', '.') }}</span>
                </div>
                <div
                    class="flex flex-col md:border-l-2 border-blue-200 md:pl-8 md:mx-2 mx-auto  col-span-2 items-center">
                    <span class="text-[11px] md:text-sm font-bold text-blue-800 uppercase">Monto Final</span>
                    <span
                        class="md:text-xl text-md font-bold text-blue-900">${{ number_format($global_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    @endif

    <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600 mx-auto rounded-md shadow-md relative">
        <div class="min-w-full inline-block align-middle ">
            <div class="overflow-hidden">

                @if ($tab === 'liquidaciones')
                    <!-- TABLA HISTORIAL -->
                    <table class="min-w-full divide-y divide-gray-600">
                        <thead>
                            <tr
                                class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Comitente</th>
                                <th>Concepto</th>
                                <th>Total</th>
                                <th>Lotes</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-400 text-gray-600 text-sm bg-gray-300">
                            @forelse($liquidaciones as $liquidacion)
                                @foreach ($liquidacion->asociadas as $asociada)
                                    <tr
                                        class="divide-x-2 divide-y-2 divide-gray-400 bg-gray-300 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start">
                                        <td class="px-6 py-4 font-bold text-cyan-800">
                                            #{{ $asociada->id }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($asociada->fecha)->format('d/m/Y') }}</td>
                                        <td></td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="md:px-2 px-1 py-1 md:rounded-full rounded-lg text-xs font-bold bg-red-100 text-red-700">
                                                {{ ucfirst($asociada->tipo_concepto) }}
                                            </span>
                                        </td>
                                        <td class="text-red-700 font-semibold">-
                                            ${{ number_format($asociada->subtotal_comisiones + $asociada->subtotal_gastos, 0, ',', '.') }}
                                        </td>
                                        <td class="font-semibold text-gray-700 max-w-[150px] truncate"
                                            title="Lotes: {{ implode(', ', $asociada->items->pluck('lote_id')->filter()->toArray()) }}">
                                            {{ implode(', ', $asociada->items->pluck('lote_id')->filter()->toArray()) }}
                                        </td>
                                        <td>
                                            @if (($asociada->estado ?? 'generada') === 'anulada')
                                                <span
                                                    class="px-2 py-0.5 rounded bg-red-100 text-red-700 font-bold text-xs">ANULADA</span>
                                            @else
                                                <span
                                                    class="px-2 py-0.5 rounded bg-green-100 text-green-700 font-bold text-xs">{{ strtoupper($asociada->estado ?? 'generada') }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="px-6 py-4 flex justify-center ">
                                                <button wire:click="option('view', {{ $asociada->id }})"
                                                    class="p-1 text-cyan-600 hover:bg-cyan-50 rounded"
                                                    title="Ver Detalle">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr
                                    class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start">
                                    <td class="px-6 py-4 font-bold text-cyan-800">#{{ $liquidacion->id }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($liquidacion->fecha)->format('d/m/Y') }}</td>
                                    <td>{{ $liquidacion->comitente->id }} -
                                        {{ $liquidacion->comitente->nombre ?? '' }}
                                        {{ $liquidacion->comitente->apellido ?? '' }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="md:px-2 px-1 py-1 md:rounded-full rounded-lg text-xs font-bold bg-green-100 text-green-700">
                                            {{ ucfirst($liquidacion->tipo_concepto) }}
                                        </span>
                                    </td>
                                    <td class="text-green-700 font-semibold">+
                                        ${{ number_format($liquidacion->subtotal_lotes, 0, ',', '.') }}</td>
                                    <td class="font-semibold text-gray-700 max-w-[150px] truncate"
                                        title="Lotes: {{ implode(', ', $liquidacion->items->pluck('lote_id')->filter()->toArray()) }}">
                                        {{ implode(', ', $liquidacion->items->pluck('lote_id')->filter()->toArray()) }}
                                    </td>
                                    <td>
                                        @if (($liquidacion->estado ?? 'generada') === 'anulada')
                                            <span
                                                class="px-2 py-0.5 rounded bg-red-100 text-red-700 font-bold text-xs">ANULADA</span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 rounded bg-green-100 text-green-700 font-bold text-xs">{{ strtoupper($liquidacion->estado ?? 'generada') }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="px-6 py-4 flex justify-center gap-2">
                                            <button wire:click="option('view', {{ $liquidacion->id }})"
                                                class="p-1 text-cyan-600 hover:bg-cyan-50 rounded" title="Ver Detalle">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                            </button>

                                            @if (($liquidacion->estado ?? 'generada') !== 'anulada')
                                                <button wire:click="option('confirm-anular', {{ $liquidacion->id }})"
                                                    class="p-1 text-red-600 hover:bg-red-50 rounded cursor-pointer"
                                                    title="Anular Liquidación">
                                                    <svg class="size-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            @endif

                                        </div>
                                    </td>
                                </tr>


                                @if ($liquidacion->asociadas->count() > 0)
                                    <tr
                                        class="bg-gray-200 font-bold border-t-2 border-b-4 border-gray-600 text-sm divide-x-2 divide-y-2 divide-gray-400">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="py-2 px-4">
                                            <span
                                                class="md:px-5 px-3 py-1 md:rounded-full rounded-lg text-xs font-bold bg-blue-200 text-blue-800">
                                                TOTAL</span>
                                        </td>
                                        <td class="text-blue-900 py-2 pl-2">
                                            ${{ number_format($liquidacion->monto_total - $liquidacion->asociadas->sum('monto_total'), 0, ',', '.') }}
                                        </td>

                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endif

                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-10 text-gray-500 italic text-center">No se
                                        encontraron liquidaciones.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    <div class="m-4">{{ $liquidaciones->links() }}</div>
                @else
                    <!-- TABLA POR LIQUIDAR -->
                    <table class="min-w-full divide-y divide-gray-600">
                        <thead>
                            <tr
                                class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">
                                <th>Comitente</th>
                                <th>Lotes</th>
                                <th>Martillo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-400 text-gray-600 text-sm bg-gray-300">
                            @forelse($comitentes_pendientes as $comitente)
                                <tr
                                    class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start hover:bg-gray-200">
                                    <td class="px-6 py-4 font-bold">
                                        {{ $comitente->id }} -
                                        {{ $comitente->nombre }}
                                        {{ $comitente->apellido }}</td>
                                    <td class="px-6 md:py-3 py-2">
                                        <span class="bg-blue-100 text-blue-800 font-bold px-2 py-1 rounded text-xs ">
                                            {{ $comitente->Clotes->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-green-700">
                                        ${{ number_format($comitente->Clotes->sum('precio_final'), 0, ',', '.') }}
                                    </td>

                                    <td class="px-6 py-2">
                                        <button wire:click="option('add', null, {{ $comitente->id }})"
                                            class="px-3 py-1 bg-cyan-600 text-white hover:bg-cyan-700 rounded-md shadow font-bold text-xs"
                                            title="Generar Liquidación">
                                            Liquidar
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-gray-500 italic text-center">No hay
                                        comitentes con saldos pendientes.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="m-4">{{ $comitentes_pendientes->links() }}</div>
                @endif

            </div>
        </div>
    </div>

    @if ($method === 'view')
        @livewire('admin.liquidaciones.modal-ver', ['id' => $id], key('modalver-liquidacion-' . $id))
    @elseif ($method == 'add')
        @livewire('admin.liquidaciones.modal', ['id' => $id, 'method' => $method, 'comitente_id' => $comitente_id_selected], key('modal-liquidacion-' . $id . '-' . $method))
    @elseif ($method === 'confirm-anular')
        <x-admin.confirm-anular-modal :id="$id" :method="$method" type="la liquidación"
            revertidoA="FACTURADO" />
    @endif
</div>
