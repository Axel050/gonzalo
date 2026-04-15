<x-modal>
    <div class="bg-cyan-900 text-white px-6 py-2 flex justify-between items-center">
        <h2 class="md:text-xl text-lg font-bold">Devolución #{{ $devolucion->id ?? '' }}</h2>
        <button wire:click="close" class="hover:text-gray-300">✕</button>
    </div>

    <div class="md:p-5 p-3 overflow-y-auto flex-1 min-h-0 md:space-y-4 space-y-2">
        @if ($devolucion)
            @php
                $lotes = $devolucion->lotes->count() > 0 ? $devolucion->lotes : collect([$devolucion->lote])->filter();
                $comitente = $lotes->first()?->comitente;
            @endphp
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <p class="text-sm text-gray-500">Comitente</p>
                    <p class="font-bold text-gray-800">{{ $comitente?->nombre }}
                        {{ $comitente?->apellido }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Fecha</p>
                    <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($devolucion->fecha)->format('d/m/Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Motivo</p>
                    <p class="font-bold text-gray-800">{{ $devolucion->motivo?->nombre }}</p>
                </div>

                @if ($devolucion->estado === 'anulada')
                    <div>
                        <p class="text-sm text-gray-500">Estado</p>
                        <p class="font-bold text-red-800">ANULADA</p>
                    </div>
                @endif

            </div>

            <div>
                <p class="text-sm font-bold text-gray-600 mb-1">Lotes devueltos</p>
                <ul class="text-sm text-gray-800 bg-gray-50 border rounded p-2 space-y-1">
                    @foreach ($lotes as $lote)
                        <li><b>#{{ $lote->id }}</b> - {{ $lote->titulo }}
                            @if ($lote->ultimoContrato?->subasta?->titulo)
                                ({{ $lote->ultimoContrato?->subasta?->titulo }})
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            @if ($devolucion->descripcion)
                <div>
                    <p class="text-sm font-bold text-gray-600">Descripción</p>
                    <p class="text-sm text-gray-800 p-2 bg-gray-50 rounded border">{{ $devolucion->descripcion }}</p>
                </div>
            @endif
        @endif
    </div>

    <div class="p-4 border-t flex justify-center gap-4 bg-gray-50">
        <button wire:click="close" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">Cerrar</button>
        <button wire:click="downloadPdf" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded">Descargar
            PDF</button>
    </div>
</x-modal>
