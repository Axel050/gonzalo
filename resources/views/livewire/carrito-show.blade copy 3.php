<div class="flex flex-col justify-center items-center  w-full  pt-0  ">

    {{-- @dump('VER OPCION PONER MODAL PARA MENJEAR PUJAS Y OFERTAS ') --}}

    {{-- <article class="bg-red-00 flex  w-full lg:justify-center justify-start flex-col mt-10 lg:mb-8 mb-4 lg:px-0 px-4">
        <svg fill="#fff" class="w-[247px] h-[47px] mx-auto mb-2 lg:block hidden">
            <use xlink:href="#tuslotes"></use>
        </svg>

        <h2 class="lg:hidden text-4xl font-helvetica">tus lotes</h2>

        <h3 class="font-helvetica font-semibold lg:text-3xl text-sm  tracking-normal lg:text-center mt-4 lg:mb-2 mb-1">
            Estos son
            lotes que agregaste a tu carrito.
        </h3>
        <p class=" lg:text-3xl text-sm lg:text-center text-start">Vehicula adipiscing pellentesque volutpat
            dui rhoncus neque urna.</p>

    </article> --}}


    @if ($modal)
        @livewire('modal-puja', ['lote_id' => $modal, 'adquirente_id' => $adquirente_id, 'base' => $baseModal])
    @endif


    <div
        class="flex flex-wrap  mt-10 lg:gap-12 gap-2 place-content-center justify-center max-w-[1440px]  w-full items-stretch">

        @if (isset($lotes) && count($lotes))
            @foreach ($lotes as $lote)
                @php
                    $actual = optional($lote->getPujaFinal())->monto !== null ? (int) $lote->getPujaFinal()->monto : 0;
                    $actualParam;

                    if (is_int($actual)) {
                        $actualParam = $actual;
                        $actual = number_format($actual, 0, ',', '.');
                    }

                    $signo = $this->getMonedaSigno($lote->moneda);

                    $adquirenteEsGanador = $lote?->getPujaFinal()?->adquirente_id === $adquirente?->id;
                    $subastaActiva = \Carbon\Carbon::parse(
                        $lote->ultimoConLote?->tiempo_post_subasta_fin ?? $lote->ultimoContrato?->subasta->fecha_fin,
                    )->gte(now());
                @endphp

                <div class="flex flex-col lg:w-[394px]  lg:min-w-[300px] w-[44%] ">

                    <div
                        class="bg-casa-base-2  flex flex-col lg:p-6 p-2 lg:gap-y-1 lg:border @if ($adquirenteEsGanador) border @endif border-casa-black  relative  h-full">


                        <button class="lg:hidden absolute inset-0  z-10"
                            wire:click="modalOpen({{ $lote['id'] }},{{ $lote['precio_base'] }})"></button>


                        <button
                            class="font-semibold text-xl   absolute lg:top-1 top-0 right-2   z-20  disabled:cursor-not-allowed disabled:opacity-30"
                            {{-- @disabled($adquirenteEsGanador)  --}} wire:click="quitar({{ $lote['id'] }})"
                            title="{{ $adquirenteEsGanador ? 'No puedes quitar, tu oferta es la ultima' : 'Quitar del carrito' }}">X</button>


                        <div class="flex justify-between w-full  lg:order-1 order-2">

                            <a href="{{ route('lotes.show', $lote['id']) }}"
                                class="flex justify-between items-center  lg:text-2xl text-sm font-bold ">{{ $lote['titulo'] }}</a>



                            {{-- MOBILE --}}
                            <div class="order-4 inline-block lg:hidden">


                                @if ($subastaActiva)
                                    @if (count($lote->pujas))
                                        <x-hammer />
                                    @else
                                        <x-hammer-fix />
                                    @endif
                                @endif
                            </div>


                        </div>






                        <div class="flex gap-x-4 justify-center my-2 lg:order-2 order-1 ">
                            <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}"
                                class="lg:size-49 size-20 " />
                        </div>


                        <div class="flex justify-between items-center lg:mt-2 lg:order-3">
                            <ul class="lg:flex gap-4 text-sm hidden">
                                <li class="px-3 py-2 rounded-full border border-casa-black"><a
                                        href="{{ route('lotes.show', $lote['id']) }}">Lote: {{ $lote->id }}</a></li>
                                <li class="px-3 py-2 rounded-full border border-casa-black"><a
                                        href="{{ route('subasta.lotes', $lote->ultimoContrato?->subasta_id) }}">Subasta:
                                        {{ $lote->ultimoContrato?->subasta?->titulo }}</a></li>


                            </ul>

                            <div class="order-4 lg:inline-block hidden">

                                @if ($subastaActiva)
                                    @if (count($lote->pujas))
                                        <x-hammer />
                                    @else
                                        <x-hammer-fix />
                                    @endif
                                @endif
                            </div>


                        </div>




                        <p class="lg:text-xl text-sm  mt-2 lg:order-4 order-3 lg:mb-0 mb-0W">Base:
                            {{ $signo }}{{ number_format($lote['precio_base'], 0, ',', '.') }}
                        </p>


                        <p class="lg:text-xl text-sm font-semibold mb-3 lg:order-5 lg:inline-block hidden">
                            <span>Oferta actual:
                                {{ $signo }}{{ $actual }}</span>
                        </p>


                        {{-- MOBILE --}}
                        @if ($adquirenteEsGanador && $subastaActiva)
                            <div class="lg:hidden pt-2 mt-auto order-4">
                                <p
                                    class="lg:hidden bg-casa-base rounded-xl  text-center   block  order-4 border border-casa-black leading-4  py-0.5">
                                    Ofertaste: <span class="inline-block xs:px-0.5 "> {{ $actual }}</span>
                                </p>
                            </div>
                        @else
                            <span class="lg:hidden order-4 font-semibold">Actual: {{ $actual }}</span>
                        @endif


                        @if ($subastaActiva)
                            <p class="text-xl  mb-2 lg:block hidden lg:order-6">Fraccion minima:
                                {{ $signo }}{{ number_format($lote['fraccion_min'], 0, ',', '.') }}</p>
                        @endif



                        @if ($adquirenteEsGanador)
                            @if ($subastaActiva)
                                <p
                                    class="text-casa-black border border-black rounded-full px-4 py-2 lg:flex items-center justify-center w-full text-xl mb-2 bg-casa-base  hidden lg:order-7 mt-auto">
                                    Ofertaste: <b class="ml-1">{{ $signo }}{{ $actual }}</b>
                                </p>
                            @else
                                <span
                                    class="text-casa-black border border-black rounded-full lg:px-4  px-1 lg:py-2 py-0.5 w-full lg:text-xl text-xs font-bold text-center  mb-2 lg:block hidden lg:order-7  order-8 lg:mt-0 mt-1">
                                    Puja finalizada
                                </span>

                                <h2
                                    class="text-casa-black border border-black rounded-full px-2 py-0.5 w-full text-xs font-bold text-center   lg:hidden order-10">
                                    {{ $subastaActiva ? 'Tu puja es la última' : 'El lote es tuyo' }}
                                </h2>


                                <a href="{{ route('carrito') }}"
                                    class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 lg:flex items-center justify-between  py-2  w-full  text-xl font-bold order-3 mt-2 hidden lg:order-11">
                                    Pagar
                                    <svg class="size-8 ">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg>

                                </a>
                            @endif

                            <h2
                                class="text-casa-black border border-black rounded-full px-4 py-2 w-full text-xl font-bold text-center  lg:block hidden lg:order-10">
                                {{ $subastaActiva ? 'Tu puja es la última' : 'El lote es tuyo' }}
                            </h2>
                        @else
                            @if ($subastaActiva)
                                <div class="lg:flex flex-col gap-3 hidden lg:order-9 ">

                                    <input type="number"
                                        class="bg-base border border-casa-black text-casa-black rounded-full px-4 py-2 w-full text-xl font-semibold "
                                        placeholder="Tu oferta" wire:model.defer="ofertas.{{ $lote->id }}" />


                                    <button
                                        class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2  w-full  text-xl font-bold   "
                                        wire:click="registrarPuja({{ $lote->id }} , {{ $actualParam }} )"
                                        wire:loading.attr="disabled">


                                        <span wire:loading.remove
                                            wire:target="registrarPuja({{ $lote->id }} , {{ $actualParam }} )">
                                            Pujar
                                        </span>

                                        <span wire:loading
                                            wire:target="registrarPuja({{ $lote->id }} , {{ $actualParam }} )">
                                            Procesando...
                                        </span>
                                        <svg class="size-8 ">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg>
                                    </button>



                                    <x-input-error-front for="puja.{{ $lote['id'] }}"
                                        class="absolte bottom-0 text-red-500 order-4 text-lg" />
                                    {{-- <x-input-error-front for="quitarx.{{ $lote['id'] }}"
                                    class="bottom-0 text-red-500 order-4 text-lg" /> --}}
                                </div>
                            @else
                                <div class="flex flex-col lg:gap-2 gap-0.5 items-center order-7 pt-2 mt-auto">
                                    <span
                                        class="text-casa-black border border-black rounded-full lg:px-4 px-2 lg:py-2 py-0.5 w-full lg:text-xl  text-xs font-bold text-center">
                                        Puja finalizada
                                    </span>
                                    <span
                                        class="text-casa-black border border-black rounded-full lg:px-4 px-2 lg:py-2 py-0.5 w-full lg:text-xl  text-xs font-bold text-center mt-1">
                                        Alguien ofertó más
                                    </span>
                                </div>
                            @endif
                        @endif



                        @error('quitar.' . $lote['id'])
                            <div class = 'flex items-center  text-sm text-red-600  relative order-11   lg:pt-0 pt-1.5'>
                                <svg class="w-4 h-3.5 lg:mr-2 mr-1">
                                    <use xlink:href="#error-icon"></use>
                                </svg>
                                <p class="">
                                <p class = 'lg:max-w-600 leading-[12px] '>
                                    {{ $message }}
                                </p>
                            </div>
                        @enderror




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
                                class="flex justify-between items-center bg-casa-black w-full lg:py-2 py-1     border-casa-black text-casa-base lg:px-6 px-1 text-sm  ">
                                Tiempo restante:
                                <span x-text="timeRemaining" class="text-white font-extrabold"></span>
                            </p>
                        </div>
                    @endif




                </div>
            @endforeach
        @else
            <h2 class="my-30 bg-casa-black text-casa-base text-2xl py-10 px-20">¡Sin lotes agregados aun!</h2>
        @endif

    </div>


    <a href="{{ route('carrito') }}"
        class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2 text-xl font-bold w-5/6 mt-6">
        Ver tu carrito
        <svg class="size-8 ">
            <use xlink:href="#arrow-right"></use>
        </svg>
    </a>





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
