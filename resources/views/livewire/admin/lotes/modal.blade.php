<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale">


    <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300" {{-- wire:click="$parent.$set('method',false)" --}}
        {{-- wire:click="dispatch('mi-evento'); set('method', false)" --}} wire:click="cerrar">

    </div>

    <div
        class =' border  border-gray-500     lg:w-auto w-[90%] x-auto  z-50  shadow-gray-400 shadow-md max-h-[95%] 
                                                        transition delay-150 duration-300 ease-in-out  rounded-2xl '>





        <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
            <div class="flex  flex-col justify-center items-center  ">
                <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                    style="{{ $bg }}">
                    {{ $title }} lote {{ $lote->id }}
                </h2>

                <div
                    class=" w-full  flex flex-col lg:grid lg:grid-cols-4 gap-2 lg:gap-x-12 llg:text-lg  text-base lg:px-10 px-2 text-gray-200  [&>div]:flex
                      [&>div]:flex-col   pt-4 max-h-[85vh] overflow-y-auto">




                    @if ($method == 'delete')
                        <p class="text-center text-gray-600 lg:px-10 px-6 col-span-4"> Esta seguro de eliminar el lote
                            <b>{{ $lote->id }}</b>?
                        </p>
                    @else
                        <x-form-item label="Titulo" :method="$method" model="titulo" />

                        <x-form-item label="Comitente" method="view" model="comitente" />

                        <x-form-item label="Subasta" method="view" model="subasta_id" />

                        <x-form-item label="Contrato" method="view" model="contrato_id" />


                        {{--  --}}
                        <x-form-item-sel label="Tipo de bien" :method="$method" model="tipo_bien_id" live="true">
                            <option>Elija tipo </option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }} </option>
                            @endforeach
                        </x-form-item-sel>


                        @if (!empty($caracteristicas) && (is_array($caracteristicas) || is_object($caracteristicas)))
                            @foreach ($caracteristicas as $item)
                                @if ($item->tipo == 'file')
                                    {{-- <x-form-item-file label="{{ $item->nombre }} {{ $item->id }}" :method="$method"
                                    model="formData.{{ $item->id }}" class="bg-red-300" /> --}}
                                    <div class = 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] '>

                                        <div class=" leading-[16px]">
                                            <label class="w-full text-start text-gray-500 leading-[16px] text-base ">
                                                {{ $item->nombre }}
                                            </label>


                                            @php
                                                $url = '';
                                                $exists = false;
                                                if ($formData[$item->id] ?? null) {
                                                    if (method_exists($formData[$item->id], 'temporaryUrl')) {
                                                        // $url = $formData[$item->id]->temporaryUrl();
                                                        $url = true;
                                                    } elseif (
                                                        is_string($formData[$item->id]) &&
                                                        Storage::disk('public')->exists($formData[$item->id])
                                                    ) {
                                                        $url = Storage::url($formData[$item->id]);
                                                        $exists = true;
                                                    }
                                                }
                                            @endphp

                                            @if ($url && $method != 'view')
                                                <button
                                                    class="rounded-full px-2  bg-red-600 ml-4 text-xs hover:bg-red-800 mb-[2px] leading-[14px] h-[15px]"
                                                    title="quitar audio" wire:click="deleteAudio({{ $item->id }})">
                                                    <span class="font-bold mr-2 text-xs">X</span>Quitar
                                                </button>
                                            @endif

                                        </div>

                                        <div class="relative w-full  text-center ">
                                            {{-- @if ($url) --}}
                                            <audio controls
                                                class="h-6 text-xs my-0 w-full border border-gray-400 rounded-lg"
                                                wire:key="audio-{{ $item->id }}-{{ md5($url) }}">
                                                @if ($exists)
                                                    <source src="{{ $url }}?t={{ time() }}"
                                                        {{-- type="{{ pathinfo($formData[$item->id], PATHINFO_EXTENSION) === 'mp3' ? 'audio/mpeg' : 'audio/wav' }}"> --}}>
                                                @endif
                                                Tu
                                            </audio>

                                            {{-- @endif --}}



                                            <input type ="file" wire:model="formData.{{ $item->id }}"
                                                id="sound" accept=".wav,.mp3,.m4a,.wma"
                                                class="hidden lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600      "
                                                @disabled($method === 'view') />
                                            @if ($method == 'update')
                                                <button @click="document.getElementById('sound').click()"
                                                    class="text-gray-100 rounded-xl text-xs px-8 py-0.5 bg-cyan-900 hover:bg-cyan-950 mx-auto">
                                                    Seleccionar audio</button>
                                            @endif

                                            {{-- @dump($formData) --}}
                                            <x-input-error for=""
                                                class="top-full py-0 leading-[12px] text-red-500" />
                                        </div>
                                    </div>
                                @elseif($item->tipo == 'select')
                                    <x-form-item-sel label="{{ $item->nombre }}" :method="$method"
                                        model="formData.{{ $item->id }}">
                                        <option value="">Elija opción</option>
                                        @foreach ($item->opciones as $opt)
                                            <option value="{{ $opt->valor }}">{{ $opt->valor }}</option>
                                        @endforeach
                                    </x-form-item-sel>
                                @else
                                    <x-form-item label="{{ $item->nombre }}" :method="$method"
                                        model="formData.{{ $item->id }}" type="{{ $item->tipo }}" />
                                @endif
                            @endforeach
                        @endif

                        {{--  --}}

                        <x-form-item-area label="Descripcion" :method="$method" model="descripcion" />

                        <x-form-item label="Valuacion" :method="$method" model="valuacion" type="number" />

                        <x-form-item label="Base" :method="$method" model="base" type="number" />

                        <x-form-item-sel label="Moneda" :method="$method" model="moneda_id">
                            <option value="">Elija moneda </option>
                            @foreach ($monedas as $mon)
                                <option value="{{ $mon->id }}">
                                    {{ $mon->titulo }}
                                </option>
                            @endforeach
                        </x-form-item-sel>


                        <x-form-item label="Fraccion minima" :method="$method" model="fraccion_min" type="number" />

                        <x-form-item-sel label="Estado" :method="$method" model="estado">
                            <option>Elija estado </option>
                            @foreach ($estados as $item)
                                <option value="{{ $item['value'] }}"> {{ $item['label'] }} </option>
                            @endforeach
                        </x-form-item-sel>




                        <x-form-item-sel label="Venta directa" :method="$method" model="venta_directa" live="true">
                            <option value="0">No</option>
                            <option value="1">Si</option>
                        </x-form-item-sel>

                        <x-form-item label="Precio venta directa" :method="$method" model="precio_venta_directa"
                            type="number" wire:show="venta_directa == '1'" />

                        {{-- <x-form-item label="Destacado" :method="$method" model="destacado" typ="number" /> --}}
                        <div class="items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] mt-1.5">
                            <label class="w-full text-start text-gray-500  leading-[16px] text-base">
                                Destacado
                            </label>
                            <div class="relative w-full   text-gray-600 flex pl-18 gap-x-10 lg:gap-x-14  text-base">

                                <div class="flex  items-center ">
                                    <input type="radio" wire:model="destacado" value="0" name="destacado"
                                        class ="h-6 rounded-md border border-gray-400 w-4 text-gray-500 p-1 text-sm bg-gray-100 mr-0.5  "
                                        @disabled($method == 'view') />
                                    No
                                </div>

                                <div class="flex   items-center">
                                    <input type="radio" wire:model="destacado" value="1" name="destacado"
                                        class ="h-6 rounded-md border border-gray-400 w-4 text-gray-500 pl-1 text-sm bg-gray-100 mr-0.5"
                                        @disabled($method == 'view') />Si
                                </div>


                            </div>
                        </div>



                        <div
                            class="  lg:col-span-4  col-span-1  !grid lg:grid-cols-4 grid-cols-1  [&>div]:flex
                      [&>div]:flex-col gap-2 lg:gap-x-12 ">

                            <x-form-item-imagen label="Foto 1" :method="$method" model="foto1" :foto="$foto1"
                                w="150" h="150" folder="lotes/thumbnail/" required="true" />

                            <x-form-item-imagen label="Foto 2" :method="$method" model="foto2" :foto="$foto2"
                                w="150" h="150" folder="lotes/thumbnail/" />

                            <x-form-item-imagen label="Foto 3" :method="$method" model="foto3" :foto="$foto3"
                                w="150" h="150" folder="lotes/thumbnail/" />

                            <x-form-item-imagen label="Foto 4" :method="$method" model="foto4" :foto="$foto4"
                                w="150" h="150" folder="lotes/thumbnail/" />

                        </div>




                    @endif

                    <div class="flex !flex-row gap-6 !justify-center lg:text-base text-sm lg:col-span-4  mt-60">

                        <div class=" flex justify-center gap-x-5 lg:gap-x-8">


                            <button type="button"
                                class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                                {{-- wire:click="$parent.$set('method',false)" --}} wire:click="cerrar">
                                Cancelar
                            </button>

                            @if ($method != 'view')
                                <button
                                    class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                                    wire:click="{{ $method }}" title="Salir">
                                    {{ $btnText }}
                                </button>
                            @endif

                            @if ($method == 'view')
                                <button
                                    class="bg-cyan-700 hover:bg-cyan-800 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                                    wire:click="$set('historial',{{ $lote->id }})" title="Ver historial">
                                    Historial
                                </button>

                                <button
                                    class="bg-indigo-800 hover:bg-indigo-900 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                                    wire:click="$set('qr',{{ $lote->id }})" title="Ver QR">
                                    QR
                                </button>

                                <div wire:ignore.self>

                                    @if ($qr)
                                        @livewire('admin.lotes.modal-qr', ['id' => $id], key('modal-contrato-lotes-qr-' . $id))
                                    @endif
                                </div>

                                <div wire:ignore.self>

                                    @if ($historial)
                                        @livewire('admin.lotes.modal-history', ['id' => $lote->id, 'index' => false], key('modal-contrato-lotes-history-' . $lote->id))
                                    @endif
                                </div>


                            @endif

                        </div>
                    </div>

                </div>




            </div>
        </div>
        {{-- </x-modal> --}}
    </div>
</div>
