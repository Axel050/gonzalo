<div class="flex flex-col justify-center items-center hvh w-full  pt-0  ">



    {{-- <article class="bg-red-00 flex idden  w-full justify-center flex-col mt-10 mb-8">        
        <svg fill="#fff" class="w-[247px] h-[47px] mx-auto mb-2">
            <use xlink:href="#tuslotes"></use>
        </svg>
        <h3 class="font-helvetica font-semibold text-3xl leading-[1] tracking-normal text-center mt-4 mb-2 ">Estos son
            lotes que agregaste a tu carrito.
        </h3>
        <p class="text-center text-3xl">Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna.</p>



    </article> --}}




    <div class="grid grid-cols-3 px-20 mt-10 gap-12 mb-2">

        @if (isset($lotes) && count($lotes))
            @foreach ($lotes as $lote)
                <div class="flex flex-col ">


                    <div class="w-full bg-casa-base-2 flex flex-col p-6  gap-y-1 border border-casa-black relative">


                        {{-- <button class="font-semibold text-xl w-full text-end -mt-2 " wire:click="quitar({{ $lote['id'] }})"
                        title="Quitar del carrito">X</button> --}}
                        <button class="font-semibold text-xs w-full text-end -mt-2 "
                            wire:click="quitar({{ $lote['id'] }})" title="Quitar del carrito">X</button>

                        {{-- <a href="{{ route('lotes.show', $lote['id']) }}"
                        class="font-bold text-3xl w-full  mb-1">{{ $lote['titulo'] }}</a> --}}
                        <a href="{{ route('lotes.show', $lote['id']) }}"
                            class="font-bold text-lg w-full  mb-1">{{ $lote['titulo'] }}</a>



                        <div class="flex gap-x-4 justify-center my-2">

                            {{-- <img src="{{ Storage::url('imagenes/lotes/normal/' . $lote->foto1) }}" class="size-49  obje " /> --}}
                            <img src="{{ Storage::url('imagenes/lotes/normal/' . $lote->foto1) }}"
                                class="size-10  obje " />

                        </div>


                        <div class="flex justify-between items-center mt-2">
                            <ul class="flex gap-4 text-sm">
                                <li class="px-3 py-2 rounded-full border border-casa-black"><a
                                        href="{{ route('lotes.show', $lote['id']) }}">Lote: {{ $lote->id }}</a></li>
                                <li class="px-3 py-2 rounded-full border border-casa-black"><a
                                        href="{{ route('subasta.lotes', $lote->ultimoContrato?->subasta_id) }}">Subasta:
                                        {{ $lote->ultimoContrato?->subasta?->titulo }}</a></li>


                            </ul>

                            <x-hammer />


                        </div>


                        @php
                            $actual =
                                optional($lote->getPujaFinal())->monto !== null
                                    ? (int) $lote->getPujaFinal()->monto
                                    : 0;

                            if (is_int($actual)) {
                                $actual = number_format($actual, 0, ',', '.');
                            }

                            $signo = $this->getMonedaSigno($lote->moneda);
                        @endphp

                        <p class="text-xl  mt-auto">Base:
                            {{ $signo }}{{ number_format($lote['precio_base'], 0, ',', '.') }}
                        </p>


                        <p class="text-xl font-semibold mb-3">Oferta
                            actual: {{ $signo }}{{ $actual }}
                        </p>

                        <p class="text-xl  mb-2">Fraccion minima:
                            {{ $signo }}{{ number_format($lote['fraccion_min'], 0, ',', '.') }}</p>



                        @php
                            $adquirenteEsGanador = $lote?->getPujaFinal()?->adquirente_id === $adquirente?->id;
                            $subastaActiva = \Carbon\Carbon::parse(
                                $lote->ultimoConLote?->tiempo_post_subasta_fin ??
                                    $lote->ultimoContrato?->subasta->fecha_fin,
                            )->gte(now());
                        @endphp

                        @if ($adquirenteEsGanador)
                            @if ($subastaActiva)
                                <p
                                    class="text-casa-black border border-black rounded-full px-4 py-2 flex items-center justify-center w-full text-xl mb-2 bg-casa-base">
                                    Ofertaste: <b class="ml-1">{{ $signo }}{{ $actual }}</b>
                                </p>
                            @else
                                {{-- <div class="flex flex-col items-center gap-2"> --}}
                                <span
                                    class="text-casa-black border border-black rounded-full px-4 py-2 w-full text-xl font-bold text-center order-1 mb-2">
                                    Puja finalizada
                                </span>
                                <a href="{{ route('carrito') }}"
                                    class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-bold order-3 mt-2">
                                    Pagar
                                    <svg class="size-8 ">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg>

                                </a>
                                {{-- </div> --}}
                            @endif

                            <h2
                                class="text-casa-black border border-black rounded-full px-4 py-2 w-full text-xl font-bold text-center order-2">
                                {{ $subastaActiva ? 'Tu puja es la última' : 'El lote es tuyo' }}
                            </h2>
                        @else
                            @if ($subastaActiva)
                                <div class="flex flex-col gap-3">
                                    <input type="number"
                                        class="bg-base border border-casa-black text-casa-black rounded-full px-4 py-2 w-full text-xl font-semibold"
                                        placeholder="Tu oferta" wire:model.defer="ofertas.{{ $lote->id }}" />

                                    <button
                                        class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-bold order-3 "
                                        wire:click="registrarPuja({{ $lote->id }})" wire:loading.attr="disabled">
                                        <span wire:loading.remove wire:target="registrarPuja({{ $lote->id }})">
                                            Pujar
                                        </span>

                                        <span wire:loading wire:target="registrarPuja({{ $lote->id }})">
                                            Procesando...
                                        </span>
                                        <svg class="size-8 ">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg>
                                    </button>
                                    <x-input-error-front for="puja.{{ $lote['id'] }}"
                                        class="absolte bottom-0 text-red-500 order-4 text-lg" />
                                </div>
                            @else
                                <div class="flex flex-col gap-2 items-center">
                                    <span
                                        class="text-casa-black border border-black rounded-full px-4 py-2 w-full text-xl font-bold text-center">
                                        Puja finalizada
                                    </span>
                                    <span
                                        class="text-casa-black border border-black rounded-full px-4 py-2 w-full text-xl font-bold text-center mt-1">
                                        Alguien ofertó más
                                    </span>
                                </div>
                            @endif
                        @endif


                        {{-- @php
                        $adquirenteEsGanador = $lote?->getPujaFinal()?->adquirente_id == $adquirente?->id;
                        $subastaActiva =
                            \Carbon\Carbon::parse($lote->ultimoConLote?->tiempo_post_subasta_fin)->gte(now()) ||
                            \Carbon\Carbon::parse($lote->ultimoContrato?->subasta->fecha_fin)->gte(now());
                    @endphp

                    @if ($adquirenteEsGanador)
                        @if ($subastaActiva)
                            <p
                                class="text-casa-black  border border-black rounded-full px-4 flex items-center justify-  py-2  w-full  text-xl  mb-2 bg-casa-base">
                                Ofertaste:
                                <b class="ml-1"> {{ $signo }}{{ $actual }}</b>
                            </p>
                        @else
                            <span class="bg-red-500 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl">
                                Puja finalizada
                            </span>
                            <span
                                class="bg-purple-500 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl order-1">
                                Pagar
                            </span>
                        @endif
                        <h2
                            class="bg-white px-4 py-2 rounded-2xl mx-auto mt-8 font-bold text-xl 
               {{ $subastaActiva ? 'text-blue-600' : 'text-green-600' }}">
                            {{ $subastaActiva ? 'Tu puja es la última' : 'Ganaste la puja' }}
                        </h2>
                    @else
                        @if ($subastaActiva)
                            <input type="number"
                                class="bg-base border border-casa-black  text-casa-black  rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-semibold mb-2"
                                placeholder="Tu oferta" />
                            <button
                                class="bg-green-500 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-700"
                                wire:click="registrarPuja({{ $lote['id'] }})" wire:loading.attr="disabled">
                                <span wire:target="registrarPuja({{ $lote['id'] }})">Pujar</span>
                                <span wire:loading
                                    wire:target="registrarPuja({{ $lote['id'] }})">Procesando...</span>
                            </button>
                        @else
                            <span
                                class="text-center text-casa-black   border border-black rounded-full px-4   py-2  w-full  text-xl  mb-2 font-bold ">
                                Puja finalizada
                            </span>
                            <span
                                class="text-center text-casa-black   border border-black rounded-full px-4   py-2  w-full  text-xl  mb-2 font-bold ">
                                Alguien ofertó mas
                            </span>
                        @endif
                    @endif --}}



                        {{-- @if ($lote?->getPujaFinal()?->adquirente_id == $adquirente?->id)
                        <p
                            class="text-casa-black  border border-black rounded-full px-4 flex items-center justify-  py-2  w-full  text-xl  mb-2 bg-casa-base">
                            Ofertaste:
                            <b class="ml-1"> {{ $signo }}{{ $actual }}</b>
                        </p>

                        <p
                            class="text-center text-casa-black   border border-black rounded-full px-4   py-2  w-full  text-xl  mb-2 font-bold ">
                            Tu puja es la última
                        </p>
                    @else
                        <input type="number"
                            class="bg-base border border-casa-black  text-casa-black  rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-semibold mb-2"
                            placeholder="Tu oferta" />



                        <button
                            class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-bold"
                            wire:target="registrarPuja({{ $lote['id'] }})">
                            Pujar
                            <svg class="size-8 ">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </button>
                    @endif --}}








                    </div>




                    @if (!empty($lote->ultimoConLote?->tiempo_post_subasta_fin))
                        <div x-data="countdownTimer({
                            // El valor inicial se puede pasar aquí o leerlo desde el data attribute en init
                            loteId: '{{ $lote['id'] }}'
                        })" {{-- Guardamos el valor dinámico en un atributo que Alpine puede leer --}}
                            data-end-time="{{ $lote->ultimoConLote?->tiempo_post_subasta_fin }}"
                            x-init="init(); // Llama a init en la carga inicial
                            $wire.on('lotes-updated', () => {
                                console.log('Evento lotes-updated recibido para lote {{ $lote['id'] }}');
                            
                                // $nextTick espera a que Livewire termine de actualizar el DOM
                                // antes de ejecutar nuestro código. Esto es más seguro que setTimeout.
                                $nextTick(() => {
                                    console.log('DOM actualizado, re-inicializando el timer para lote {{ $lote['id'] }}');
                                    init(); // Llama a init de nuevo para leer el nuevo valor
                                });
                            })" x-show="isValid && timeRemaining !== '00:00'" x-cloak>
                            <p
                                class="flex justify-between items-center bg-casa-black w-full p-1 h-11    border-casa-black text-casa-base px-6 text-sm  ">
                                Tiempo restante:
                                <span x-text="timeRemaining" class="text-white font-extrabold"></span>
                            </p>
                        </div>
                    @endif



                </div>
            @endforeach
        @endif

    </div>


    <a href="{{ route('carrito') }}"
        class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2 text-xl font-bold w-5/6 mt-6">
        Ver tu carrito
        <svg class="size-8 ">
            <use xlink:href="#arrow-right"></use>
        </svg>
    </a>



    <div class="hidden rid grid-cols-3 gap-7 pb-8 ">
        @if ($lotes)

            @foreach ($lotes as $lote)
                <article class="flex flex-col bg-cyan-950 rounded-2xl p-3 relative" wire:key="{{ $lote['id'] }}">

                    @if ($lote?->getPujaFinal()?->adquirente_id == $adquirente?->id)
                        <button
                            class="bg-gray-800 rounded-full  absolute top-1 right-1 text-red-600 border border-red-700 size-6   leading-0  opacity-60"
                            title="Tu subasta es la ultima no puedes quitar del carrito">
                            X
                        </button>
                    @else
                        <button
                            class="bg-gray-800 rounded-full  absolute top-1 right-1 text-red-600 border border-red-700 size-6   leading-0 hover:text-red-500"
                            wire:click="quitar({{ $lote['id'] }})" title="Quitar de carrito">
                            X
                        </button>
                    @endif

                    <x-input-error for="quitar.{{ $lote['id'] }}" class="absolute top-0 text-white " />

                    <h2 class="text-gray-100 text-lg mb-1">{{ $lote['titulo'] }}</h2>

                    {{-- <img class="max-h-48" src="{{ Storage::url('imagenes/lotes/normal/' . $lote['foto']) }}" /> --}}
                    <figure class="min-h-40">
                        <img class="max-h-40 w-auto mx-auto"
                            src="{{ Storage::url('imagenes/lotes/normal/' . $lote->foto1) }}" />
                    </figure>



                    <p class="text-gray-200 mt-1">Lote:<b> {{ $lote['id'] }}</b></p>
                    <p class="text-gray-200 mt-1">Subasta:<b> {{ $lote->ultimoContrato?->subasta_id }}</b></p>
                    <p class="text-gray-200 mt-1">Base: {{ (int) $lote['precio_base'] }}</p>


                    <p class="text-gray-200 mt-1">Ultima oferta:
                        <b>
                            {{ optional($lote->getPujaFinal())->monto !== null ? (int) $lote->getPujaFinal()->monto : 'Sin pujas' }}
                        </b>
                    </p>


                    <label class="text-gray-200 mt-1  ">Fraccion minima:
                        <input type="number" min={{ $lote['fraccion_min'] }}
                            wire:model="fraccion_min.{{ $lote['id'] }}"
                            class="bg-gray-200 rounded-lg h-6 text-cyan-950 px-2 " />
                    </label>

                    <div class="flex flex-col items-center mb-2 relative  pb-3">


                        @php
                            $adquirenteEsGanador = $lote?->getPujaFinal()?->adquirente_id == $adquirente?->id;
                            $subastaActiva =
                                \Carbon\Carbon::parse($lote->ultimoConLote?->tiempo_post_subasta_fin)->gte(now()) ||
                                \Carbon\Carbon::parse($lote->ultimoContrato?->subasta->fecha_fin)->gte(now());
                        @endphp

                        @if ($adquirenteEsGanador)
                            <h2
                                class="bg-white px-4 py-2 rounded-2xl mx-auto mt-8 font-bold text-xl 
               {{ $subastaActiva ? 'text-blue-600' : 'text-green-600' }}">
                                {{ $subastaActiva ? 'Tu puja es la última' : 'Ganaste la puja' }}
                            </h2>
                        @else
                            @if ($subastaActiva)
                                <button
                                    class="bg-green-500 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-700"
                                    wire:click="registrarPuja({{ $lote['id'] }})" wire:loading.attr="disabled">
                                    <span wire:target="registrarPuja({{ $lote['id'] }})">Pujar</span>
                                    <span wire:loading
                                        wire:target="registrarPuja({{ $lote['id'] }})">Procesando...</span>
                                </button>
                            @else
                                <span
                                    class="bg-red-500 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl">
                                    Puja finalizada
                                </span>
                            @endif
                        @endif


                        <x-input-error for="qpuja.{{ $lote['id'] }}" class="absolute bottom-0 text-white " />
                        <x-input-error for="puja.{{ $lote['id'] }}" class="absolute bottom-0 text-white " />


                        {{-- <x-input-error for="puja" class="absolute top-full text-white text-2xl mt-2" /> --}}



                    </div>




                    @if (session('message'))
                        <div class="text-green-500 text-lg ">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="text-orange-500 text-lg ">
                            {{ session('error') }}
                        </div>
                    @endif





                    @if (!empty($lote->ultimoConLote?->tiempo_post_subasta_fin))
                        <div x-data="countdownTimer({
                            // El valor inicial se puede pasar aquí o leerlo desde el data attribute en init
                            loteId: '{{ $lote['id'] }}'
                        })" {{-- Guardamos el valor dinámico en un atributo que Alpine puede leer --}}
                            data-end-time="{{ $lote->ultimoConLote?->tiempo_post_subasta_fin }}"
                            x-init="init(); // Llama a init en la carga inicial
                            $wire.on('lotes-updated', () => {
                                console.log('Evento lotes-updated recibido para lote {{ $lote['id'] }}');
                            
                                // $nextTick espera a que Livewire termine de actualizar el DOM
                                // antes de ejecutar nuestro código. Esto es más seguro que setTimeout.
                                $nextTick(() => {
                                    console.log('DOM actualizado, re-inicializando el timer para lote {{ $lote['id'] }}');
                                    init(); // Llama a init de nuevo para leer el nuevo valor
                                });
                            })" x-show="isValid && timeRemaining !== '00:00'" x-cloak>
                            <p
                                class="text-gray-100 mt-1 bg-yellow-800 w-full text-center font-bold absolute bottom-0 left-0 rounded-b-xl">
                                Tiempo restante:
                                <span x-text="timeRemaining" class="text-white font-extrabold"></span>
                            </p>
                        </div>
                    @endif









                    {{-- <button wire:click="ddd" class="bg-red-500 p-2 rounded-3xl">dddd</button> --}}

                </article>
            @endforeach
        @else
            <div class="flex flex-col mx-auto mt-12 col-span-3 text-white justify-center items-center">
                <h1 class="text-3xl mb-4 font-semibold">Sin lotes en tu carrito aun!</h1>
                <h2 class="text-lg">Agrega los lotes y comienza a pujar</h2>
            </div>
        @endif



    </div>



    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('countdownTimer', ({
                loteId
            }) => ({
                timeRemaining: '00:00',
                isValid: false,
                interval: null,
                // Quitamos endTime del objeto inicial, lo leeremos del DOM

                init() {
                    // Limpiar cualquier intervalo existente para evitar duplicados
                    if (this.interval) {
                        clearInterval(this.interval);
                    }

                    // Leemos el valor actualizado directamente desde el atributo data-* del elemento
                    const endTimeString = this.$el.dataset.endTime;

                    const now = new Date();
                    const end = new Date(endTimeString);

                    console.log(`new INIT for lote ${loteId}`);
                    console.log(`endTime from data attribute: ${endTimeString}`);
                    console.log(`end (Date object): ${end}`);
                    console.log(`now: ${now}`);

                    if (!isNaN(end.getTime()) && end > now) {
                        this.isValid = true;

                        const updateTimer = () => {
                            const currentNow = new Date();
                            const diff = end - currentNow;

                            if (diff <= 0) {
                                this.timeRemaining = '00:00';
                                this.isValid = false; // Oculta el contador
                                clearInterval(this.interval);
                                console.log(
                                    `Temporizador detenido para lote ${loteId}: tiempo agotado`);

                                console.log(
                                    `Despachando evento 'timer-expired' para el lote ${loteId}`);
                                this.$dispatch('timer-expired', {
                                    loteId: loteId
                                });
                                return;
                            }

                            const remainingMinutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 *
                                60));
                            const remainingSeconds = Math.floor((diff % (1000 * 60)) / 1000);
                            this.timeRemaining =
                                `${String(remainingMinutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
                        };

                        updateTimer(); // Ejecuta una vez inmediatamente
                        this.interval = setInterval(updateTimer, 1000);
                    } else {
                        this.timeRemaining = '00:00';
                        this.isValid = false;
                        console.log(
                            `Temporizador no iniciado para lote ${loteId}: endTime (${endTimeString}) es pasado o inválido.`
                        );
                    }
                },

                destroy() {
                    if (this.interval) {
                        clearInterval(this.interval);
                    }
                }
            }));
        });
    </script>
</div>
