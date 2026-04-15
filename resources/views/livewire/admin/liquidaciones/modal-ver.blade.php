<x-modal>
    {{-- HEADER --}}
    <div class="bg-emerald-900 text-white px-6  py-2 flex justify-between items-center">
        <h2 class="md:text-xl text-lg font-bold">
            Liquidación #{{ $liquidacion->id ?? '' }}
        </h2>
        <button wire:click="close" class="hover:text-gray-300">
            ✕
        </button>
    </div>

    {{-- BODY --}}
    <div class="md:p-5 p-3 overflow-y-auto flex-1 min-h-0 md:space-y-4 space-y-2">
        @if ($liquidacion)
            <div class="grid grid-cols-2 md:gap-4 gap-3 md:mb-6 mb-3">
                <div>
                    <p class="text-sm text-gray-500">Comitente</p>
                    <p class="font-bold text-gray-800">{{ $liquidacion->comitente->nombre ?? '' }}
                        {{ $liquidacion->comitente->apellido ?? '' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Fecha</p>
                    <p class="font-bold text-gray-800">
                        {{ \Carbon\Carbon::parse($liquidacion->fecha)->format('d/m/Y') }}</p>
                </div>


                {{-- <div>
                    <p class="text-sm text-gray-500">Estado</p>
                    <span
                        class="px-2 py-1 rounded text-xs font-bold bg-blue-100 text-blue-800">{{ strtoupper($liquidacion->estado) }}</span>
                </div> --}}
                <div>
                    <p class="text-sm text-gray-500">Tipo</p>
                    <span
                        class="px-2 py-1 rounded text-xs font-bold @if ($liquidacion->tipo_concepto == 'servicios') bg-red-100 text-red-800 @else bg-green-100 text-green-800 @endif">{{ strtoupper($liquidacion->tipo_concepto) }}</span>
                </div>

                @if ($liquidacion->estado == 'anulada')
                    <div>
                        <p class="text-sm text-gray-500">Estado</p>
                        <span
                            class="px-2 py-1 rounded text-xs font-bold bg-red-100 text-red-800">{{ strtoupper($liquidacion->estado) }}</span>
                    </div>
                @endif


            </div>

            <div class="mb-4">
                <h4 class="font-bold text-gray-700 border-b pb-2 md:mb-2 mb-1">Detalle </h4>
                <table class="w-full text-sm">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-2 text-left">Tipo</th>
                            <th class="p-2 text-left">Concepto</th>
                            <th class="p-2 text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($liquidacion->items as $item)
                            <tr class="border-b">
                                <td class="p-2">
                                    @if ($item->tipo == 'ingreso')
                                        <span class="text-green-600 font-bold">Ingreso</span>
                                    @elseif($item->tipo == 'egreso_comision')
                                        <span class="text-orange-600 font-bold">Comisión</span>
                                    @else
                                        <span class="text-red-600 font-bold">Gasto</span>
                                    @endif
                                </td>
                                <td class="p-2">{{ $item->concepto }}</td>
                                <td class="p-2 text-right font-semibold">
                                    @if ($item->tipo == 'ingreso')
                                        ${{ number_format($item->monto, 0, ',', '.') }}
                                    @else
                                        - ${{ number_format($item->monto, 0, ',', '.') }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-white md:p-4 p-2 rounded border flex flex-col gap-2 mb-4 shadow-sm">

                <div class="flex justify-between text-lg ">
                    <span class="font-bold text-gray-800">Total:</span>
                    <span
                        class="font-black text-blue-800">${{ number_format($liquidacion->monto_total, 0, ',', '.') }}</span>
                </div>
            </div>

            @if ($liquidacion->observaciones)
                <div>
                    <p class="text-sm font-bold text-gray-600">Observaciones:</p>
                    <p class="text-sm text-gray-800 p-2 bg-gray-50 rounded border">
                        {{ $liquidacion->observaciones }}</p>
                </div>
            @endif
        @endif
    </div>

    {{-- FOOTER --}}
    <div class="p-4 border-t flex md:justify-center justify-between gap-4 bg-gray-50">
        <button wire:click="close" class="bg-gray-400 hover:bg-gray-500 text-white md:px-4 px-2 md:py-2 py-1 rounded">
            Cerrar
        </button>
        <button wire:click="downloadPdf"
            class="bg-cyan-600 hover:bg-cyan-700 text-white md:px-4 px-2 md:py-2 py-1 rounded">
            Descargar PDF
        </button>
    </div>
</x-modal>
