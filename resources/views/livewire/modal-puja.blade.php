<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale">

    <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300"
        wire:click="$parent.$set('modal',false)">
    </div>


    <div
        class = ' w-[75%]  z-50  shadow-gray-400 shadow-md max-h-[95%] 
   transition delay-150 duration-300 ease-in-out  rounded-2xl   flex justify-center bg-casa-base '>


        {{-- <x-modal> --}}





        <div class="flex flex-col w-full relative">



            <div class="flex  flex-col justify-center items-start  p-4 pb-6 bg-casa-base-2 w-full relative">

                <button class="text-casa-base absolute -top-12  -right-3   text-4xl font-bold"
                    wire:click="$parent.$set('modal',false)">X</button>

                <div class="flex justify-between w-full">
                    <h3 class="font-bold text-xl text-start">{{ $lote->titulo }}</h3>
                    @if (count($lote->pujas))
                        <x-hammer />
                    @else
                        <x-hammer-fix />
                    @endif
                </div>

                <div class="flex gap-x-4 justify-center my-2 w-full ">
                    <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}" class="size-30 " />
                </div>

                <div class="flex justify-between items-center mt-2  mb-1">
                    <ul class="flex gap-2 text-sm ">
                        <li class="px-2 py-1 rounded-full border border-casa-black"><a
                                href="{{ route('lotes.show', $lote['id']) }}">Lote: {{ $lote->id }}</a></li>
                        <li class="px-2 py-1 rounded-full border border-casa-black"><a
                                href="{{ route('subasta.lotes', $lote->ultimoContrato?->subasta_id) }}">Subasta:
                                {{ $lote->ultimoContrato?->subasta?->titulo }}</a></li>


                    </ul>

                    {{-- <x-hammer /> --}}


                </div>

                <p class="text-base ">Base: {{ $signo }}{{ $base }}</p>
                <p class="text-base font-bold">Oferta Actual: {{ $signo }}{{ $actual }}</p>
                <p class="text-base font-bold">Fraccion minima: {{ $signo }}{{ $lote->fraccion_min }}</p>




                @if ($adquirenteEsGanador)
                    @if ($subastaActiva)
                        <p
                            class="text-casa-black border border-black rounded-full px-4 py-0.5 w-full  text-base font-bold   items-center justify-center  mb-2 bg-casa-base  flex mt-2">
                            Ofertaste: <b class="ml-1">{{ $signo }}{{ $actual }}</b>
                        </p>
                    @else
                        <span
                            class="text-casa-black border border-black rounded-full px-4 py-0.5 text-base font-bold text-center order-1 mb-2 mt-2 w-full ">
                            Puja finalizada
                        </span>
                        <a href="{{ route('carrito') }}"
                            class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-0.5  w-full  text-base font-bold order-3 mt-0">
                            Pagar
                            <svg class="size-6 ">
                                <use xlink:href="#arrow-right"></use>
                            </svg>

                        </a>
                    @endif

                    <h2
                        class="text-casa-black border border-black rounded-full px-4 py-0.5 w-full  text-base font-bold   text-center  mt-2">
                        {{ $subastaActiva ? 'Tu puja es la última' : 'El lote es tuyo' }}
                    </h2>
                @else
                    @if ($subastaActiva)
                        <div class="flex flex-col gap-3 ">

                            <input type="number"
                                class="bg-base border border-casa-black text-casa-black rounded-full px-4 py-0.5 w-full text-base font-semibold  mt-2"
                                placeholder="Tu oferta" wire:model.live="oferta" />


                            {{-- wire:click="$parent.registrarPuja({{ $lote->id }} , {{ $actualParam }} , {{ $oferta }})" --}}
                            <button
                                class="bg-casa-black  border border-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-0.5 w-full  text-base font-bold "
                                wire:click="registrarPuja({{ $lote->id }} , {{ $actualParam }} ,{{ $oferta }})"
                                @disabled($loader)>

                                <span wire:show="!loader">
                                    Pujar
                                </span>

                                <span wire:show="loader">
                                    Procesando...
                                </span>

                                {{-- loteId, $ultimoMontoVisto, $monto --}}
                                {{-- <button
                                class="bg-casa-black border border-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between py-0.5 w-full text-base font-bold"
                                wire:click="$dispatch('registrarPuja', { loteId: {{ $lote->id }}, ultimoMontoVisto: {{ $actualParam }}, monto: {{ $oferta }} })"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove> Pujar </span>
                                <span wire:loading wire:target="registrarPuja"> Procesando... </span>
                            </button> --}}

                                {{-- <svg class="size-6 ">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                            --}}
                            </button>
                            <x-input-error-front for="puja.{{ $lote['id'] }}"
                                class="absolte bottom-0 text-red-500 order-4 text-lg" />
                        </div>
                    @else
                        <div class="flex flex-col gap-2 items-center w-full">
                            <span
                                class="text-casa-black border border-black rounded-full px-3 py-1 w-full text-lg font-bold text-center mt-2">
                                Puja finalizada
                            </span>
                            <span
                                class="text-casa-black border border-black rounded-full px-3 py-1 w-full text-lg font-bold text-center mt-1">
                                Alguien ofertó más
                            </span>
                        </div>
                    @endif
                @endif






                {{-- <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm">
                <button type="button" class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                    wire:click="$parent.$set('modal',false)">
                    Cancelar
                </button>

                @if ($method != 'view')
                            <button
                                class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                                wire:click="{{ $method }}">
                                {{ $btnText }}
                            </button>
                        @endif


            </div> --}}








            </div>

            @if (!empty($lote->ultimoConLote?->tiempo_post_subasta_fin))
                <div x-data="countdownTimer({
                    // El valor inicial se puede pasar aquí o leerlo desde el data attribute en init
                    loteId: '{{ $lote['id'] }}'
                })" {{-- Guardamos el valor dinámico en un atributo que Alpine puede leer --}}
                    data-end-time="{{ $lote->ultimoConLote?->tiempo_post_subasta_fin }}" x-init="init(); // Llama a init en la carga inicial
                    $wire.on('lotes-updated', () => {
                        console.log('Evento lotes-updated recibido para lote {{ $lote['id'] }}');
                    
                        // $nextTick espera a que Livewire termine de actualizar el DOM
                        // antes de ejecutar nuestro código. Esto es más seguro que setTimeout.
                        $nextTick(() => {
                            console.log('DOM actualizado, re-inicializando el timer para lote {{ $lote['id'] }}');
                            init(); // Llama a init de nuevo para leer el nuevo valor
                        });
                    })"
                    x-show="isValid && timeRemaining !== '00:00'" x-cloak>

                    <p
                        class="flex justify-between items-center bg-casa-black w-full  py-2     border-casa-black text-casa-base  px-3 text-sm  ">
                        Tiempo restante:
                        <span x-text="timeRemaining" class="text-white font-extrabold"></span>
                    </p>
                </div>
            @endif

        </div>







    </div>

</div>
