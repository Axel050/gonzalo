<x-modal class="lg:max-w-[90%] lg:w-auto ">

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0 ">
        <div class="flex  flex-col justify-center items-center  max-h-[90vh]">
            <h2 class="lg:text-2xl text-lg mb-1  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg "
                style="{{ $bg }}">
                {{ $title }} Orden
            </h2>

            <div
                class="  w-full lg:w-auto  flex flex-col lg:grid lg:grid-cols-4 gap-2 lg:gap-x-6  text-base lg:px-3 px-2 text-gray-500  [&>div]:flex
                      [&>div]:flex-col  [&>div]:justify-start  max-h-[85vh] overflow-y-auto   relative">

                {{-- Campos comunes --}}
                @if ($method == 'add')
                    {{-- Campos para nueva orden --}}
                    <x-form-item-sel label="Subasta" :method="$method" model="subasta_id" live="true">
                        <option value="">Seleccione subasta</option>
                        @foreach ($subastas as $subasta)
                            <option value="{{ $subasta->id }}">{{ $subasta->titulo }}</option>
                        @endforeach
                    </x-form-item-sel>

                    <x-form-item-sel label="Adquirente" :method="$method" model="adquirente_id" live="true">
                        <option value="">Seleccione adquirente</option>
                        @foreach ($adquirentes as $adquirente)
                            <option value="{{ $adquirente->id }}">
                                {{ $adquirente->nombre }} {{ $adquirente->apellido }}
                            </option>
                        @endforeach
                    </x-form-item-sel>
                @else
                    {{-- Campos para edición --}}
                    <x-form-item label="Subasta" method="view" model="subasta" />
                    <x-form-item label="Adquirente" method="view" model="adquirente" />
                @endif

                <x-form-item-sel label="Estado" :method="$method" model="estado" live="true">
                    <option value="">Elija estado</option>
                    @foreach ($estados as $item)
                        <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                    @endforeach
                </x-form-item-sel>

                @if ($estado == 'cancelada')
                    <x-form-item-sel label="Motivo" :method="$method" model="motivo" live="true">
                        <option value="">Elija motivo</option>
                        @foreach ($motivos as $item)
                            <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                        @endforeach
                    </x-form-item-sel>
                @endif

                @if ($motivo == 'otro')
                    <x-form-item label="Otro" :method="$method" model="otroMotivo" />
                @endif

                <x-form-item label="Pago id" :method="$method" model="payment" />
                <x-form-item label="Fecha pago" :method="$method" model="fecha" />


                <div class = 'items-start  lg:w-60 w-[85%] mx-auto  b-[-6px] '>
                    <label class="w-full text-start text-gray-500 leading-[18px] text-base">Envio</label>
                    <div class="relative w-full ">

                        <input type ="number" wire:model.live.debounce.500ms="envio" step=1 min=0
                            class = 'lg:w-60 h-6 py-0 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600'
                            @disabled($method === 'view') />

                        <x-input-error for="envio" class="top-full py-0 leading-[12px] text-red-500" />
                    </div>
                </div>


                <div class = 'items-start  lg:w-60 w-[85%] mx-auto  b-[-6px] '>
                    <label class="w-full text-start text-gray-500 leading-[18px] text-base">Descuento</label>
                    <div class="relative w-full ">

                        <input type ="number" wire:model.live.debounce.500ms="deposito" step=1 min=0
                            class = 'lg:w-60 h-6 py-0 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600'
                            @disabled($method === 'view') />

                        <x-input-error for="deposito" class="top-full py-0 leading-[12px] text-red-500" />
                    </div>
                </div>







                {{-- Buscador de lotes SOLO para creación nueva --}}
                @if ($method == 'add')
                    <div class="relative flex justify-center mx-auto items-center col-span-4"
                        wire:click.outside="$set('si',false)">

                        <input type="search" wire:model.live="search" @disabled($subasta_id <= 0)
                            class="lg:w-80 p-2 border rounded bg-white h-7 ml-0.5 mx-auto disabled:cursor-not-allowed"
                            placeholder="Buscar lotes disponibles en subasta ..." />

                        @if (!empty($lotes))
                            <ul class="absolute top-full z-10 w-full bg-white border border-gray-300 rounded-b max-h-60 overflow-y-auto shadow-lg"
                                wire:show="si">
                                @foreach ($lotes as $lote)
                                    <li class="p-2 hover:bg-gray-100 cursor-pointer shadow flex gap-2 items-center"
                                        wire:click="loteSelected({{ $lote->id }})">
                                        @if ($lote->foto1 && Storage::disk('public')->exists('imagenes/lotes/thumbnail/' . $lote->foto1))
                                            <img class="max-w-[50px] max-h-[50px]"
                                                src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}">
                                        @else
                                            <img class="max-w-[50px] max-h-[50px]"
                                                src="{{ Storage::url('imagenes/lotes/default.png') }}">
                                        @endif
                                        {{ $lote->titulo }} -
                                        ${{ number_format($lote->ultimoConLote?->precio_base, 0, ',', '.') }}
                                    </li>
                                @endforeach
                                @if (strlen($search) > 1 && count($lotes) === 0)
                                    <li class="pl-2 font-semibold text-center text-red-900">¡¡Sin resultados!!</li>
                                @endif
                            </ul>
                        @endif


                    </div>
                @endif

                {{-- Mensajes de error --}}
                <div class="flex justify-center mx-auto col-span-4">
                    <x-input-error for="tempLotes" class="top-full py-0 leading-[12px] text-red-500" />
                </div>

                {{-- Tabla de lotes --}}
                <div class="min-w-full inline-block align-middle col-span-4">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-600">
                            <caption class="caption-top text-gray-700">
                                Listado de lotes ({{ count($tempLotes) }})
                            </caption>
                            <thead>
                                <tr
                                    class="bg-gray-400 relative font-bold divide-x-2 divide-gray-600 text-sm text-gray-900 text-center">
                                    <th class="py-1">ID</th>
                                    <th>Titulo</th>
                                    <th>Precio</th>
                                    <th>Moneda</th>
                                    <th>Foto</th>
                                    @if ($method == 'update' || $method == 'add')
                                        <th>Accion</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300 text-gray-600 text-sm rounded-full">
                                @forelse ($tempLotes as $index => $item)
                                    <tr
                                        class="bg-gray-100 relative font-bold divide-x-2 divide-gray-300 text-center [&>td]:lg:px-8 [&>td]:px-2">
                                        <td>{{ $item['lote']['id'] }}</td>
                                        <td class="py-1">{{ $item['lote']['titulo'] }}</td>
                                        <td>${{ number_format($item['precio_final'], 0, ',', '.') }}</td>
                                        <td> {{ $item['moneda_titulo'] ?? 'Sin moneda' }}</td>
                                        <td class="py-1">
                                            @if ($item['lote']['foto1'] && Storage::disk('public')->exists('imagenes/lotes/thumbnail/' . $item['lote']['foto1']))
                                                <img class="max-w-[50px] max-h-[50px] hover:cursor-pointer mx-auto hover:outline hover:scale-110"
                                                    src="{{ Storage::url('imagenes/lotes/thumbnail/' . $item['lote']['foto1']) }}"
                                                    wire:click="$set('modal_foto', '{{ $item['lote']['foto1'] }}')">
                                            @else
                                                <img class="max-w-[50px] max-h-[50px]"
                                                    src="{{ Storage::url('imagenes/lotes/default.png') }}">
                                            @endif
                                        </td>


                                        @if ($method == 'update' || $method == 'add')
                                            <td>
                                                <div class="flex justify-center text-white text-xs">
                                                    <button
                                                        class="hover:text-gray-200 hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1"
                                                        wire:click="quitar({{ $item['lote']['id'] }})">
                                                        <svg class="size-5 mr-0.5">
                                                            <use xlink:href="#eliminar"></use>
                                                        </svg>
                                                        <span class="hidden lg:block">Quitar</span>
                                                    </button>
                                                </div>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-gray-500">
                                            @if ($method == 'add')
                                                No hay lotes agregados. Use el buscador para agregar lotes.
                                            @else
                                                No hay lotes en esta orden.
                                            @endif
                                        </td>
                                    </tr>
                                @endforelse

                                {{-- Totales --}}
                                @if (count($tempLotes) > 0)
                                    <tr class="bg-gray-100">
                                        <td colspan="6" class="text-base font-semibold py-1 text-center">
                                            Subtotal: ${{ number_format($subtotal, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @if ($deposito > 0)
                                        <tr class="bg-gray-100">
                                            <td colspan="6" class="text-base font-semibold py-1 text-center">
                                                Depósito: -${{ number_format($deposito, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif
                                    @if ($envio > 0)
                                        <tr class="bg-gray-100">
                                            <td colspan="6" class="text-base font-semibold py-1 text-center">
                                                Envio: ${{ number_format($envio, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr class="bg-gray-100">
                                        <td colspan="6" class="text-lg font-bold py-1 text-center">
                                            Total: ${{ number_format($total, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($modal_foto)
                    <x-modal-foto :img="$modal_foto" />
                @endif
            </div>

            {{-- Botones de acción --}}
            <div
                class="flex !flex-row justify-between text-center lg:text-base text-sm lg:col-span-3 text-white w-full">
                <div class="flex justify-center w-full lg:space-x-10 space-x-4">
                    <button type="button"
                        class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5"
                        wire:click="$parent.$set('method',false)">
                        Cancelar
                    </button>

                    @if ($method == 'add')
                        <button
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center"
                            wire:click="create">
                            Crear Orden
                        </button>
                    @elseif($method == 'update')
                        <button
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center"
                            wire:click="update">
                            Guardar
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-modal>
