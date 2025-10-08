<x-modal class="lg:max-w-[90%] lg:w-auto ">

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0 ">
        <div class="flex  flex-col justify-center items-center  max-h-[90vh]">
            <h2
                class="lg:text-2xl text-lg mb-1  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg bg-yellow-800">
                Orden
                <b> {{ $ordenSeleccionada->id }}

                </b>

            </h2>

            <div
                class="  w-full lg:w-auto  flex flex-col lg:grid lg:grid-cols-4 gap-2 lg:gap-x-6  text-base lg:px-3 px-2 text-gray-500  [&>div]:flex
                      [&>div]:flex-col  [&>div]:justify-start  max-h-[85vh] overflow-y-auto   relative">



                {{--  --}}
                <input type="hidden" wire:model="foto1" />
                <x-form-item label="Subasta" method="view" model="subasta" />
                <x-form-item label="Adquirente" method="view" model="adquirente" />
                <x-form-item label="Estado" method="view" model="estado" />
                <x-form-item label="Pago id" method="view" model="payment" />
                <x-form-item label="Fecha pago" method="view" model="fecha" />


                <div class=" flex justify-center mx-auto col-span-4">

                    <x-input-error for="tempLotes" class="top-full py-0 leading-[12px] text-red-500" />
                    {{-- <p>x</p> --}}
                </div>
                {{-- 
                <div>
                </div> --}}

                {{-- <div class="min-w-full inline-block align-middle "> --}}


                <div class="min-w-full inline-block align-middle col-span-4 ">
                    <div class="overflow-hidden ">



                        <table class="min-w-full divide-y  divide-gray-600 ">
                            <caption class="caption-top text-gray-700">
                                {{-- Listado de lotes {{ count($tempLotes) }} --}}
                            </caption>
                            <thead>
                                <tr
                                    class="bg-gray-400 relative font-bold divide-x-2 divide-gray-600  text-sm text-gray-900 text-center">
                                    <th class="py-1">ID</th>
                                    <th>Titulo</th>
                                    <th>Precio</th>
                                    <th>Moneda</th>
                                    <th>Foto</th>
                                    <th>Accion</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300 text-gray-600  text-sm rounded-full">

                                @foreach ($ordenSeleccionada->lotes as $index => $item)
                                    <tr
                                        class="bg-gray-100 relative font-bold divide-x-2 divide-gray-300 text-center [&>td]:lg:px-8 [&>td]:px-2 ">
                                        <td>{{ $item->lote->id }} </td>
                                        <td class="py-1">{{ $item->lote->titulo }} </td>
                                        <td>{{ number_format($item->precio_final, 0, ',', '.') }} </td>
                                        <td>{{ $this->monedas[$item->lote->moneda]->titulo ?? 'Sin moneda' }}
                                        </td>
                                        <td class="py-1 ">
                                            @if ($item->lote->foto1 && Storage::disk('public')->exists('imagenes/lotes/thumbnail/' . $item->lote->foto1))
                                                <img class="max-w-[50px] max-h-[50px] hover:cursor-pointer mx-auto hover:outline  hover:scale-110"
                                                    src="{{ Storage::url('imagenes/lotes/thumbnail/' . $item->lote->foto1) }}"
                                                    wire:click="$set('modal_foto', '{{ $item->lote->foto1 }}')">
                                            @else
                                                <img class="max-w-[50px] max-h-[50px]"
                                                    src="{{ Storage::url('imagenes/lotes/default.png') }}">
                                            @endif

                                        </td>
                                        <td>
                                            <div class="flex justify-center  text-white text-xs">

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 "
                                                    wire:click="quitar({{ $item->lote->foto1 }})">
                                                    <svg class="size-5 mr-0.5">
                                                        <use xlink:href="#eliminar"></use>
                                                    </svg>
                                                    <span class="hidden lg:block">Quitar</span>
                                                </button>


                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-gray-100  ">
                                    <td colspan="6" class="text-base font-semibold py-1 text-center">Subtotal :
                                        ${{ number_format($ordenSeleccionada->lotes->sum('precio_final'), 0, ',', '.') }}
                                    </td>
                                </tr>
                                @if ($deposito)
                                    <tr class="bg-gray-100  ">
                                        <td colspan="6" class="text-base font-semibold py-1 text-center">Depósito:
                                            -${{ number_format($deposito, 0, ',', '.') }}</td>
                                    </tr>
                                @endif

                                <tr class="bg-gray-100  ">
                                    <td colspan="6" class="text-lg font-bold py-1 text-center">Total:
                                        ${{ number_format($total ?? 0, 0, ',', '.') }}</td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>



                @if ($modal_foto)
                    <x-modal-foto :img="$modal_foto" />
                @endif

            </div>



            <div
                class="flex
                                !flex-row justify-between text-center lg:text-base text-sm lg:col-span-3 text-white ">
                <div class="flex justify-center  w-full lg:space-x-10 space-x-4">

                    <button type="button"
                        class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                        wire:click="$parent.$set('method',false)">
                        Cancelar
                    </button>


                    {{-- <button
                        class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                        wire:click="save">
                        Guardar
                    </button> --}}

                </div>


            </div>



        </div>

    </div>
    </div>
</x-modal>
