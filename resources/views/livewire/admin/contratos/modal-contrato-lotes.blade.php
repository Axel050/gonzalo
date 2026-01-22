<x-modal class="lg:max-w-[90%] lg:w-auto ">





    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0 relative">


        <x-action-message on="loteUpdated" class="absolute  top-0 right-0 z-50 green-action ">
            Lote agregado con exitó.
        </x-action-message>

        <x-action-message on="loteContrato" class="absolute  top-0 right-0 z-50 green-action ">
            Lote agregado con exitó.
        </x-action-message>



        <div class="flex  flex-col justify-center items-center  max-h-[90vh]">
            <h2
                class="lg:text-2xl text-lg mb-1  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg bg-yellow-800">
                Lotes contrato
                <b> {{ $contrato->id }} </b> - <b>{{ $contrato->comitente?->nombre }}
                    {{ $contrato->comitente?->apellido }}

                </b>

            </h2>



            @if ($method == 'update')
                @livewire('admin.lotes.modal', ['method' => $method, 'id' => $lote_id_modal], key('modal-contrato-lotes-' . $id))
            @endif




            <div
                class="  w-full lg:w-auto  flex flex-col lg:grid lg:grid-cols-5 gap-2 lg:gap-x-6  text-base lg:px-3 px-2 text-gray-500  [&>div]:flex
                      [&>div]:flex-col  [&>div]:justify-start  max-h-[85vh] overflow-y-auto   relative ">





                <div class="!flex-row  w-full  !justify-between lg:!hidden ">
                    <label>Subasta: {{ $contrato->subasta_id }}</label>
                    <label>Fecha contrato: {{ $contrato->fecha_firma }}</label>
                </div>

                <div
                    class="bg-whte px-6 lg:py-2 py-1 rounded-lg shadow-lg  text-accent  relative mb-2   !flex-row !justify-between mx-auto col-span-5  lg:w-full ">

                    <label class="order-1 hidden lg:inline-block">Subasta : {{ $contrato->subasta_id }}</label>
                    <label class="order-4 hidden lg:inline-block">Fecha contrato: {{ $contrato->fecha_firma }}</label>


                    <div class="relative flex
                        justify-center mx-auto order-2 items-center"
                        wire:click.outside="$set('si',false)">


                        <input type="search" wire:model.live="search"
                            class="lg:w-80  p-2 border rounded bg-white h-7 ml-0.5 mx-auto"
                            placeholder="Buscar lotes..." />
                        @if (!empty($lotes))
                            <ul class="absolute top-full z-10 w-full bg-white border border-gray-300 rounded-b  max-h-60 overflow-y-auto shadow-lg "
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
                                        {{ $lote->titulo }}
                                    </li>
                                @endforeach
                                @if (strlen($search) > 1 && count($lotes) === 0)
                                    <li class="pl-2 font-semibold text-center text-red-900 ">¡¡Sin
                                        resultados!!
                                    </li>
                                @endif
                            </ul>
                        @endif

                        {{-- @if (strlen($search) > 1 && count($lotes) === 0)
                            <span wire:show="si" class="absolute top-full z-10 lg:w-80 bg-white border border-gray-300 rounded-b   shadow-lg">
                                No
                            </span>
                        @endif --}}

                        <button wire:click="limpiar" wire:show="lote_id"
                            class=" px-2   rounded-2xl py-0 text-xs   bg-red-600 h-6 text-white  w-fit hover:bg-red-700 ml-4 order-3 lg:self-start">Limpiar
                        </button>

                    </div>





                </div>



                {{--  --}}
                <input type="hidden" wire:model="foto1" />
                <x-form-item label="Titulo" :method="$lote_id ? 'view' : null" model="titulo" />
                <x-form-item-area label="Descripcion" :method="$lote_id ? 'view' : null" model="descripcion" />

                <x-form-item label='Valuacion' :method="$method" model="valuacion" type="number" live="true" />

                <x-form-item label='Base' :method="$method" model="precio_base" type="number" />
                <x-form-item-sel label='Moneda' :method="$method" model="moneda_id">
                    @foreach ($monedas as $mon)
                        <option value="{{ $mon->id }}">{{ $mon->titulo }}</option>
                    @endforeach
                </x-form-item-sel>

                <div class="col-span-5 flex  !flex-row lg:!justify-center !justify-around  lg:gap-x-20">
                    <button wire:click="add"
                        class="bg-yellow-600 hover:bg-yellow-700 mt-4 rounded-lg lg:px-6 px-1.5 lg:py-1 py-0.5  text-white">Agregar</button>
                    <button wire:click="addComplete" @disabled($lote_id)
                        class="bg-cyan-900 hover:bg-cyan-950 mt-4 rounded-lg lg:px-6 px-1.5 lg:py-1 py-0.5  text-white disabled:opacity-50 disabled:cursor-not-allowed">Guardar
                        y completar</button>
                </div>

                <div class=" flex justify-center mx-auto col-span-5">

                    <x-input-error for="tempLotes" class="top-full py-0 leading-[12px] text-red-500" />
                    {{-- <p>x</p> --}}
                </div>
                {{-- 
                <div>
                </div> --}}

                {{-- <div class="min-w-full inline-block align-middle "> --}}


                <div class="min-w-full inline-block align-middle col-span-5 overflow-x-auto ">


                    <table class="min-w-full divide-y  divide-gray-600 ">
                        <caption class="caption-top text-gray-700">
                            Listado de lotes {{ count($tempLotes) }}
                        </caption>
                        <thead>
                            <tr
                                class="bg-gray-400 relative font-bold divide-x-2 divide-gray-600  text-sm text-gray-900 text-center">
                                <th class="py-1">ID</th>
                                <th>Titulo</th>
                                <th>Descripción</th>
                                <th>Valuación</th>
                                <th>Base</th>
                                <th>Moneda</th>
                                <th>Foto</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-300 text-gray-600  text-sm rounded-full">

                            @foreach ($tempLotes as $index => $item)
                                <tr
                                    class="bg-gray-100 relative font-bold divide-x-2 divide-gray-300 text-center [&>td]:lg:px-8 [&>td]:px-2 ">
                                    <td>{{ $item['id'] }} </td>
                                    <td class="py-1">{{ $item['titulo'] }} </td>
                                    <td>{{ $item['descripcion'] }} </td>
                                    <td>{{ (int) $item['valuacion'] }} </td>
                                    <td>{{ (int) $item['precio_base'] }} </td>
                                    <td>{{ $this->monedas[$item['moneda_id']]->titulo ?? 'Sin moneda' }}</td>
                                    <td class="py-1 ">

                                        @if ($item['foto1'] && Storage::disk('public')->exists('imagenes/lotes/thumbnail/' . $item['foto1']))
                                            <img class="max-w-[50px] max-h-[50px] hover:cursor-pointer mx-auto hover:outline  hover:scale-110"
                                                src="{{ Storage::url('imagenes/lotes/thumbnail/' . $item['foto1']) }}"
                                                wire:click="$set('modal_foto', '{{ $item['foto1'] }}')">
                                        @else
                                            <img class="max-w-[50px] max-h-[50px]"
                                                src="{{ Storage::url('imagenes/lotes/default.png') }}">
                                        @endif

                                    </td>
                                    <td>
                                        <div class="flex justfy-end lg:gap-x-6 gap-x-3 text-white text-xs">

                                            <button
                                                class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 "
                                                wire:click="quitar({{ $index }})">
                                                <svg class="size-5 mr-0.5">
                                                    <use xlink:href="#eliminar"></use>
                                                </svg>
                                                <span class="hidden lg:block">Quitar</span>
                                            </button>

                                            <button
                                                class=" hover:text-gray-200 hover:bg-orange-700 flex items-center py-0.5 bg-orange-600 rounded-lg px-1 "
                                                wire:click="editar({{ $index }})">
                                                <svg class="size-5 mr-0.5">
                                                    <use xlink:href="#editar"></use>
                                                </svg>
                                                <span class="hidden lg:block">Editar</span>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                </div>



                @if ($modal_foto)
                    <x-modal-foto :img="$modal_foto" />
                @endif

            </div>


            @error('tieneDatos')
                <div class ='flex items-center text-base text-red-600  '>

                    <svg class="w-4 h-3.5 mr-1">
                        <use xlink:href="#error-icon"></use>
                    </svg>
                    <p class="lg:max-w-200 leading-[12px]">
                        {{ $message }}
                    </p>
                </div>
            @enderror

            <div
                class="flex
                                !flex-row justify-between text-center lg:text-base text-sm lg:col-span-3 text-white ">
                <div class="flex justify-center  w-full lg:space-x-10 space-x-4">

                    <button type="button"
                        class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                        wire:click="$parent.$set('method',false)">
                        Cancelar
                    </button>


                    <button
                        class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                        wire:click="save">
                        Guardar
                    </button>



                    <button
                        class="bg-cyan-700 hover:bg-cyan-800 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                        wire:click="save(true)">
                        Guardar y enviar mail
                    </button>
                </div>


            </div>



        </div>

    </div>
    </div>
</x-modal>
