<x-modal class="lg:max-w-[80%] lg:w-auto ">

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} lotes
            </h2>

            <div
                class=" w-full  flex flex-col lg:grid lg:grid-cols-3 gap-2 lg:gap-x-12 llg:text-lg  text-base lg:px-10 px-2 text-gray-200  [&>div]:flex
                      [&>div]:flex-col   pt-4 max-h-[85vh] overflow-y-auto">




                @if ($method == 'delete')
                    <p class="text-center text-gray-600 lg:px-10 px-6"> Esta seguro de eliminar el contrato</p>
                    <p class="text-center text-gray-600"><strong>"{{ $deposito->comitente?->nombre }}
                            {{ $deposito->comitente?->apellido }}" </strong>?</p>
                @else
                    {{-- <x-form-item-sel label="Comitente" method="view" model="comitente_id">
                        <option>Elija comitente </option>
                        @foreach ($comitentes as $com)
                            <option value="{{ $com->id }}">
                                {{ $com->alias?->nombre }} - {{ $com->nombre }} {{ $com->apellido }} </option>
                        @endforeach
                    </x-form-item-sel> --}}

                    <x-form-item label="Comitente" method="view" model="comitente" />

                    <x-form-item label="Subasta" method="view" model="subasta_id" />

                    <x-form-item label="Contrato" method="view" model="contrato_id" />


                    {{-- <x-form-item-sel label="Contrato" method="view" model="contrato_id">
                        <option>Elija contrato </option>
                        @foreach ($subastas as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->id }}</option>
                        @endforeach
                    </x-form-item-sel> --}}




                    <x-form-item label="Titulo" :method="$method" model="titulo" />

                    <x-form-item label="Descripcion" :method="$method" model="descripcion" />



                    <x-form-item-sel label="Moneda" :method="$method" model="moneda_id">
                        <option>Elija moneda </option>
                        @foreach ($monedas as $mon)
                            <option value="{{ $mon->id }}">
                                {{ $mon->titulo }}
                            </option>
                        @endforeach
                    </x-form-item-sel>

                    <x-form-item label="Valuacion" :method="$method" model="valuacion" type="number" />

                    <x-form-item label="Base" :method="$method" model="base" type="number" />

                    <x-form-item label="Fraccion minima" :method="$method" model="fraccion_min" type="number" />

                    <x-form-item-sel label="Estado" :method="$method" model="estado">
                        <option>Elija estado </option>
                        <option value="pendiente">Pendiente</option>
                        <option value="disponible">Disponible</option>
                    </x-form-item-sel>



                    <x-form-item-sel label="Tipo de bien" :method="$method" model="tipo_bien_id" live="true">
                        <option>Elija tipo </option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                        @endforeach
                    </x-form-item-sel>

                    @if (!empty($caracteristicas) && (is_array($caracteristicas) || is_object($caracteristicas)))
                        @foreach ($caracteristicas as $item)
                            <x-form-item label="{{ $item->nombre }}" :method="$method"
                                model="formData.{{ $item->id }}" type="{{ $item->tipo }}" class="bg-red-100" />
                        @endforeach
                    @endif



                    <x-form-item-sel label="Venta directa" :method="$method" model="venta_directa" live="true">
                        <option value="0">No</option>
                        <option value="1">Si</option>
                    </x-form-item-sel>

                    <x-form-item label="Precio venta directa" :method="$method" model="precio_venta_directa"
                        type="number" wire:show="venta_directa == '1'" />


                    <div
                        class="  lg:col-span-3  col-span-1  !grid lg:grid-cols-3 grid-cols-1  [&>div]:flex
                      [&>div]:flex-col gap-2 lg:gap-x-12">

                        <x-form-item-imagen label="Foto 1" :method="$method" model="foto1" :foto="$foto1" w="150"
                            h="150" />

                        <x-form-item-imagen label="Foto 2" :method="$method" model="foto2" :foto="$foto2" w="150"
                            h="150" />

                        <x-form-item-imagen label="Foto 3" :method="$method" model="foto3" :foto="$foto3" w="150"
                            h="150" />


                    </div>




                @endif

                <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm lg:col-span-3">
                    <button type="button"
                        class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                        wire:click="$parent.$set('method',false)">
                        Cancelar
                    </button>

                    @if ($method != 'view')
                        <button
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                            wire:click="{{ $method }}">
                            {{ $btnText }}
                        </button>
                    @endif


                </div>

            </div>




        </div>
    </div>
</x-modal>
