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
                    <option value="comitente">Comitente</option>
                </select>
            </div>




        </div>


        @if ($tab === 'liquidaciones')
            <button
                class="border border-green-800 hover:text-gray-200 hover:bg-green-700 bg-green-600 px-2 py-0.5 rounded-lg text-white text-sm h-7 place-self-center flex items-center gap-x-2 cursor-pointer"
                wire:click="option('add')">
                <svg class="size-5 mr-0.5">
                    <use xlink:href="#agregar"></use>
                </svg>
                <span>
                    Nueva Liquidación Libre
                </span>
            </button>
        @endif

    </div>

    <!-- TABS -->
    <div class="flex border-b border-gray-400 mt-6 mx-4">
        <button wire:click="setTab('liquidaciones')"
            class="py-2 px-6 font-bold focus:outline-none transition-colors duration-200 {{ $tab === 'liquidaciones' ? 'border-b-4 border-cyan-600 text-cyan-800 bg-gray-200' : 'text-gray-600 hover:bg-gray-200 hover:text-cyan-700' }}">Historial
            Liquidaciones</button>
        <button wire:click="setTab('por_liquidar')"
            class="relative py-2 px-6 font-bold focus:outline-none transition-colors duration-200 {{ $tab === 'por_liquidar' ? 'border-b-4 border-cyan-600 text-cyan-800 bg-gray-200' : 'text-gray-600 hover:bg-gray-200 hover:text-cyan-700' }}">
            Comitentes por Liquidar
            @if (isset($pendientesCount) && $pendientesCount > 0)
                <span
                    class="absolute top-1 right-2 flex h-5 w-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white shadow-sm border border-white">{{ $pendientesCount }}</span>
            @endif
        </button>
    </div>










    <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600 mx-auto rounded-md shadow-md relative">
        <div class="min-w-full inline-block align-middle ">
            <div class="overflow-hidden">

                @if ($tab === 'liquidaciones')
                    <!-- TABLA HISTORIAL -->
                    <table class="min-w-full divide-y divide-gray-600">
                        <thead>
                            <tr
                                class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">
                                <th>ID (#)</th>
                                <th>Fecha</th>
                                <th>Comitente</th>
                                <th>Lotes (Ingresos)</th>
                                <th>Comisiones/Gastos</th>
                                <th>A Liquidar</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-400 text-gray-600 text-sm bg-gray-300">
                            @forelse($liquidaciones as $liquidacion)
                                <tr
                                    class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start">
                                    <td class="px-6 py-4 font-bold text-cyan-800">#{{ $liquidacion->numero }}</td>
                                    <td>{{ \Carbon\Carbon::parse($liquidacion->fecha)->format('d/m/Y') }}</td>
                                    <td>{{ $liquidacion->comitente->nombre ?? '' }}
                                        {{ $liquidacion->comitente->apellido ?? '' }}</td>
                                    <td class="text-green-700 font-semibold">+
                                        ${{ number_format($liquidacion->subtotal_lotes, 2, ',', '.') }}</td>
                                    <td class="text-red-700 font-semibold">-
                                        ${{ number_format($liquidacion->subtotal_comisiones + $liquidacion->subtotal_gastos, 2, ',', '.') }}
                                    </td>
                                    <td class="font-bold">${{ number_format($liquidacion->monto_total, 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="md:px-2 px-0.5 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                            {{ ucfirst($liquidacion->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 flex justify-center gap-2">
                                        <button wire:click="option('view', {{ $liquidacion->id }})"
                                            class="p-1 text-cyan-600 hover:bg-cyan-50 rounded" title="Ver Detalle">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
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
                                <th>Cantidad Lotes</th>
                                <th>Monto Martillo Estimado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-400 text-gray-600 text-sm bg-gray-300">
                            @forelse($comitentes_pendientes as $comitente)
                                <tr
                                    class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start hover:bg-gray-200">
                                    <td class="px-6 py-4 font-bold">{{ $comitente->nombre }}
                                        {{ $comitente->apellido }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="bg-blue-100 text-blue-800 font-bold px-2 py-1 rounded text-xs">{{ $comitente->Clotes->count() }}
                                            Lotes a Liquidar</span>
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-green-700">
                                        ${{ number_format($comitente->Clotes->sum('precio_final'), 2, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 flex justify-center gap-2">
                                        <button wire:click="option('add', null, {{ $comitente->id }})"
                                            class="px-3 py-1 bg-cyan-600 text-white hover:bg-cyan-700 rounded-md shadow flex items-center gap-1 font-bold text-xs"
                                            title="Generar Liquidación">
                                            Liquidar a Comitente
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

    @if ($method != '')
        @livewire('admin.liquidaciones.modal', ['id' => $id, 'method' => $method, 'comitente_id' => $comitente_id_selected], key('modal-liquidacion-' . $id . '-' . $method))
    @endif
</div>
