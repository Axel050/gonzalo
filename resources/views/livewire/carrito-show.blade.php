<div class="flex flex-col justify-center items-center  w-full  pt-0  ">

    {{-- @dump('VER OPCION PONER MODAL PARA MENJEAR PUJAS Y OFERTAS ') --}}

    <article class="bg-red-00 flex  w-full lg:justify-center justify-start flex-col mt-10 lg:mb-8 mb-4 lg:px-0 px-4">
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

    </article>




    <div
        class="flex lg:flex-wrap lg:flex-row flex-col  mt-10 lg:gap-12 gap-2 place-content-center justify-center max-w-[1440px]  w-full items-stretch lg:px-0 px-2">

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



                <div class="flex flex-col  lg:w-[30%] w-full">


                    <div class="flex  flex-col py-2   lg:p-6 p-4  bg-casa-base-2 lg:border border-casa-black">

                        <div class=  "lg:flex hidden w-full justify-between">
                            <h2 class="  lg:text-3xl  font-bold "> {{ $lote['titulo'] }}</h2>

                            <button class=" -mt-3 -mr-3 h-fit disabled:opacity-30 disabled:cursor-not-allowed"
                                wire:click="quitar({{ $lote['id'] }})"
                                title="{{ $adquirenteEsGanador ? 'No puedes quitar, tu oferta es la ultima' : 'Quitar del carrito' }}"
                                @disabled($adquirenteEsGanador)>
                                <svg class="size-8 ">
                                    <use xlink:href="#trash"></use>
                                </svg>
                            </button>
                        </div>


                        <div class="flex lg:flex-col ">


                            <div class="flex  lg:py-4 py-3 lg:w-full w-20 justify-center ">
                                <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}"
                                    class="lg:size-49 size-20 " />
                            </div>

                            <div class="flex flex-col   w-full lg:pl-0 pl-2 ">

                                <div class="lg:hidden flex w-full  justify-between ">
                                    <h1 class="  text-sm  font-bold "> {{ $lote['titulo'] }}</h1>
                                    <div class=" flex items-center gap-2">
                                        <div class="inline-block lg:hidden">
                                            @if ($subastaActiva)
                                                @if (count($lote->pujas))
                                                    <x-hammer />
                                                @else
                                                    <x-hammer-fix />
                                                @endif
                                            @endif
                                        </div>
                                        <button class="h-fit disabled:opacity-30 disabled:cursor-not-allowed"
                                            wire:click="quitar({{ $lote['id'] }})"
                                            title="{{ $adquirenteEsGanador ? 'No puedes quitar, tu oferta es la ultima' : 'Quitar del carrito' }}"
                                            @disabled($adquirenteEsGanador)>
                                            <svg class="size-7">
                                                <use xlink:href="#trash"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class=" flex w-full justify-between ">
                                    <ul class="flex gap-4 text-sm  mb-2 mt-1 lg:mt-0">
                                        <li
                                            class="lg:px-3 px-2 lg:py-2 py-0.5 rounded-full border border-casa-black lg:text-sm text-xs">
                                            <a href="{{ route('lotes.show', $lote['id']) }}">Lote:
                                                {{ $lote->id }}</a>
                                        </li>
                                        <li
                                            class="lg:px-3 px-2 lg:py-2 py-0.5 rounded-full border border-casa-black lg:text-sm text-xs">
                                            <a href="{{ route('subasta.lotes', $lote->ultimoContrato?->subasta_id) }}">Subasta:
                                                {{ $lote->ultimoContrato?->subasta?->titulo }}</a>
                                        </li>
                                    </ul>

                                    <div class="lg:inline-block hidden">
                                        @if ($subastaActiva)
                                            @if (count($lote->pujas))
                                                <x-hammer />
                                            @else
                                                <x-hammer-fix />
                                            @endif
                                        @endif
                                    </div>

                                </div>

                                <p class=" lg:text-xl text-sm"> Base :
                                    {{ $signo }}{{ number_format($lote['precio_base'], 0, ',', '.') }}</p>
                                <p class=" lg:text-xl text-sm font-bold"> Oferta actual :
                                    {{ $signo }}{{ $actual }}</p>

                            </div>

                        </div>

                        <div class=" flex flex-col  gap-y-2">

                            <div class=" text-sm lg:text-xl lg:mt-2"> Fracción minima :
                                {{ $signo }}{{ number_format($lote['fraccion_min'], 0, ',', '.') }}</div>




                            {{-- <input type="number"
                            class="bg-base border border-casa-black text-casa-black rounded-full px-4 lg:py-2 py-1 w-full lg:text-xl  text-sm font-semibold "
                            placeholder="Tu oferta" wire:model.defer="ofertas.{{ $lote->id }}" />

                        <button
                            class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  lg:py-2 py-1  w-full  lg:text-xl  text-sm font-bold   "
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
                            <svg class="lg:size-8 size-6 ">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </button>

                        <x-input-error-front for="puja.{{ $lote['id'] }}"
                            class="absolte bottom-0 text-red-500 order-4 text-lg" /> --}}
                            @if ($adquirenteEsGanador)
                                @if ($subastaActiva)
                                    <p
                                        class="text-casa-black border border-black rounded-full px-4 lg:py-2 py-1 lg:flex items-center justify-center w-full lg:text-xl text-sm lg:mb-2 mb-1 bg-casa-base   lg:order-7 mt-auto">
                                        Ofertaste: <b class="ml-1">{{ $signo }}{{ $actual }}</b>
                                    </p>
                                @else
                                    <span
                                        class="text-casa-black border border-black rounded-full lg:px-4  px-1 lg:py-2 py-1 w-full lg:text-xl text-sm font-bold text-center  lg:mb-2 mb-0 block  lg:order-7  order-8 lg:mt-0 mt-1">
                                        Puja finalizada
                                    </span>

                                    {{-- <h2
                                    class="text-casa-black border border-black rounded-full px-2 py-0.5 w-full text-xs font-bold text-center   lg:hidden order-10">
                                    {{ $subastaActiva ? 'Tu puja es la última' : 'El lote es tuyo' }}
                                </h2> --}}


                                    <a href="{{ route('carrito') }}"
                                        class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  lg:py-2 py-1  w-full  lg:text-xl text-sm font-bold order-10 lg:mt-2  lg:order-11 ">
                                        Pagar
                                        <svg class="lg:size-8  size-6 ">
                                            <use xlink:href="#arrow-right"></use>
                                        </svg>

                                    </a>
                                @endif

                                <h2
                                    class="text-casa-black border border-black rounded-full px-4 lg:py-2 py-1 w-full lg:text-xl text-sm font-bold text-center  block  lg:order-10 order-9">
                                    {{ $subastaActiva ? 'Tu puja es la última' : 'El lote es tuyo' }}
                                </h2>
                            @else
                                @if ($subastaActiva)
                                    <div class="flex flex-col lg:gap-3 gap-2">

                                        <input type="number"
                                            class="bg-base border border-casa-black text-casa-black rounded-full px-4 lg:py-2 py-1 w-full lg:text-xl text-sm font-semibold "
                                            placeholder="Tu oferta" wire:model.defer="ofertas.{{ $lote->id }}" />


                                        <button
                                            class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  lg:py-2 py-1  w-full  lg:text-xl text-sm font-bold   "
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
                                            <svg class="lg:size-8 size-6 ">
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
                                            class="text-casa-black border border-black rounded-full lg:px-4 px-2 lg:py-2 py-1 w-full lg:text-xl  text-sm font-bold text-center">
                                            Puja finalizada
                                        </span>
                                        <span
                                            class="text-casa-black border border-black rounded-full lg:px-4 px-2 lg:py-2 py-1 w-full lg:text-xl  text-sm font-bold text-center mt-1">
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
                    </div>


                    {{--  --}}

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
                                class="flex justify-between items-center bg-casa-black w-full lg:py-2 py-1     border-casa-black text-casa-base lg:px-6 px-2 text-sm  ">
                                Tiempo restante:
                                <span x-text="timeRemaining" class="text-white font-extrabold"></span>
                            </p>
                        </div>
                    @endif
                    {{--  --}}

                </div>
            @endforeach


            <div class="flex lg:flex-row flex-col gap-3 w-full  mt-4 px-4">

                <p class="lg:text-3xl font-bold text-sm lg:w-1/2 lg:text-start text-center w-full">Tenés lotes para
                    pagar en tu carrito</p>

                <a href="{{ route('carrito') }}"
                    class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  lg:py-2 py-1 lg:text-xl text-sm font-bold  lg:w-1/2 w-full">
                    Ver tu carrito
                    <svg class="lg:size-8 size-6 ">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </a>

            </div>
        @else
            <div class="flex flex-col bg-casa-black px-5 py-10 font-semibold text-casa-base my-30 gap-y-8">

                <h2 class="bg-casa-black lg:px-15  mx-auto lg:text-3xl text-xl">
                    ¡Agrega lotes para empear apujar!</h2>
                <a href="{{ route('subastas') }}"
                    class="bg-casa-base-2 text-casa-black text-xl px-8 py-2 rounded-full w-fit mx-auto text-center">Subastas</a>
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
