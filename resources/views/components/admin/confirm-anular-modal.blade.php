@props(['id', 'method', 'targetMethod' => 'anular', 'type' => 'esta operación', 'revertidoA' => 'estado anterior'])

@if ($method === 'confirm-anular')
    <x-modal class="bg-white shadow shadow-red-300">
        <div class="md:p-6 p-4">
            <div class="flex items-center md:gap-4 gap-2 mb-4">
                <div class="bg-red-100  p-2 rounded-full">
                    <svg class="size-7  text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="md:text-xl text-lg font-bold text-red-600">¿Confirmar Anulación?</h3>
            </div>
            <p class="text-gray-600 mb-6">
                Esta acción marcará {{ $type }} <span
                    class="font-bold text-gray-800">#{{ $id }}</span> como
                anulada. Los lotes asociados volverán al estado <span
                    class="font-bold text-cyan-700 uppercase">{{ $revertidoA }}</span>.
            </p>
            <div class="flex justify-end gap-8">
                <button wire:click="$set('method', '')"
                    class="md:px-4 px-2 md:py-2 py-1 text-gray-600 hover:bg-gray-300 rounded-md transition-colors bg-gray-200">
                    Cancelar
                </button>
                <button wire:click="{{ $targetMethod }}({{ $id }})"
                    class="md:px-4 px-2 md:py-2 py-1 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors shadow-sm font-bold">
                    Sí, Anular
                </button>
            </div>
        </div>
    </x-modal>
@endif
