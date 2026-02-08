<x-modal class="lg:max-w-[90%] lg:w-auto ">





    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0 relative">



        <div class="flex  flex-col justify-center items-center  max-h-[90vh]">
            <h2
                class="lg:text-2xl text-lg mb-1  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg bg-purple-950">
                Pujas subasta
                <b> {{ $subasta->id }} </b> - <b>{{ $subasta->titulo }} </b>
            </h2>


            <div
                class="  w-full lg:w-auto  flex flex-col lg:grid lg:grid-cols-5 gap-2 lg:gap-x-6  text-base p-4 text-gray-500  [&>div]:flex
                      [&>div]:flex-col  [&>div]:justify-start  max-h-[85vh] overflow-y-auto   relative  ">



                <div class="min-w-full inline-block align-middle col-span-5 overflow-x-auto ">


                    <table class="min-w-full divide-y  divide-gray-600 ">
                        <caption class="caption-top text-gray-700">
                            {{-- Listado de lotes {{ count($tempLotes) }} --}}
                        </caption>
                        <thead>
                            <tr
                                class="bg-gray-400 relative font-bold divide-x-2 divide-gray-600  text-sm text-gray-900 text-center [&>th]:px-1">
                                <th class="py-1">ID puja</th>
                                <th>Lote ID</th>
                                <th>Titulo</th>
                                <th>Descripción</th>
                                <th>Monto</th>
                                <th>Adquirente</th>
                                <th>Cant</th>
                                <th>Foto</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300 text-gray-600  text-sm rounded-full">

                            @foreach ($lotes as $lote)
                                @if ($lote->ultimaPuja)
                                    <tr
                                        class="bg-gray-100 relative font-bold divide-x-2 divide-gray-300 text-center [&>td]:lg:px-8 [&>td]:px-2 ">
                                        <td>{{ $lote->ultimaPuja->id }} </td>
                                        <td class="py-1">{{ $lote->id }} </td>
                                        <td>{{ $lote->titulo }} </td>
                                        <td>{{ $lote->descripcion }} </td>
                                        <td>${{ $lote->ultimaPuja->monto }}</td>
                                        <td>{{ $lote->ultimaPuja->adquirente->nombre ?? '—' }}</td>
                                        <td>{{ $lote->pujas?->count() }} </td>
                                        {{-- <td>{{ $this->monedas[$lote['moneda_id']]->titulo ?? 'Sin moneda' }}</td> --}}
                                        <td class="py-1 ">

                                            @if ($lote->foto1 && Storage::disk('public')->exists('imagenes/lotes/thumbnail/' . $lote->foto1))
                                                <img class="max-w-[50px] max-h-[50px] hover:cursor-pointer mx-auto hover:outline  hover:scale-110"
                                                    src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto1']) }}"
                                                    wire:click="$set('modal_foto', '{{ $lote->foto1 }}')">
                                            @else
                                                <img class="max-w-[50px] max-h-[50px]"
                                                    src="{{ Storage::url('imagenes/lotes/default.png') }}">
                                            @endif

                                        </td>
                                        <td>
                                            {{ $lote->ultimaPuja->created_at->format('d/m/Y H:i') }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>

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
                        Salir
                    </button>

                </div>


            </div>



        </div>

    </div>
    </div>
</x-modal>
