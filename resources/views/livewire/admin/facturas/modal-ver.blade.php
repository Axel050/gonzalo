<x-modal>

    {{-- HEADER --}}
    <div class="bg-cyan-900 text-white px-6 py-2 flex justify-between items-center">
        <h2 class="md:text-xl text-lg font-bold">
            Factura #{{ $factura->id }}
        </h2>

        <button wire:click="$dispatch('facturasGenerated')" class="hover:text-gray-300">
            ✕
        </button>
    </div>

    {{-- BODY --}}
    <div class="md:p-6 p-3 overflow-y-auto flex-1 min-h-0 md:space-y-4 space-y-2">

        {{-- DATOS CLIENTE --}}
        <div class="border-b pb-4 flex justify-between">
            <div>
                <p class="text-sm text-gray-500 uppercase">Cliente</p>
                <p class="font-bold md:text-lg text-base">
                    {{ $factura->nombre }} {{ $factura->apellido }}
                </p>
                <p class="text-sm text-gray-600">
                    {{ $factura->cuit }}
                </p>
                <p class="text-sm text-gray-600">
                    {{ $factura->direccion }}
                </p>
            </div>

            <div class="text-right">
                <p class="text-sm text-gray-500 uppercase">Tipo</p>
                <p class="font-bold text-cyan-800 uppercase md:text-base text-sm">
                    {{ $factura->tipo_concepto }}
                </p>

                <p class="text-sm text-gray-600 mt-2">
                    {{ $factura->fecha }}
                </p>

                @if ($factura->estado === 'anulada')
                    <p class="text-sm text-red-600 mt-2 font-bold">ANULADA</p>
                @endif
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
                <tr class="text-left bg-gray-100">
                    <th class="py-2">Concepto</th>
                    <th class="py-2 text-right">Monto</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @foreach ($factura->items as $item)
                    <tr>
                        <td class="md:py-3 py-1.5 px-1 ">
                            {{ $item->concepto }}

                            @if ($item->lote)
                                <span class="block text-xs text-gray-400">
                                    Lote {{ $item->lote->titulo }}
                                </span>
                            @endif
                        </td>

                        <td class="md:py-3 py-1.5 px-1 text-right font-semibold">
                            ${{ number_format($item->precio, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- TOTAL --}}
        <div class="flex justify-end">
            <div class="text-right">
                <span class="text-gray-500 mr-3 font-bold">TOTAL:</span>
                <span class="md:text-2xl text-lg font-black text-cyan-900">
                    ${{ number_format($factura->monto_total, 0, ',', '.') }}
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
    <div class="p-4 border-t flex justify-center gap-4 bg-gray-50">

        <button wire:click="$dispatch('facturasGenerated')"
            class="bg-gray-400 hover:bg-gray-500 text-white md:px-4 px-2 md:py-2 py-1 rounded">
            Cerrar
        </button>

        <button wire:click="downloadFactura"
            class="bg-cyan-600 hover:bg-cyan-700 text-white md:px-4 px-2 md:py-2 py-1 rounded">
            Descargar PDF
        </button>

    </div>

</x-modal>
