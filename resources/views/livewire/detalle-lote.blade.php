<div class="flex flex-col justify-center items-center hvh w-full   md:gap-y-24 gap-y-16 pt-12">

    @if ($method == 'noHabilitado')
        @livewire('modal-no-habilitado-pujar', ['subasta' => $lote->ultimoContrato?->subasta_id, 'adquirente' => $adquirente->id, 'lote' => $lote_id])
    @endif


    {{--  --}}
    {{-- <article class=" flex lg:flex-row flex-col p-4 mt-20 g-blue-600  shadow-lg rounded-2xl mb-10 bg-green-100"> --}}

    <article
        class=" grid lg:grid-cols-2 grid-cols-1 p-4 lg-blue-600  shadw-lg rounded-2xl  lg:w-auto w-full relative md:mt-8 mt-4 max-w-6xl">

        <button wire:click="loteAnterior"
            class=" p-2 left-2 lg:-left-2  lg:-top-10 -top-7 absolute hover:scale-105 disabled:opacity-10 disabled:cursor-default"
            @disabled($cantidadLotes < 2) title="Lote anterior">
            <svg fill="#fff" class="size-8 lg:size-11 rotate-180">
                <use xlink:href="#arrow-right"></use>
            </svg></button>

        <button wire:click="loteSiguiente"
            class=" p-2 right-2 lg:-right-2 lg:-top-10 -top-7 absolute hover:scale-105 disabled:opacity-10 disabled:cursor-default"
            title="Lote siguiente" @disabled($cantidadLotes < 2)>
            <svg fill="#fff" class="size-8 lg:size-11 ">
                <use xlink:href="#arrow-right"></use>
            </svg>
        </button>





        {{-- <img src="{{ Storage::url('imagenes/lotes/default.png') }}"> --}}

        @php
            $defaultImage = Storage::url('imagenes/lotes/default.png');
        @endphp

        {{--  --}} {{--  --}}
        {{--  --}}
        <div {{-- x-data="{
            records: @js($records),
            currentIndex: 0,
            touchStartX: 0,
            touchEndX: 0,
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.records.length;
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.records.length) % this.records.length;
            },
            goTo(index) {
                this.currentIndex = index;
            },
            handleSwipe() {
                const swipeThreshold = 50;
                const diff = this.touchStartX - this.touchEndX;
                if (Math.abs(diff) > swipeThreshold) {
                    if (diff > 0) {
                        this.next();
                    } else {
                        this.prev();
                    }
                }
            }
        }" --}} x-data="{
            records: @js($records),
            currentIndex: 0,
            touchStartX: 0,
            touchEndX: 0,
            get hasMultiple() {
                return this.records.length > 1;
            },
            next() {
                if (!this.hasMultiple) return;
                this.currentIndex = (this.currentIndex + 1) % this.records.length;
            },
            prev() {
                if (!this.hasMultiple) return;
                this.currentIndex = (this.currentIndex - 1 + this.records.length) % this.records.length;
            },
            goTo(index) {
                if (!this.hasMultiple) return;
                this.currentIndex = index;
            },
            handleSwipe() {
                if (!this.hasMultiple) return;
                const swipeThreshold = 50;
                const diff = this.touchStartX - this.touchEndX;
                if (Math.abs(diff) > swipeThreshold) {
                    diff > 0 ? this.next() : this.prev();
                }
            }
        }"
            class="flex flex-col items-center col-start-1 lg:row-start-1 lg:row-end-4 row-start-2">
            {{-- Imagen principal --}}
            <div class="relative w-full flex justify-center max-w-150 ">
                {{-- <button @click="prev"
                    class="absolute lg:inline-block hidden left-0 top-1/2 -translate-y-1/2 z-10 rounded-full px-2 py-1 hover:scale-105"> --}}

                <button @click="prev" :disabled="!hasMultiple"
                    :class="!hasMultiple
                        ?
                        'opacity-5 cursor-not-allowed pointer-events-none' :
                        'hover:scale-105'"
                    class="absolute lg:inline-block hidden left-0 top-1/2 -translate-y-1/2 z-10 rounded-full pr-2 py-1 transition">
                    <svg class="rotate-180" width="39" height="67" viewBox="0 0 39 67" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.26917 65.5L36.7307 33.5L2.26918 1.5" stroke="#262626" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2.26917 65.5L36.7307 33.5L2.26918 1.5" stroke="black" stroke-opacity="0.2"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg></button>




                <figure class=" lg:w-150 w-full flex justify-center items-center relative">
                    <!-- Contenedor con el tamaño exacto de la imagen -->
                    {{-- <div class="relative group size-111" wire:click="$set('modal_foto',records[currentIndex].image )"> --}}
                    <div class="relative group lg:size-111 w-full"
                        x-on:click="
                        @this.set('modal_index', currentIndex);
                        @this.set('modal_foto', records[currentIndex].image);
                    "
                        x-on:touchstart="touchStartX = $event.touches[0].clientX"
                        x-on:touchend="touchEndX = $event.changedTouches[0].clientX; handleSwipe()">
                        <!-- Imagen -->
                        <img :src="records[currentIndex].image" onerror="this.src='{{ $defaultImage }}'"
                            class="lg:size-111
                            w-full lg:max-h-none max-h-[160px] object-contain transition-all duration-500 ease-in-out
                            mx-auto cursor-pointer lg:mt-0 mt-2"
                            x-transition:enter="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                        <!-- Capa de superposición: solo aparece al hacer hover SOBRE la imagen -->
                        <span
                            class="absolute inset-0 bg-gray-800/60 text-casa-base-2 text-4xl font-bold
                                      flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity duration-900
                                      pointer-events-none cursor-pointer ">
                            Agrandar
                        </span>
                    </div>
                </figure>
                @if ($modal_foto)
                    <x-modal-foto-detalle :records="$records" :current-index="$modal_index" />
                @endif
                {{-- <button @click="next"
                    class="absolute lg:inline-block hidden right-0 top-1/2 -translate-y-1/2 z-10 bgwhite/70 rounded-full px-2 py-1 hover:scale-105"> --}}
                <button @click="next" :disabled="!hasMultiple"
                    :class="!hasMultiple
                        ?
                        'opacity-5 cursor-not-allowed pointer-events-none' :
                        'hover:scale-105'"
                    class="absolute lg:inline-block hidden right-0 top-1/2 -translate-y-1/2 z-10 rounded-full pl-2 py-1 transition">
                    <svg width="39" height="67" viewBox="0 0 39 67" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.26917 65.5L36.7307 33.5L2.26918 1.5" stroke="#262626" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2.26917 65.5L36.7307 33.5L2.26918 1.5" stroke="black" stroke-opacity="0.2"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
            {{-- Miniaturas --}}
            <div class="hidden lg:flex gap-2 mt-4">
                <template x-for="(record, index) in records" :key="index">
                    <img :src="record.thumb ?? record.image" onerror="this.src='{{ $defaultImage }}'"
                        @click="goTo(index)"
                        class="w-20 h-20 object-contain cursor-pointer border-2 rounded-md transition-all duration-300 "
                        :class="index === currentIndex ? 'border-casa-black scale-110 ' :
                            'border-transparent hover:scale-105 hover:border-casa-black/25'">
                </template>
            </div>
            <!-- Botones circulares en Mobile -->
            <div class="flex lg:hidden gap-2 mt-4">
                <template x-for="(record, index) in records" :key="index">
                    <button @click="goTo(index)" class="w-3 h-3 rounded-full transition-all duration-300 mr-2"
                        :class="index === currentIndex ? 'bg-casa-black scale-125' : 'bg-gray-300 hover:bg-gray-400'">
                    </button>
                </template>
            </div>
        </div>
        {{--  --}}
        {{--  OLD --}}



        {{-- SECOND --}}
        <div class="flex flex-col lg:ml-18 pt-4 pl-2  g-red-300 max-w-150  lg:col-start-2   lg:row-end-2 row-start-1">
            <h2
                class="font-helvetica font-bold lg:text-[30px] text-lg lg:leading-[1.4] tracking-normal   justify-between pr-2  flex">
                {{ ucfirst($lote->titulo) }}
                <span>
                    @if ($lote->estado == 'en_subasta')

                        @if ($lote->pujas()->exists())
                            <x-hammer />
                        @else
                            <x-hammer-fix />
                        @endif

                    @endif
                </span>

            </h2>
            <ul
                class="flex space-x-2 [&>li]:rounded-2xl  [&>li]:px-3 [&>li]:lg:py-1.5 [&>li]:py-0.5  [&>li]:tet-sm my-2 lg:text-base text-sm font-semibold">
                <li class="">{{ $lote->tipo?->nombre }}</li>
                <li class="">Lote: {{ $lote->id }}</li>

                <li class="border border-gray-600">
                    <a href="{{ route($route, $subasta->id) }}" title="Ir a subasta {{ $subasta->titulo }}">Subasta:
                        {{ $subasta->titulo }}</a>
                </li>


            </ul>
        </div>

        <div
            class="flex flex-col lg:ml-18 pt-4 pl-2  g-red-300 max-w-150  lg:col-start-2  lg:row-start-2 lg:row-end-3 row-start-3">


            <div class="lg:order-1 order-2">

                <p class="lg:text-lg text-sm "><span class="font-semibold">Descripción:</span>
                    {{ $lote->descripcion }}.</p>

                @if ($lote->desc_extra)
                    <x-modal-desc-extra-lote :titulo="$lote->titulo" :desc="$lote->desc_extra" />
                @endif

            </div>

            <ul class="text-sm my-2 flex flex-col lg:order-2 order-3">

                {{--  --}}
                @if (!empty($caracteristicas) && (is_array($caracteristicas) || is_object($caracteristicas)))
                    @foreach ($caracteristicas as $item)
                        @if ($item->tipo == 'file')
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

                            {{-- <audio controls class="h-6 text-xs my-0 w-full border border-gray-400 rounded-lg"
                                            wire:key="audio-{{ $item->id }}-{{ md5($url) }}">
                                            @if ($exists)
                                                <source src="{{ $url }}?t={{ time() }}"  --}}
                            {{-- type="{{ pathinfo($formData[$item->id], PATHINFO_EXTENSION) === 'mp3' ? 'audio/mpeg' : 'audio/wav' }}">> --}}
                            {{-- @endif
                                    
                                </audio>  --}}
                        @else
                            @if ($formData[$item->id])
                                <li>
                                    <span class="font-semibold mr-1  mt-0.5">{{ $item->nombre }}:</span>
                                    <span>{{ $formData[$item->id] }}</span>
                                </li>
                            @endif
                        @endif
                    @endforeach
                @endif


                {{--  --}}
            </ul>

            <p class="lg:order-3 order-4 "><span class="font-semibold mr-1 ">Base: </span>
                {{ $moneda }}{{ (int) $base }}
            </p>

            @if ($lote->estado == 'en_subasta')
                <p class="font-bold mb-3 lg:order-4 order-5"> <span class="mr-1">Oferta actual: </span>
                    {{ $moneda }}{{ (int) $ultimaOferta }}</p>
            @endif

            @if ($url)
                <audio controls controlslist=" nodownload noplaybackrate volume"
                    class="h-9 text-xs w-full border border-gray-400 rounded-full mb-2 mt-2 audiodetalle max-w-90 lg:order-5 order-1 ">
                    @if ($exists)
                        <source class="bg-yellow-400 text-blue-500" src="{{ $url }}?t={{ time() }}">
                    @endif
                    Tu
                </audio>



            @endif
            {{-- @dump($lote->estado) --}}




            @role('adquirente')
                <div class="flex  flex-col  relative pb-4 order-8">
                    @if ($lote->estado == 'en_subasta')


                        @if (auth()->user()?->adquirente?->estado_id == 1 ||
                                auth()->user()?->adquirente?->garantia($lote->ultimoContrato?->subasta_id))
                            @if (!$inCart)
                                <button
                                    class="bg-casa-black hover:bg-casa-base-2 text-casa-base hover:text-casa-black border border-casa-black rounded-full px-4 flex items-center justify-between gap-x-5 py-1 max-w-90 mt-4 font-bold"
                                    wire:click="addCarrito">
                                    Hace click para ofertar
                                    <svg class="size-[26px]">
                                        <use xlink:href="#arrow-right1"></use>
                                    </svg>
                                </button>
                            @else
                                <a href="{{ route('pantalla-pujas') }}"
                                    class="bg-casa-fondo hover:bg-casa-black hover:text-casa-base  text-casa-black border  border-casa-black rounded-full px-4 flex items-center justify-between gap-x-5 py-1 max-w-90 mt-4 font-bold"
                                    wire:click="addCarrito">
                                    Ver tus lotes
                                    <svg class="size-[26px] ">
                                        <use xlink:href="#arrow-right1"></use>
                                    </svg>
                                </a>
                            @endif
                            <x-input-error for="puja" class="absolute -bottom-1 text-red-800  text-lg" />


                            <div x-data="{ message: '', redirect: '', delay: 2000 }"
                                x-on:show-message-and-redirect.window="
        message = $event.detail.message;
        redirect = $event.detail.redirect;
        delay = $event.detail.delay ?? 2000;

        setTimeout(() => {
            window.location.href = redirect;
        }, delay);
    ">
                                <span x-text="message" class="text-green-600 font-semibold"></span>
                            </div>


                            @if (session('show-message-and-redirect'))
                                <div class="text-green-600 text-lg ">
                                    {{ session('message') }}
                                </div>
                            @endif
                        @else
                            {{-- NOT DEPOSITO --}}
                            <button
                                class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1 max-w-90 mt-4"
                                wire:click="$set('method','noHabilitado')">

                                {{-- Registrate para ofertar --}}
                                Hace click para ofertar

                                <svg fill="#fff" class="size-8 ">
                                    <use xlink:href="#arrow-right"></use>
                                </svg>

                            </button>
                        @endif
                    @elseif ($lote->estado != 'en_subasta' && $subasta->estado == 'finalizada')
                        <button
                            class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1 max-w-90 mt-4">
                            Consultar
                            <svg fill="#fff" class="size-8 ">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </button>
                    @endif


                @endrole

            </div>

    </article>







    <div class="  w-full  [&>article]:max-w-5xl">
        @livewire('buscador', ['subasta_id' => $subasta->id, 'route' => $route])


    </div>



    {{-- 
    <div class="pb-0  lg:px-24 overflow-x-hidden  w-full">
        @livewire('destacados', ['subasta_id' => $subasta->id, 'route' => $route])
    </div>


    <div class="md:px-24 w-full">

        @livewire('subastas-abiertas')
    </div>


 --}}






















    {{--  --}}
    <article class="bg-cyan-950/35 rounded-2xl p-5 hidden lex lg:flex-row flex-col gap-x-2 relative lg:mt-32 mt-10">




        <div class="bg-cyn-700 flex flex-col pl-2">





            @role('adquirente')
                <div class="flex  flex-col  relative pb-4">
                    @if (auth()->user()?->adquirente?->estado_id == 1 ||
                            auth()->user()?->adquirente?->garantia($lote->ultimoContrato?->subasta_id))
                        {{-- @if ($own || $pujado)
                        <button
                            class="bg-green-400 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl cursor-not-allowed">
                            Tu oferta es la ultima
                        </button>
                    @else --}}
                        <button
                            class="bg-green-500 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-700"
                            {{-- wire:click.debounce.500ms="registrarPuja(1,500)" wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed" wire:target="registrarPuja" --}}>
                            {{-- Muestra/oculta SÓLO cuando 'registrarPuja' está en ejecución --}}
                            {{-- <span wire:loading.remove wire:target="registrarPuja">Agregar al carrito para Pujar</span> --}}
                            {{-- <span wire:loading.remove wire:target="addCarrito">Agregar al carrito para Pujar</span> --}}
                            <span wire:click="addCarrito">Agregar al carrito para Pujar</span>
                            {{-- <span wire:loading wire:target="registrarPuja">Procesando...</span> --}}
                        </button>
                        <div class="flex bg-red-300">

                            <x-input-error for="puja" class="absolute bottom-0 text-red-600 " />
                        </div>
                        {{-- @endif --}}
                    @else
                        <button wire:click="$set('method', 'noHabilitado')"
                            class="bg-red-800 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl ">No
                            habilitado para esta subasta</button>
                        {{-- <button
                        class="bg-green-500 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-700">
                        <span wire:click="addCarrito">Agregar al carrito para Pujar</span>
                    </button> --}}
                    @endif

                    @if (session('message'))
                        <div class="text-green-500 text-lg ">
                            {{ session('message') }}
                        </div>
                    @endif

                    <x-input-error for="puja" class="absolute bottom-0 text-white " />

                </div>
            @endrole

            {{-- @if (auth()->user()?->adquirente?->garantia(9))
                    <button
                        class="bg-green-300 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-500">
                        Pujar G</button>
                @endif --}}

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
                x-show="isValid && timeRemaining !== '00:00'" x-cloak class="absolute top-0 left-0 w-full ">
                <p class="text-gray-100 mb-1 bg-yellow-800 w-fit  text-center font-bold  rounded-b-xl mx-auto px-4 ">
                    Tiempo restante:
                    <span x-text="timeRemaining" class="text-white font-extrabold"></span>
                </p>
            </div>
        @endif

    </article>























    @push('timer')
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

                        // console.log(`new INIT for lote ${loteId}`);
                        // console.log(`endTime from data attribute: ${endTimeString}`);
                        // console.log(`end (Date object): ${end}`);
                        // console.log(`now: ${now}`);

                        if (!isNaN(end.getTime()) && end > now) {
                            this.isValid = true;

                            const updateTimer = () => {
                                const currentNow = new Date();
                                const diff = end - currentNow;

                                if (diff <= 0) {
                                    this.timeRemaining = '00:00';
                                    this.isValid = false; // Oculta el contador
                                    clearInterval(this.interval);
                                    // console.log(`Temporizador detenido para lote ${loteId}: tiempo agotado`);

                                    // console.log(
                                    //     `Despachando evento 'timer-expired' para el lote ${loteId}`);
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
    @endpush
</div>
