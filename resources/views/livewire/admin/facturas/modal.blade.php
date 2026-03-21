<x-modal>
    <div class="bg-gray-100 rounded-xl overflow-hidden shadow-2xl">
        <div class="bg-cyan-900 text-white px-6 py-4 flex justify-between items-center">
            <h2 class="text-xl font-bold">
                {{ $method == 'add' ? 'Generar Facturas desde Orden' : 'Detalle de Factura #' . $id }}
            </h2>
            <button wire:click="closeModal" class="text-white hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <div class="p-6 max-h-[80vh] overflow-y-auto">
            @if ($method == 'add')
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Buscar Orden (ID o Cliente)</label>
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="query"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-cyan-500 focus:ring-cyan-500 px-2"
                            placeholder="Ingrese ID de orden o nombre de adquirente...">

                        @if (!empty($ordenes))
                            <ul
                                class="absolute z-50 w-full bg-white border border-gray-200 rounded-lg shadow-xl mt-1 overflow-hidden">
                                @foreach ($ordenes as $orden)
                                    <li wire:click="seleccionarOrden({{ $orden->id }})"
                                        class="px-4 py-3 hover:bg-cyan-50 cursor-pointer border-b border-gray-100 last:border-0 flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-cyan-800">Orden #{{ $orden->id }}</span>
                                            <span class="text-gray-500 ml-2 text-sm">{{ $orden->adquirente->nombre }}
                                                {{ $orden->adquirente->apellido }}</span>
                                        </div>
                                        <span class="text-xs bg-gray-100 px-2 py-1 rounded">{{ $orden->estado }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                @if ($ordenSeleccionada)
                    <div class="bg-white rounded-lg p-5 border border-cyan-200 shadow-sm mb-6">
                        <h3 class="font-bold text-cyan-900 border-b pb-2 mb-4">Información de la Orden
                            #{{ $ordenSeleccionada->id }}</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                            <p><span class="text-gray-500">Adquirente:</span>
                                {{ $ordenSeleccionada->adquirente->nombre }}
                                {{ $ordenSeleccionada->adquirente->apellido }}</p>
                            <p><span class="text-gray-500">Subasta:</span>
                                {{ $ordenSeleccionada->subasta->titulo ?? 'N/A' }}</p>
                            <p><span class="text-gray-500">Items:</span> {{ $ordenSeleccionada->lotes->count() }} lotes
                            </p>
                            <p><span class="text-gray-500">Envío:</span>
                                ${{ number_format($ordenSeleccionada->monto_envio, 2) }}</p>
                        </div>
                        <button wire:click="generarFacturas" wire:loading.attr="disabled"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 rounded-lg transition-colors">
                            <span wire:loading.remove>CONFIRMAR Y GENERAR FACTURAS</span>
                            <span wire:loading>PROCESANDO...</span>
                        </button>
                    </div>
                @endif
            @else
                @if ($factura)
                    <div class="space-y-6">
                        <div class="flex justify-between border-b pb-4">
                            <div>
                                <p class="text-sm text-gray-500 uppercase">Adquirente</p>
                                <p class="font-bold text-lg text-gray-800">{{ $factura->nombre }}
                                    {{ $factura->apellido }}</p>
                                <p class="text-sm text-gray-600">{{ $factura->direccion }}</p>
                                <p class="text-sm text-gray-600">CUIT: {{ $factura->cuit }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-500 uppercase">Factura</p>
                                <p class="font-bold text-lg text-cyan-800">#{{ $factura->id }}</p>
                                <p class="text-sm text-gray-600">Fecha: {{ $factura->fecha }}</p>
                                <p class="text-sm font-bold text-orange-600 uppercase">
                                    {{ str_replace('_', ' ', $factura->tipo_concepto) }}</p>
                            </div>
                        </div>

                        <table class="w-full text-sm text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 font-bold border-b">
                                    <th class="py-2">Concepto</th>
                                    <th class="py-2 text-right">Monto</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($factura->items as $item)
                                    <tr>
                                        <td class="py-3">
                                            {{ $item->concepto }}
                                            @if ($item->lote)
                                                <span class="block text-xs text-gray-400">Lote #{{ $item->lote_id }}:
                                                    {{ $item->lote->titulo }}</span>
                                            @endif
                                        </td>
                                        <td class="py-3 text-right font-semibold">
                                            ${{ number_format($item->precio, 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="flex justify-end pt-4 border-t">
                            <div class="text-right">
                                <span class="text-gray-500 mr-4 font-bold">TOTAL:</span>
                                <span
                                    class="text-2xl font-black text-cyan-900">${{ number_format($factura->monto_total, 2, ',', '.') }}</span>
                            </div>
                        </div>

                        @if ($factura->cae)
                            <div class="bg-cyan-50 p-4 rounded-lg flex items-start gap-3 border border-cyan-100">
                                <svg class="w-6 h-6 text-cyan-700 mt-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>
                                </svg>
                                <div>
                                    <p class="text-cyan-900 font-bold">Información AFIP</p>
                                    <p class="text-cyan-800 text-sm">CAE: <span
                                            class="font-mono">{{ $factura->cae }}</span></p>
                                    <p class="text-cyan-800 text-sm">Vencimiento:
                                        {{ $factura->vto_cae ? $factura->vto_cae->format('d/m/Y') : '-' }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        </div>

        <div class="bg-gray-50 px-6 py-4 flex justify-center md:gap-5 gap-3 rounded-b-xl border-t">
            <button wire:click="closeModal"
                class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg font-bold text-sm">
                Cerrar
            </button>



            @if ($method == 'view' && $factura)
                <button wire:click="downloadFactura({{ $factura->id }})"
                    class="bg-cyan-600 hover:bg-cyan-700 text-white px-5 py-2 rounded-lg font-bold text-sm">
                    Descargar PDF
                </button>
            @endif


        </div>
    </div>
</x-modal>
