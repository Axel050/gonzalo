<x-modal class=" lg:w-full lg:max-w-[800px]">
    <!-- Header -->
    <div class="flex justify-between items-center  rounded-t-lg shrink-0 bg-emerald-900 p-2">
        <h3 class="md:text-xl text-lg font-bold text-white">
            Nueva Liquidación
        </h3>
        <button wire:click="close" class="text-gray-400 hover:text-red-500 hover:bg-red-100 rounded p-1">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                </path>
            </svg>
        </button>
    </div>

    <!-- Scrollable content -->
    <div class="md:p-4 p-3 overflow-y-auto grow">


        <form wire:submit.prevent="save">
            <!-- Sección 1: Datos del Comitente -->
            <div class="bg-white md:p-4 p-2 rounded border border-gray-300 shadow-sm md:mb-4 mb-3">
                {{-- <h4 class="font-bold text-cyan-800 border-b pb-1 mb-2">1. Seleccionar Comitente</h4> --}}

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Comitente</label>
                        <select wire:model.live="comitente_id"
                            class="w-full rounded border border-gray-300 shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200">
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
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Comisión (%)
                            </label>
                            <input type="number" step="1" wire:model.live.debounce.500ms="comision_porcentaje"
                                class="w-full rounded border border-gray-300 shadow-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 px-2">
                        </div>
                    @endif
                </div>
            </div>

            @if ($comitente_id)
                <!-- Sección 2: Lotes para liquidar -->
                <div class="bg-white md:p-4 p-2 rounded border border-gray-300 shadow-sm md:mb-4 mb-3">
                    {{-- <h4 class="font-bold text-cyan-800 border-b pb-1 mb-2">Lotes a Liquidar</h4> --}}

                    @if (count($lotes_vendidos) > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-100 text-gray-600">
                                    <tr>
                                        <th class="md:p-2 p-1 w-8"></th>
                                        <th class="md:p-2 p-1">Lote</th>
                                        {{-- <th class="md:p-2 p-1">Estado</th> --}}
                                        <th class="md:p-2 p-1 text-right">Precio</th>
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
                                            {{-- <td class="p-2">
                                                <span
                                                    class="text-xs md:px-2 px-1 py-0.5 rounded bg-blue-100 text-blue-700">{{ strtoupper($lote->estado) }}</span>
                                            </td> --}}
                                            <td class="p-2 text-right font-bold text-green-700">
                                                ${{ number_format($lote->precio_final, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="p-4 text-center text-gray-500 bg-orange-50 rounded border border-orange-200">
                            No hay lotes facturados pendientes de liquidación para este comitente.
                        </div>
                    @endif
                </div>

                <!-- Sección 3: Gastos Extra -->
                <div class="bg-white md:p-4 p-2 rounded border border-gray-300 shadow-sm mb-2">
                    <div class="flex justify-between items-center border-b pb-1 mb-2">
                        <h4 class="font-bold text-cyan-800">Servicios / Gastos Extra</h4>
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
                                        class="w-full text-sm rounded border border-gray-300 py-1.5 focus:border-cyan-500 focus:ring focus:ring-cyan-200 px-2"
                                        placeholder="Descripción del gasto">
                                </div>
                                <div class="w-32">
                                    <label class="text-xs text-gray-500 block mb-1">Monto ($)</label>
                                    <input type="number" step="1"
                                        wire:model.live.debounce.500ms="gastos_extra.{{ $index }}.monto"
                                        class="w-full text-sm rounded border border-gray-300 py-1.5 focus:border-cyan-500 focus:ring focus:ring-cyan-200 px-2">
                                </div>
                                <button type="button" wire:click="quitarGasto({{ $index }})"
                                    class="mb-1 p-2 text-red-500 hover:bg-red-50 rounded" title="Eliminar Renglón">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                    <div class="mt-2 pt-2 border-t border-gray-200">
                        <label class="text-xs text-gray-600 font-bold block mb-1">Observaciones Generales de la
                            Liquidación</label>
                        <textarea wire:model.defer="observaciones" rows="2"
                            class="w-full rounded border border-gray-300 text-sm focus:border-cyan-500 focus:ring focus:ring-cyan-200 px-2"
                            placeholder="Nota adicional (opcional)..."></textarea>
                    </div>
                </div>

                <!-- Sección 4: Resumen Total -->
                <div
                    class="bg-gray-800 text-white md:p-4 p-3 rounded-lg shadow-lg flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div
                        class="flex-1 w-full grid grid-cols-2 md:grid-cols-4 md:gap-4 gap-2 text-sm divide-x divide-gray-600 [&>div]:px-2 items-center">
                        <div>
                            <p class="text-gray-300">Total Lotes</p>
                            <p class="font-bold text-green-400">+
                                ${{ number_format($subtotal_lotes, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-300">Comisión</p>
                            <p class="font-bold text-orange-400">-
                                ${{ number_format($subtotal_comisiones, 0, ',', '.') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-300">Gastos Extra</p>
                            <p class="font-bold text-red-400">-
                                ${{ number_format($subtotal_gastos, 0, ',', '.') }}</p>
                        </div>
                        <div class="bg-gray-700/50 md:p-2 p-1 rounded">
                            <p class="text-gray-300 font-bold text-xs">MONTO FINAL</p>
                            <p class="font-black md:text-xl text-base text-blue-300">
                                ${{ number_format($monto_total, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="shrink-0 md:mt-0 mt-2">
                        <button type="submit" @if (count($lotes_seleccionados) == 0) disabled @endif
                            class="bg-blue-600 hover:bg-blue-500 disabled:bg-gray-500 disabled:cursor-not-allowed text-white font-bold md:py-2 py-1   md:px-4 px-2 rounded-lg md:text-lg text-base shadow-md transition-all">
                            Generar Liquidación
                        </button>
                    </div>


                </div>
            @endif
        </form>

        <div class="flex w-full justify-center">
            <button wire:click="close"
                class=" hover:text-white hover:bg-red-600 rounded-xl p-1 bg-red-500 text-gray-100 w-fit px-6 mt-5 mb-2 mx-auto">
                Cancelar
            </button>
        </div>

    </div>




</x-modal>
