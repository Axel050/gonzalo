<x-modal>

    {{-- HEADER --}}
    <div class="bg-cyan-900 text-white px-6 py-4 flex justify-between items-center">
        <h2 class="text-xl font-bold">
            Factura #{{ $factura->id }}
        </h2>

        <button wire:click="$dispatch('facturasGenerated')" class="hover:text-gray-300">
            ✕
        </button>
    </div>

    {{-- BODY --}}
    <div class="p-6 overflow-y-auto flex-1 min-h-0 space-y-4">

        {{-- DATOS CLIENTE --}}
        <div class="border-b pb-4 flex justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase">Cliente</p>
                <p class="font-bold text-lg">
                    {{ $factura->nombre }} {{ $factura->apellido }}
                </p>
                <p class="text-sm text-gray-600">CUIT: {{ $factura->cuit }}</p>
                <p class="text-sm text-gray-600">{{ $factura->direccion }}</p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-500 uppercase">Tipo</p>
                <p class="font-bold text-cyan-800 uppercase">
                    {{ $factura->tipo_concepto }}
                </p>

                <p class="text-sm text-gray-600 mt-2">
                    Fecha: {{ $factura->fecha }}
                </p>
            </div>
        </div>

        {{-- ORDENES ASOCIADAS --}}
        @if ($factura->ordenes && $factura->ordenes->count())
            <div class="flex gap-3">
                <p class="text-sm text-gray-500 uppercase mb-1">Órdenes incluidas : </p>
                <div class="flex flex-wrap gap-2">
                    @foreach ($factura->ordenes as $orden)
                        <span class="bg-gray-100 px-2 py-1 rounded text-xs">
                            #{{ $orden->id }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- ITEMS --}}
        <table class="w-full text-sm border-t border-b">
            <thead>
                <tr class="text-left bg-gray-50">
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
                                <span class="block text-xs text-gray-400">
                                    Lote {{ $item->lote->titulo }}
                                </span>
                            @endif
                        </td>

                        <td class="py-3 text-right font-semibold">
                            ${{ number_format($item->precio, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- TOTAL --}}
        <div class="flex justify-end">
            <div class="text-right">
                <span class="text-gray-500 mr-3 font-bold">TOTAL:</span>
                <span class="text-2xl font-black text-cyan-900">
                    ${{ number_format($factura->monto_total, 2, ',', '.') }}
                </span>
            </div>
        </div>

        {{-- AFIP --}}
        @if ($factura->cae)
            <div class="bg-cyan-50 p-4 rounded border text-sm">
                <p><b>CAE:</b> {{ $factura->cae }}</p>
                <p><b>Vencimiento:</b>
                    {{ $factura->vto_cae ? $factura->vto_cae->format('d/m/Y') : '-' }}
                </p>
            </div>
        @endif

    </div>

    {{-- FOOTER --}}
    <div class="p-4 border-t flex justify-end gap-2 bg-gray-50">

        <button wire:click="$dispatch('facturasGenerated')"
            class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded">
            Cerrar
        </button>

        <button wire:click="downloadFactura" class="bg-cyan-600 hover:bg-cyan-700 text-white px-4 py-2 rounded">
            Descargar PDF
        </button>

    </div>

</x-modal>
