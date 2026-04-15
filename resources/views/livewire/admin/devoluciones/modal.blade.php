<x-modal class="lg:max-w-4xl lg:w-full">
    <div class="bg-gray-200 text-gray-700 rounded-xl">
        <div class="bg-cyan-800 text-white px-4 py-2 flex justify-between items-center rounded-t-xl">
            <h2 class="font-bold text-lg">Generar devolución</h2>
            <button wire:click="close" class="hover:text-gray-300">✕</button>
        </div>

        <div class="p-4 space-y-4 max-h-[80vh] overflow-y-auto">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">
                <div>
                    <label class="text-sm font-semibold text-gray-600">Comitente</label>
                    <select wire:model.live="comitente_id"
                        class="w-full h-9 rounded border border-gray-400 bg-gray-100 text-sm px-2">
                        <option value="">Seleccione</option>
                        @foreach ($comitentes as $comitente)
                            <option value="{{ $comitente->id }}">{{ $comitente->id }} - {{ $comitente->nombre }}
                                {{ $comitente->apellido }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="comitente_id" />
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600">Motivo</label>
                    <select wire:model="motivo_id"
                        class="w-full h-9 rounded border border-gray-400 bg-gray-100 text-sm px-2">
                        <option value="">Seleccione</option>
                        @foreach ($motivos as $motivo)
                            <option value="{{ $motivo->id }}">{{ $motivo->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="motivo_id" />
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-600">Fecha</label>
                    <input type="date" wire:model="fecha"
                        class="w-full h-9 rounded border border-gray-400 bg-gray-100 text-sm px-2">
                    <x-input-error for="fecha" />
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-gray-600">Descripción</label>
                <textarea wire:model="descripcion" rows="2"
                    class="w-full rounded border border-gray-400 bg-gray-100 text-sm px-2 py-1"></textarea>
            </div>

            <div class="border border-gray-400 rounded bg-white">
                <div class="bg-gray-300 px-3 py-2 font-bold text-sm">Lotes en standby para devolver</div>

                <div class="p-3 max-h-[45vh] overflow-y-auto">
                    @forelse($lotes_standby as $lote)
                        <label class="flex items-start gap-2 py-1 border-b border-gray-100">
                            <input type="checkbox" value="{{ $lote->id }}" wire:model="lotes_seleccionados"
                                class="mt-1 size-4">
                            <span class="text-sm">
                                <b>#{{ $lote->id }}</b> - {{ $lote->titulo }}
                                @if ($lote->ultimoContrato?->subasta?->titulo)
                                    ({{ $lote->ultimoContrato?->subasta?->titulo }})
                                @endif
                                {{-- <span class="text-gray-500">
                                    | Base: ${{ number_format($lote->ultimoConLote?->precio_base ?? 0, 0, ',', '.') }}
                                </span> --}}
                            </span>
                        </label>
                    @empty
                        <p class="text-sm text-gray-500 italic">No hay lotes en estado standby para este comitente.</p>
                    @endforelse
                </div>
                <x-input-error for="lotes_seleccionados" class="px-3 pb-2" />
            </div>
        </div>

        <div class="p-4 border-t bg-gray-100 flex justify-center gap-3 rounded-b-xl">
            <button wire:click="close"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-1 rounded">Cancelar</button>
            <button wire:click="save" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded">Guardar
                devolución</button>
        </div>
    </div>
</x-modal>
