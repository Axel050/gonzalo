<x-modal>


    {{-- HEADER --}}
    <div class="bg-cyan-900 text-white md:px-6 px-3 md:py-4 py-2 flex justify-between items-center">
        <h2 class="md:text-xl text-lg font-bold">
            {{ $step == 1 ? 'Seleccionar Órdenes' : 'Confirmar Facturación' }}
        </h2>

        <button wire:click="$dispatch('facturasGenerated')" class="hover:text-gray-300">
            ✕
        </button>
    </div>

    {{-- BODY --}}
    <div class="md:p-6 p-3 overflow-y-auto flex-1 min-h-0">

        {{-- ========================= --}}
        {{-- PASO 1 --}}
        {{-- ========================= --}}
        @if ($step == 1)

            <div class="relative md:mb-4 mb-3 z-50 ">
                <input type="text" wire:model.live.debounce.300ms="query"
                    class="w-full rounded border px-3 py-2 border-gray-400" placeholder="Buscar id orden o adquirente...">

                @if (!empty($ordenes) && count($ordenes) > 0)

                    <ul class="absoute w-full bg-white border mt-1 max-h-[500px] overflow-y-auto z-50 rounded shadow">

                        <li class="p-2 border-b bg-gray-50 flex gap-2">
                            <input type="checkbox" wire:model.live="selectAll">
                            <span class="text-sm font-bold">Seleccionar todas</span>
                        </li>

                        @foreach ($ordenes as $orden)
                            <li class="p-2 flex justify-between items-center
                                    {{ in_array($orden->id, $ordenesSeleccionadas) ? 'bg-cyan-50' : '' }}"
                                wire:key="orden-{{ $orden->id }}">

                                <div class="flex gap-2 items-center">
                                    <input type="checkbox" value="{{ $orden->id }}"
                                        wire:model.live="ordenesSeleccionadas">

                                    <span class="text-sm">
                                        <b>#{{ $orden->id }}</b> -
                                        {{ $orden->adquirente->nombre }} - {{ $orden->subasta?->titulo }}
                                    </span>
                                </div>

                                <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                    {{ $orden->estado }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @elseif(strlen($query) > 1)
                    <div class="flex justify-center ">
                        <span class="px-8 py-2 border rounded-2xl mt-3 bg-gray-100">
                            Sin resultados para <b> "{{ $query }}"</b>
                        </span>
                    </div>
                @endif
            </div>

            {{-- SELECCIONADAS --}}
            @if ($ordenesSeleccionadas)
                <div class="bg-white border rounded md:p-4 p-2">

                    <p class="font-bold md:text-lg text-sm md:mb-2 mb-1 ">
                        Seleccionadas {{ count($ordenesSeleccionadas) }}
                    </p>



                    <div class="flex  justify-center gap-5 md:gap-8">
                        <button wire:click="$parent.$set('method',false)"
                            class="md:mt-4 mt-2 w-fit bg-orange-600 hover:bg-orange-700 text-white md:py-2 py-1 rounded md:px-4 px-2">
                            Cancelar
                        </button>

                        <button wire:click="nextStep"
                            class="md:mt-4 mt-2 w-fit bg-green-600 hover:bg-green-700 text-white md:py-2 py-1 rounded md:px-4 px-2">
                            Continuar
                        </button>

                    </div>

                </div>
            @else
                <div class="flex justify-center">
                    <button wire:click="$parent.$set('method',false)"
                        class="mt-4 w-fit bg-orange-600 hover:bg-orange-700 text-white md:py-2 py-1.5 rounded md:px-4 px-2 mx-auto ">
                        Cancelar
                    </button>
                </div>
            @endif

        @endif

        {{-- ========================= --}}
        {{-- PASO 2 --}}
        {{-- ========================= --}}
        @if ($step == 2)

            <h3 class="font-bold md:text-lg text-base md:mb-4 mb-2">Resumen de Facturación</h3>

            @foreach ($this->resumen as $item)
                <div class="bg-white border rounded md:p-4 p-2 md:mb-2 mb-1">

                    <p class="font-bold text-cyan-800">
                        Orden #{{ $item['orden_id'] }}
                    </p>

                    <p class="text-sm">Martillo: ${{ number_format($item['total'], 0, ',', '.') }}</p>
                    <p class="text-sm">Comisión: ${{ number_format($item['comision'], 0, ',', '.') }}</p>
                    <p class="text-sm">Envío: ${{ number_format($item['envio'], 0, ',', '.') }}</p>

                    <p class="font-bold md:mt-2 mt-1">
                        Total: ${{ number_format($item['final'], 0, ',', '.') }}
                    </p>
                </div>
            @endforeach

            <div class="flex gap-4 md:mt-4 mt-2">
                <button wire:click="prevStep"
                    class="w-1/2 bg-gray-400 hover:bg-gray-500 text-white md:py-2 py-1 rounded">
                    ← Volver
                </button>

                <button wire:click="generarFacturas"
                    class="w-1/2 bg-green-600 hover:bg-green-700 text-white md:py-2 py-1 rounded">
                    CONFIRMAR
                </button>
            </div>

        @endif

    </div>

</x-modal>
