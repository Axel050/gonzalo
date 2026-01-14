<div class="flex flex-col justify-center items-center  w-full  md:gap-y-24 gap-y-16 pt-12  md:px-16 xl:px-24 px-4">

    {{-- @dump('Check counter final subasta  ') --}}

    <article class="bg-red-00 flex  w-full md:justify-center justify-start flex-col  relative max-w-8xl">

        <x-fancy-heading text="t{u}s lo{t}es el{e}gi{d}os" variant="italic mx-[px] font-normal"
            class=" md:text-[47px] text-[28px]  md:text-center  text-start text-wrap font-normal " />

        <h3
            class="font-helvetica font-semibold md:text-3xl text-sm  tracking-normal md:text-center md:mt-2 mt-1 md:mb-2 mb-1">
            Desde aquí podrás pujar por los lotes que elegiste.
        </h3>


        @if ($tieneOrdenes)
            <a href="{{ route('carrito') }}"
                class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-casa-base rounded-full md:px-4 px-1 flex items-center justify-between  md:py-2 py-0.5 md:text-xl text-xs font-bold  w-fit md: absolute md:right-0 md:top-2  -top-5 right-1  mx-auto -4 md:mt-0">
                Ver tu carrito
                <svg class="md:size-[26px] size-[18px] md:ml-5 ml-2">
                    <use xlink:href="#arrow-right1"></use>
                </svg>
            </a>
        @endif
    </article>





    <div
        class="flex md:flex-wrap md:flex-row flex-col   md:gap-12 gap-2  place-content-center justify-center max-w-8xl  w-full items-stretch md:px-0 x-2  ">


        @if (!count($lotes))
            <div
                class="flex flex-col bg-casa-black justify-center items-center md:text-4xl text-2xl font-bold text-casa-base-2  md:py-8 py-4 md:px-40 px-2 col-span-3">
                <p>¡Sin lotes agregados aun!</p>


                <a href="{{ route('subastas') }}"
                    class=" flex   rounded-4xl md:px-4 md:text-xl text-lg  px-2 py-1 md:py-1.5  bg-casa-base hover:bg-casa-base-2  text-casa-black md:mt-8 mt-6 items-center"
                    title="Ir a subastas">
                    Subastas
                    <svg class="md:size-[26px] size-[24px] md:ml-8 ml-5">
                        <use xlink:href="#arrow-right1"></use>
                    </svg>

                </a>
            </div>
        @endif


        {{-- @if (isset($lotes) && count($lotes)) --}}
        @foreach ($lotes as $lote)
            @if ($loop->first && !$lote['esGanador'])
                <div class="hidden md:block md:w-[30%]"></div>
            @endif




            {{-- <div class="flex flex-col md:w-[30%] w-full transition-all duration-500 ease-out" --}}
            <div class="flex flex-col md:w-[30%] w-full" {{-- class="flex flex-col md:w-[30%] w-full transition-all duration-500 ease-out" --}} wire:key="lote-{{ $lote['id'] }}">


                <div class="flex flex-col py-2 md:p-6 p-4 bg-casa-base-2 md:border border-casa-black">

                    <!-- Cabecera Desktop -->
                    <div class="md:flex hidden w-full justify-between">
                        <x-clamp :text="$lote['titulo']" bclass=" mr-1" mas="absolute -bottom-2 -right-2 md:right-0 " />

                        <button class=" -mt-3 -mr-3 h-fit disabled:opacity-30 disabled:cursor-not-allowed"
                            wire:click="quitar({{ $lote['id'] }})"
                            title="{{ $lote['esGanador'] ? 'No puedes quitar, tu oferta es la ultima' : 'Quitar del listado' }}"
                            @disabled($lote['esGanador'])>
                            <svg class="size-8 ">
                                <use xlink:href="#trash"></use>
                            </svg>
                        </button>
                    </div>

                    <div class="flex md:flex-col ">
                        <!-- Imagen -->
                        <div class="flex md:py-4 py-3 md:w-full w-20 justify-center ">
                            <img src="{{ $lote['fotoUrl'] }}" {{-- class="md:size-49 size-20 " --}}
                                class="md:h-49 w-full  h-20  object-contain" />

                        </div>

                        <div class="flex flex-col w-full md:pl-0 pl-2 ">
                            <!-- Cabecera Mobile -->
                            <div class="md:hidden flex w-full justify-between ">
                                <x-clamp :text="$lote['titulo']" class="text-sm font-bold " />

                                <div class=" flex items-center gap-2">
                                    <div class="inline-block md:hidden">
                                        @if ($lote['subastaActiva'])
                                            @if ($lote['tienePujas'])
                                                <x-hammer />
                                            @else
                                                <x-hammer-fix />
                                            @endif
                                        @endif
                                    </div>
                                    <button class="h-fit disabled:opacity-30 disabled:cursor-not-allowed"
                                        wire:click="quitar({{ $lote['id'] }})"
                                        title="{{ $lote['esGanador'] ? 'No puedes quitar, tu oferta es la ultima' : 'Quitar del carrito' }}"
                                        @disabled($lote['esGanador'])>
                                        <svg class="size-7">
                                            <use xlink:href="#trash"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Etiquetas y Links -->
                            <div class=" flex w-full justify-between ">
                                <ul class="flex gap-4 text-sm mb-2 mt-1 md:mt-0">
                                    <li
                                        class="md:px-3 px-2 md:py-2 py-0.5 rounded-full border border-casa-black md:text-sm text-xs">
                                        <a href="{{ route('lotes.show', $lote['id']) }}" title="Ir a lote">Lote:
                                            {{ $lote['id'] }}</a>
                                    </li>

                                    <li
                                        class="md:px-3 px-2 md:py-2 py-0.5 rounded-full border border-casa-rojo md:text-sm text-xs text-casa-rojo font-semibold hover:bg-casa-rojo hover:text-casa-base">
                                        {{-- <a href="{{ route($lote['subastaActiva'] ? 'subasta.lotes' : 'subasta-pasadas.lotes', 1) }}" --}}
                                        <a href="{{ route($lote['subastaActiva'] ? 'subasta.lotes' : 'subasta-pasadas.lotes', $lote['subastaId']) }}"
                                            title="Ir a subasta">Subasta: {{ $lote['subastaTitulo'] }}</a>
                                    </li>
                                </ul>

                                <div class="md:inline-block hidden">
                                    @if ($lote['subastaActiva'])
                                        @if ($lote['tienePujas'])
                                            <x-hammer />
                                        @else
                                            <x-hammer-fix />
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <p class=" md:text-xl text-sm"> Base : {{ $lote['monedaSigno'] }}
                                {{ $lote['precioBaseFormateado'] }} </p>
                            <p class=" md:text-xl text-sm font-bold"> Oferta actual : {{ $lote['monedaSigno'] }}
                                {{ $lote['ofertaActualFormateada'] }} </p>
                        </div>
                    </div>

                    <div class=" flex flex-col gap-y-2">
                        <div class=" text-sm md:text-xl md:mt-2"> Fracción minima :
                            {{ $lote['monedaSigno'] }} {{ number_format($lote['fraccionMin'], 0, ',', '.') }}
                        </div>

                        {{-- @dump($lote['esGanador']) --}}
                        {{-- @dump($lote['subastaFinalizada']) --}}
                        @if (!$lote['subastaFinalizada'])
                            {{-- ================= SUBASTA NO FINALIZADA ================= --}}

                            @if ($lote['esGanador'])
                                <p
                                    class="text-casa-black border border-black rounded-full px-4 md:py-2 py-1 md:flex items-center justify-center w-full md:text-xl text-sm bg-casa-base mt-auto">
                                    Ofertaste:
                                    <b class="ml-1">
                                        {{ $lote['monedaSigno'] }} {{ $lote['ofertaActualFormateada'] }}
                                    </b>
                                </p>

                                <h2
                                    class="text-casa-black border border-black rounded-full px-4 md:py-2 py-1 w-full md:text-xl text-sm font-bold text-center relative">
                                    Tu puja es la última
                                </h2>
                            @else
                                {{-- @if ($lote['subastaActiva']) --}}
                                <div class="flex flex-col md:gap-3 gap-2">
                                    <div class="flex bg-base border border-casa-black text-casa-black rounded-full px-4 md:text-xl text-sm font-semibold focus-within:border-casa-black focus-within:ring-1 focus-within:ring-casa-black transition"
                                        x-data="{
                                            valor: @entangle('ofertas.' . $lote['id']),
                                            maxDigits: 12,
                                            limpiar() {
                                                let clean = (this.valor ?? '').toString().replace(/\D/g, '');
                                                if (clean.length > this.maxDigits) {
                                                    clean = clean.slice(0, this.maxDigits);
                                                }
                                                return clean;
                                            },
                                            formatear() {
                                                let clean = this.limpiar();
                                                this.valor = clean ?
                                                    clean.replace(/\B(?=(\d{3})+(?!\d))/g, '.') :
                                                    '';
                                            }
                                        }" x-init="formatear()">

                                        <span class="mr-1 py-1.5">{{ $lote['monedaSigno'] }}</span>

                                        <input type="text" class="md:py-1.5 py-1 w-full outline-none bg-transparent"
                                            placeholder="Tu oferta" x-model="valor"
                                            x-on:input=" let clean = limpiar();
                                                                $wire.set('ofertas.{{ $lote['id'] }}', clean, true);"
                                            x-on:blur="formatear()" x-on:change="formatear()" inputmode="numeric"
                                            autocomplete="off">
                                    </div>

                                    <button
                                        class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-casa-base rounded-full px-4 flex items-center justify-between md:py-1.5 py-1 w-full md:text-xl text-sm font-bold disabled:cursor-none disabled:hover:bg-casa-black disabled:hover:text-casa-base"
                                        wire:click="registrarPuja({{ $lote['id'] }}, {{ $lote['ofertaActual'] }})"
                                        wire:loading.attr="disabled">

                                        <span wire:loading.remove
                                            wire:target="registrarPuja({{ $lote['id'] }}, {{ $lote['ofertaActual'] }})">
                                            Pujar
                                        </span>

                                        <span wire:loading
                                            wire:target="registrarPuja({{ $lote['id'] }}, {{ $lote['ofertaActual'] }})">
                                            Procesando...
                                        </span>

                                        <svg class="md:size-[26px] size-[22px]">
                                            <use xlink:href="#arrow-right1"></use>
                                        </svg>
                                    </button>

                                    <x-input-error-front for="puja.{{ $lote['id'] }}" class="text-red-500 text-md" />
                                </div>
                                {{-- @endif --}}
                            @endif
                        @else
                            {{-- ================= SUBASTA FINALIZADA ================= --}}

                            @if ($lote['esGanador'])
                                <a href="{{ route('carrito') }}"
                                    class="bg-casa-green hover:bg-casa-fondo border border-green-500 hover:text-casa-green text-casa-base rounded-full px-4 flex items-center justify-between md:py-1.5 py-1 w-full md:text-xl text-sm font-bold mt-auto">
                                    Pagar
                                    <svg class="md:size-[26px] size-[22px]">
                                        <use xlink:href="#arrow-right1"></use>
                                    </svg>
                                </a>

                                <h2
                                    class="text-casa-black border border-black rounded-full px-4 md:py-1.5 py-1 w-full md:text-xl text-sm font-bold text-center mt-1 animate-reverse-pulse">
                                    ¡Ganaste este lote!
                                </h2>
                            @else
                                <div class="flex flex-col md:gap-2 gap-1 items-center mt-auto">
                                    <span
                                        class="text-casa-base border bg-casa-rojo rounded-full px-4 md:py-1.5 py-1 w-full md:text-xl text-sm font-bold text-center">
                                        Puja finalizada
                                    </span>

                                    <span
                                        class="text-casa-black border border-black rounded-full px-4 md:py-1.5 py-1 w-full md:text-xl text-sm font-bold text-center mt-1">
                                        Alguien ofertó más
                                    </span>
                                </div>
                            @endif
                        @endif


                        @error('quitar.' . $lote['id'])
                            <div class='flex items-center text-sm text-red-600 relative order-11 md:pt-0 pt-1.5'>
                                <svg class="w-4 h-3.5 md:mr-2 mr-1">
                                    <use xlink:href="#error-icon"></use>
                                </svg>
                                <p class='md:max-w-600 leading-[12px] '>{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Timer Section -->
                @if (!empty($lote['tiempoFinalizacion']))
                    <div x-data="countdownTimer({
                        // El valor inicial se puede pasar aquí o leerlo desde el data attribute en init
                        loteId: '{{ $lote['id'] }}'
                    })" {{-- Guardamos el valor dinámico en un atributo que Alpine puede leer --}}
                        data-end-time="{{ $lote['tiempoFinalizacion'] }}" x-init="init(); // Llama a init en la carga inicial
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
                            class="flex justify-between items-center bg-casa-black w-full md:py-2 py-1 border-casa-black text-casa-base md:px-6 px-2 text-sm">
                            s
                            Tiempo restante:
                            <span x-text="timeRemaining" class="text-casa-base font-extrabold"></span>
                        </p>
                    </div>
                @endif
            </div>

            @if ($loop->first && !$lote['esGanador'])
                <div class="hidden md:block md:w-[30%]"></div>
            @endif
        @endforeach
        {{-- @endif --}}


        {{-- @else
            <div class="flex flex-col bg-casa-black px-5 py-10 font-semibold text-casa-base my-30 gap-y-8">

                <h2 class="bg-casa-black md:px-15  mx-auto md:text-3xl text-xl">
                    ¡Agrega lotes para empezar a pujar!</h2>
                <a href="{{ route('subastas') }}"
                    class="bg-casa-base-2 text-casa-black text-xl px-8 py-2 rounded-full w-fit mx-auto text-center">Subastas</a>
            </div>

        @endif
 --}}




    </div>


    @if ($tieneOrdenes)
        {{-- <div class="w-full   bg-green-900  "> --}}

        <div class="w-full max-w-8xl flex md:flex-row flex-col gap-3  ">

            <p class="md:text-3xl font-bold text-sm md:w-1/2 md:text-start text-center w-full">Tenés lotes para
                pagar en tu carrito</p>

            <a href="{{ route('carrito') }}"
                class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-casa-base rounded-full px-4 flex items-center justify-between  md:py-2 py-1 md:text-xl text-sm font-bold  md:w-1/2 w-full">
                Ver tu carrito
                <svg class="size-[26px]">
                    <use xlink:href="#arrow-right1"></use>
                </svg>
            </a>

        </div>
        {{-- </div> --}}
    @endif










    @livewire('destacados-pantalla-pujas')








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
                        // console.log(
                        //     `Temporizador no iniciado para lote ${loteId}: endTime (${endTimeString}) es pasado o inválido.`
                        // );
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
