<div class="w-full py-5">

    <x-action-message on="devolucionCreated" class="absolute  top-0 right-0 z-50 green-action ">Devolucion creada con
        exitó.</x-action-message>
    <x-action-message on="devolucionUpdated" class="absolute  top-0 right-0 z-50 orange-action">Devolucion actualizada con
        exitó.</x-action-message>
    <x-action-message on="devolucionDeleted" class="absolute  top-0 right-0 z-50 red-action">Devolucion eliminada con
        exitó.</x-action-message>


    <div
        class="w-full flex flex-col md:flex-row md:gap-4 text-gray-700 md:items-center justify-between mx-auto bg-gray-300 lg:py-4 py-2 lg:px-6 px-2 rounded-md shadow-md">
        <div class="flex gap-2">
            <div>
                <label for="query" class="text-sm lg:text-base text-gray-600">Buscar</label>
                <input type="search" nombre="query" wire:model.live="query"
                    class="lg:h-7 h-6 rounded-md border border-gray-400 w-30 md:w-48 bg-gray-100 px-1 focus:outline-2 focus:outline-cyan-900">
            </div>

            <div class="text-xs flex gap-2 lg:gap-3">
                <select wire:model.live="searchType"
                    class="lg:h-7 h-6 rounded-md border border-gray-400 lg:w-full w-fit ml-auto text-gray-600 text-sm py-0.5 cursor-pointer bg-gray-200">
                    <option value="todos">Todos</option>
                    <option value="id">ID</option>
                    <option value="comitente">Comitente</option>
                </select>
            </div>
        </div>


    </div>

    <div
        class="flex border-b border-gray-400 md:mt-4 mt-3 mx-4 md:justify-start justify-between md:w-fit   md:gap-8 gap-4">

        <button wire:click="setTab('devoluciones')"
            class="md:w-fit w-1/2  py-0.5 md:py-2 px-3 md:px-6 md:text-base text-sm font-bold focus:outline-none transition-colors duration-200 {{ $tab === 'devoluciones' ? 'md:border-b-4 border-b-3 border-cyan-600 text-cyan-600' : 'text-gray-600 hover:text-cyan-600' }}">
            Historial
        </button>

        <button wire:click="setTab('por_devolver')"
            class="md:w-fit w-1/2  relative py-0.5 md:py-2 px-3 md:px-6 md:text-base text-sm font-bold focus:outline-none transition-colors duration-200 {{ $tab === 'por_devolver' ? 'md:border-b-4 border-b-3 border-cyan-600 text-cyan-600' : 'text-gray-600 hover:text-cyan-600' }}">
            Para Devolver
            @if (isset($pendientesCount) && $pendientesCount > 0)
                <span
                    class="absolute -top-1 -right-2 md:top-1  md:right-1 flex size-5 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white shadow-sm border border-white">{{ $pendientesCount }}</span>
            @endif
        </button>
    </div>

    <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600 mx-auto rounded-md shadow-md relative">
        <div class="min-w-full inline-block align-middle">
            <div class="overflow-hidden">
                @if ($tab === 'devoluciones')
                    <table class="min-w-full divide-y divide-gray-600">
                        <thead>
                            <tr
                                class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm">
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Comitente</th>
                                <th>Lotes</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-400 text-gray-600 text-sm bg-gray-300">
                            @forelse($devoluciones as $devolucion)
                                @php
                                    $lotesDevolucion =
                                        $devolucion->lotes->count() > 0
                                            ? $devolucion->lotes
                                            : collect([$devolucion->lote])->filter();
                                    $comitente = $lotesDevolucion->first()?->comitente;
                                @endphp
                                <tr
                                    class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start">
                                    <td class="font-bold text-cyan-800">#{{ $devolucion->id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($devolucion->fecha)->format('d/m/Y') }}</td>
                                    <td>{{ $comitente?->id }} -
                                        {{ $comitente?->nombre }}
                                        {{ $comitente?->apellido }}</td>
                                    <td>
                                        <span class=" text-gray-500">
                                            (#{{ $lotesDevolucion->pluck('id')->implode(', #') }})
                                        </span>
                                    </td>
                                    <td>{{ $devolucion->motivo?->nombre }}</td>
                                    <td>
                                        @if (($devolucion->estado ?? 'generada') === 'anulada')
                                            <span class="px-2 py-0.5 rounded bg-red-100 text-red-700 font-bold text-xs">
                                                ANULADA
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-0.5 rounded bg-green-100 text-green-700 font-bold text-xs">
                                                {{ strtoupper($devolucion->estado ?? 'generada') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 md:py-2 py-1.5 flex gap-1 items-center">
                                        <button wire:click="option('view', {{ $devolucion->id }})"
                                            class="p-1 text-cyan-600 hover:bg-cyan-50 rounded" title="Ver Detalle">
                                            <svg class="size-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>
                                        @if (($devolucion->estado ?? 'generada') !== 'anulada')
                                            <button wire:click="option('confirm-anular', {{ $devolucion->id }})"
                                                class="p-1 text-red-600 hover:bg-red-50 rounded cursor-pointer"
                                                title="Anular Devolución">
                                                <svg class="size-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-gray-500 italic text-center">No se
                                        encontraron devoluciones.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="m-4">{{ $devoluciones->links() }}</div>
                @else
                    <table class="min-w-full divide-y divide-gray-600">
                        <thead>
                            <tr
                                class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm">
                                <th>Comitente</th>
                                <th>Lotes standby</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-400 text-gray-600 text-sm bg-gray-300">
                            @forelse($comitentes_pendientes as $comitente)
                                <tr
                                    class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start hover:bg-gray-200">
                                    <td class="px-6 py-2 font-bold">
                                        {{ $comitente->id }} - {{ $comitente->nombre }} {{ $comitente->apellido }}
                                    </td>
                                    <td class="px-6 py-2">
                                        <span class="bg-yellow-100 text-yellow-800 font-bold px-2 py-1 rounded text-xs">
                                            {{ $comitente->Clotes->count() }}
                                        </span>
                                    </td>
                                    <td class="md:px-6 px-3  md:py-2 py-1">
                                        <button wire:click="option('add', null, {{ $comitente->id }})"
                                            class="px-3 py-1 bg-cyan-600 text-white hover:bg-cyan-700 rounded-md shadow font-bold text-xs"
                                            title="Generar Devolución">
                                            Devolver
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-10 text-gray-500 italic text-center">No hay
                                        comitentes con lotes standby.</td>
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
        @livewire('admin.devoluciones.modal-ver', ['id' => $id], key('modalver-devolucion-' . $id))
    @elseif ($method == 'add')
        @livewire('admin.devoluciones.modal', ['method' => $method, 'comitente_id' => $comitente_id_selected], key('modal-devolucion-' . $method . '-' . $comitente_id_selected))
    @elseif ($method === 'confirm-anular')
        <x-admin.confirm-anular-modal :id="$id" :method="$method" type="la devolución" revertidoA="STANDBY" />
    @endif
</div>
