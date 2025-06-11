<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale">


    <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300" wire:click="close">
    </div>

    <div
        class = "border border-gray-500 md:max-w-[90%] lg:w-auto w-[90%]
        x-auto z-50 shadow-gray-400 shadow-md max-h-[95%] transition delay-150 duration-300 ease-in-out rounded-2xl ">

        <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
            <div class="flex  flex-col justify-center items-center  ">
                <h2
                    class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg bg-cyan-800">
                    Historial Lote {{ $id }}
                </h2>

                <div
                    class="w-full lg:w-auto  flex flex-col lg:grid lg:grid-cols-4 gap-2 lg:gap-x-6  text-base lg:px-3 px-2 text-gray-500  [&>div]:flex
                    [&>div]:flex-col  [&>div]:justify-start pt-2 max-h-[85vh] overflow-y-auto">

                    {{-- <x-form-item label="ID" :method="$lote_id ? 'view' : null" model="titulo" /> --}}

                    <x-form-item label="Titulo" method="view" model="titulo" />
                    <x-form-item-area label="Descripcion" method="view" model="descripcion" />
                    <x-form-item label="Valuación" method="view" model="valuacion" />
                    <x-form-item-sel label="Estado" method="view" model="estado">
                        <option value="">Sin estado</option>
                        @foreach ($estados as $item)
                            <option value="{{ $item['value'] }}">{{ $item['label'] }}</option>
                        @endforeach
                    </x-form-item-sel>

                    @if ($estado == 'vendido')
                        <x-form-item label="Adquirente" method="view" model="adquirente"
                            class="disabled:text-green-700" />
                        <x-form-item label="Precio final" method="view" model="precio_final"
                            class="disabled:text-green-700" />
                        <x-form-item label="Fecha" method="view" model="fecha" class="disabled:text-green-700" />
                        <x-form-item label="Subasta" method="view" model="subasta" class="disabled:text-green-700" />
                    @endif

                    <div class="min-w-full inline-block align-middle col-span-4 ">
                        <div class="overflow-hidden ">

                            <table class="min-w-full divide-y  divide-gray-600 ">
                                <caption class="caption-top text-gray-700">
                                    Listado de contratos {{ $contratosLotes->count() }}
                                </caption>
                                <thead>
                                    <tr
                                        class="bg-gray-400 relative font-bold divide-x-2 divide-gray-600  text-sm text-gray-900 text-center">
                                        <th class="py-1">Contrato</th>
                                        <th>Fecha</th>
                                        <th>Subasta</th>
                                        <th>Base</th>
                                        <th>Moneda</th>
                                        {{-- <th>Foto</th> --}}
                                        {{-- <th>Accion</th> --}}

                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300 text-gray-600  text-sm rounded-full">

                                    @foreach ($contratosLotes as $index => $item)
                                        <tr
                                            class="bg-gray-100 relative font-semibold divide-x-2 divide-gray-300 text-center [&>td]:lg:px-8 [&>td]:px-2 ">
                                            <td class="py-0.5">
                                                <a href="">
                                                    {{ $item->contrato_id }}
                                                </a>
                                            </td>
                                            <td>{{ $item->contrato->fecha_firma }} </td>
                                            <td>{{ $item->contrato->subasta_id }} </td>
                                            <td>{{ (int) $item->precio_base }} </td>
                                            <td>{{ $this->monedas[$item->moneda_id]->titulo ?? 'Sin moneda' }} </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>


                    @if ($lote->estado == 'en_subasta' || $lote->estado == 'vendido')

                        <div class="min-w-full inline-block align-middle col-span-4  mt-8">
                            <div class="overflow-hidden ">

                                <table class="min-w-full divide-y  divide-gray-600 ">
                                    <caption class="caption-top text-gray-700">
                                        Listado de pujas {{ $lote->pujas?->count() }}
                                    </caption>
                                    <thead>
                                        <tr
                                            class="bg-gray-400 relative font-bold divide-x-2 divide-gray-600  text-sm text-gray-900 text-center">
                                            <th class="py-1">ID</th>
                                            <th>Adquirente</th>
                                            <th>Alias</th>
                                            <th>Monto</th>
                                            <th>Subasta</th>
                                            <th>Fecha</th>
                                            {{-- <th>Accion</th> --}}

                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-300 text-gray-600  text-sm rounded-full">

                                        @foreach ($lote->pujas as $index => $item)
                                            @if ($lote->estado === 'vendido' && $index === 0)
                                                <tr
                                                    class="bg-gray-100 relative font-semibold divide-x-2 divide-gray-300 text-center text-green-600 [&>td]:lg:px-8 [&>td]:px-2">
                                                @else
                                                <tr
                                                    class="bg-gray-100 relative  divide-x-2 divide-gray-300 text-center [&>td]:lg:px-8 [&>td]:px-2">
                                            @endif

                                            <td class="py-0.5">
                                                <a href="">
                                                    {{ $item->id }}
                                                </a>
                                            </td>
                                            <td>{{ $item->adquirente?->nombre }}
                                                {{ $item->adquirente?->apellido }}</td>
                                            <td>{{ $item->adquirente?->alias?->nombre }}</td>
                                            <td>{{ (int) $item->monto }} </td>
                                            <td>{{ $item->subasta_id }} </td>
                                            <td>{{ $item->created_at }} </td>

                                            </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif

                    @if ($modal_foto)
                        {{-- <x-modal-foto :img="$modal_foto" /> --}}
                    @endif

                </div>



                <div
                    class="flex
                              !flex-row justify-between text-center lg:text-base text-sm lg:col-span-3 text-white ">
                    <div class="flex justify-center  w-full space-x-6">

                        <button type="button" wire:click="close"
                            class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 ">
                            Salir
                        </button>




                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
</div>
