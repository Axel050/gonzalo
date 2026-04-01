<div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75 overflow-y-auto">
    <div class="bg-gray-100 rounded-lg shadow-xl w-full max-w-4xl mx-4 my-8 relative flex flex-col max-h-[90vh]">
        <!-- Header -->
        <div class="flex justify-between items-center p-4 border-b border-gray-300 bg-gray-200 rounded-t-lg shrink-0">
            <h3 class="text-xl font-bold text-gray-800">
                {{ $method === 'view' ? 'Ver Liquidación #' . ($liquidacionVisualizar->numero ?? '') : 'Nueva Liquidación' }}
            </h3>
            <button wire:click="close" class="text-gray-500 hover:text-red-500 hover:bg-red-100 rounded p-1">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Scrollable content -->
        <div class="p-6 overflow-y-auto grow">

            @if ($method === 'view')
                @if ($liquidacionVisualizar)
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Comitente</p>
                            <p class="font-bold text-gray-800">{{ $liquidacionVisualizar->comitente->nombre }}
                                {{ $liquidacionVisualizar->comitente->apellido }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Fecha</p>
                            <p class="font-bold text-gray-800">
                                {{ \Carbon\Carbon::parse($liquidacionVisualizar->fecha)->format('d/m/Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Estado</p>
                            <span
                                class="px-2 py-1 rounded text-xs font-bold bg-blue-100 text-blue-800">{{ strtoupper($liquidacionVisualizar->estado) }}</span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Comisión</p>
                            <p class="font-bold text-gray-800">{{ $liquidacionVisualizar->comision_porcentaje }}%</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-bold text-gray-700 border-b pb-2 mb-2">Detalle de Renglones</h4>
                        <table class="w-full text-sm">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="p-2 text-left">Tipo</th>
                                    <th class="p-2 text-left">Concepto</th>
                                    <th class="p-2 text-right">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($liquidacionVisualizar->items as $item)
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
                                                ${{ number_format($item->monto, 2, ',', '.') }}
                                            @else
                                                - ${{ number_format($item->monto, 2, ',', '.') }}
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="bg-white p-4 rounded border flex flex-col gap-2 mb-4 shadow-sm">
                        <div class="flex justify-between border-b pb-1 text-sm">
                            <span class="text-gray-600">Subtotal Lotes:</span>
                            <span
                                class="font-bold text-green-700">${{ number_format($liquidacionVisualizar->subtotal_lotes, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-1 text-sm">
                            <span class="text-gray-600">Comisión:</span>
                            <span class="font-bold text-orange-700">-
                                ${{ number_format($liquidacionVisualizar->subtotal_comisiones, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-1 text-sm">
                            <span class="text-gray-600">Gastos Extra:</span>
                            <span class="font-bold text-red-700">-
                                ${{ number_format($liquidacionVisualizar->subtotal_gastos, 2, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-lg mt-2">
                            <span class="font-bold text-gray-800">Total a Liquidar:</span>
                            <span
                                class="font-black text-blue-800">${{ number_format($liquidacionVisualizar->monto_total, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    @if ($liquidacionVisualizar->observaciones)
                        <div>
                            <p class="text-sm font-bold text-gray-600">Observaciones:</p>
                            <p class="text-sm text-gray-800 p-2 bg-gray-50 rounded border">
                                {{ $liquidacionVisualizar->observaciones }}</p>
                        </div>
                    @endif
                @endif
            @else
                <form wire:submit.prevent="save">
                    <!-- Sección 1: Datos del Comitente -->
                    <div class="bg-white p-4 rounded border border-gray-300 shadow-sm mb-6">
                        <h4 class="font-bold text-cyan-800 border-b pb-2 mb-4">1. Seleccionar Comitente</h4>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Comitente</label>
                                <select wire:model.live="comitente_id"
                                    class="w-full rounded border-gray-300 shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200">
                                    <option value="">-- Seleccione un Comitente --</option>
                                    @foreach ($comitentes as $comi)
                                        <option value="{{ $comi->id }}">{{ $comi->nombre }} {{ $comi->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('comitente_id')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            @if ($comitente_id)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Comisión Pactada
                                        (%)</label>
                                    <input type="number" step="0.01"
                                        wire:model.live.debounce.500ms="comision_porcentaje"
                                        class="w-full rounded border-gray-300 shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200">
                                    <span class="text-xs text-gray-500">Puede modificar este valor solo para esta
                                        liquidación.</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if ($comitente_id)
                        <!-- Sección 2: Lotes para liquidar -->
                        <div class="bg-white p-4 rounded border border-gray-300 shadow-sm mb-6">
                            <h4 class="font-bold text-cyan-800 border-b pb-2 mb-4">2. Lotes a Liquidar</h4>

                            @if (count($lotes_vendidos) > 0)
                                <div class="overflow-x-auto">
                                    <table class="w-full text-sm text-left">
                                        <thead class="bg-gray-100 text-gray-600">
                                            <tr>
                                                <th class="p-2 w-8">Sel</th>
                                                <th class="p-2">Lote</th>
                                                <th class="p-2">Estado</th>
                                                <th class="p-2 text-right">Precio Final</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($lotes_vendidos as $lote)
                                                <tr class="border-b hover:bg-gray-50">
                                                    <td class="p-2 text-center">
                                                        <input type="checkbox" wire:model.live="lotes_seleccionados"
                                                            value="{{ $lote->id }}"
                                                            class="rounded text-cyan-600 shadow-sm focus:border-cyan-300 focus:ring focus:ring-offset-0 focus:ring-cyan-200 focus:ring-opacity-50">
                                                    </td>
                                                    <td class="p-2">{{ $lote->titulo }} (Lote #{{ $lote->id }})
                                                    </td>
                                                    <td class="p-2">
                                                        <span
                                                            class="text-xs px-2 py-0.5 rounded bg-blue-100 text-blue-700">{{ strtoupper($lote->estado) }}</span>
                                                    </td>
                                                    <td class="p-2 text-right font-bold text-green-700">
                                                        ${{ number_format($lote->precio_final, 2, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div
                                    class="p-4 text-center text-gray-500 bg-orange-50 rounded border border-orange-200">
                                    No hay lotes vendidos pendientes de liquidación para este comitente.
                                </div>
                            @endif
                        </div>

                        <!-- Sección 3: Gastos Extra -->
                        <div class="bg-white p-4 rounded border border-gray-300 shadow-sm mb-6">
                            <div class="flex justify-between items-center border-b pb-2 mb-4">
                                <h4 class="font-bold text-cyan-800">3. Servicios / Gastos Extra</h4>
                                <button type="button" wire:click="agregarGasto"
                                    class="px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 text-xs font-bold rounded">
                                    + Agregar Gasto
                                </button>
                            </div>

                            @if (count($gastos_extra) > 0)
                                @foreach ($gastos_extra as $index => $gasto)
                                    <div class="flex gap-2 items-end mb-3">
                                        <div class="grow">
                                            <label class="text-xs text-gray-500 block mb-1">Concepto (Ej: Restauración,
                                                Flete)</label>
                                            <input type="text"
                                                wire:model.live.debounce.500ms="gastos_extra.{{ $index }}.concepto"
                                                class="w-full text-sm rounded border-gray-300 py-1.5 focus:border-cyan-500 focus:ring focus:ring-cyan-200"
                                                placeholder="Descripción del gasto">
                                        </div>
                                        <div class="w-32">
                                            <label class="text-xs text-gray-500 block mb-1">Monto ($)</label>
                                            <input type="number" step="0.01"
                                                wire:model.live.debounce.500ms="gastos_extra.{{ $index }}.monto"
                                                class="w-full text-sm rounded border-gray-300 py-1.5 focus:border-cyan-500 focus:ring focus:ring-cyan-200">
                                        </div>
                                        <button type="button" wire:click="quitarGasto({{ $index }})"
                                            class="mb-1 p-2 text-red-500 hover:bg-red-50 rounded"
                                            title="Eliminar Renglón">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-sm text-gray-500 italic">No hay gastos extra aplicados.</p>
                            @endif

                            <div class="mt-4 pt-4 border-t border-gray-100">
                                <label class="text-xs text-gray-600 font-bold block mb-1">Observaciones Generales de la
                                    Liquidación</label>
                                <textarea wire:model.defer="observaciones" rows="2"
                                    class="w-full rounded border-gray-300 text-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200"
                                    placeholder="Nota adicional (opcional)..."></textarea>
                            </div>
                        </div>

                        <!-- Sección 4: Resumen Total -->
                        <div
                            class="bg-gray-800 text-white p-5 rounded-lg shadow-lg flex flex-col md:flex-row gap-4 items-center justify-between">
                            <div
                                class="flex-1 w-full grid grid-cols-2 md:grid-cols-4 gap-4 text-sm divide-x divide-gray-600 [&>div]:px-2">
                                <div>
                                    <p class="text-gray-400">Total Lotes</p>
                                    <p class="font-bold text-green-400">+
                                        ${{ number_format($subtotal_lotes, 2, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-400">Comisión</p>
                                    <p class="font-bold text-orange-400">-
                                        ${{ number_format($subtotal_comisiones, 2, ',', '.') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-400">Gastos Extra</p>
                                    <p class="font-bold text-red-400">-
                                        ${{ number_format($subtotal_gastos, 2, ',', '.') }}</p>
                                </div>
                                <div class="bg-gray-700/50 p-2 rounded -my-2">
                                    <p class="text-gray-300 font-bold text-xs">MONTO FINAL A PAGAR</p>
                                    <p class="font-black text-xl text-blue-300">
                                        ${{ number_format($monto_total, 2, ',', '.') }}</p>
                                </div>
                            </div>

                            <div class="shrink-0 mt-4 md:mt-0">
                                <button type="submit" @if (count($lotes_seleccionados) == 0) disabled @endif
                                    class="bg-blue-600 hover:bg-blue-500 disabled:bg-gray-500 disabled:cursor-not-allowed text-white font-bold py-2 px-6 rounded-lg text-lg shadow-md transition-all">
                                    Generar Liquidación
                                </button>
                            </div>
                        </div>
                    @endif
                </form>
            @endif
        </div>
    </div>
</div>
