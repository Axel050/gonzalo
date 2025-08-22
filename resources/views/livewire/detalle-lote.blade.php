<div class="flex flex-col justify-center items-center hvh w-full  pt-0 ">

    @if ($method == 'noHabilitado')
        @livewire('modal-no-habilitado-pujar', ['subasta' => $lote->ultimoContrato?->subasta_id, 'adquirente' => $adquirente->id, 'lote' => $lote_id], key('modal-contrato-lotes-'))
    @endif
    {{-- @dump($method) --}}
    {{-- @dump(config('services.mercadopago.host') . '/success') --}}


    <x-counter-header />


    {{--  --}}
    <article class="b-white flex idden p-4 mt-20 g-blue-600  shadow-lg rounded-2xl mb-10">
        <div x-data="{
            records: @js($records),
            currentIndex: 0,
            next() {
                this.currentIndex = (this.currentIndex + 1) % this.records.length;
            },
            prev() {
                this.currentIndex = (this.currentIndex - 1 + this.records.length) % this.records.length;
            },
            goTo(index) {
                this.currentIndex = index;
            }
        }" class="flex flex-col items-center ">
            {{-- Imagen principal --}}
            <div class="relative w-full flex justify-center bg-yllow-300 max-w-150 g-yellow-300">
                <button @click="prev"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10  rounded-full px-2 py-1 hover:scale-105">
                    <svg class="rotate-180" width="39" height="67" viewBox="0 0 39 67" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.26917 65.5L36.7307 33.5L2.26918 1.5" stroke="#262626" stroke-width="3"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M2.26917 65.5L36.7307 33.5L2.26918 1.5" stroke="black" stroke-opacity="0.2"
                            stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg></button>

                <figure class="bg-range-200 w-150">

                    <img :src="records[currentIndex].image"
                        class="size-111  object-contain transition-all duration-500 ease-in-out b-blue-300 mx-auto"
                        x-transition:enter="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                </figure>

                <button @click="next"
                    class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bgwhite/70 rounded-full px-2 py-1 hover:scale-105">

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
            <div class="flex gap-2 mt-4">
                <template x-for="(record, index) in records" :key="index">
                    <img :src="record.thumb ?? record.image" @click="goTo(index)"
                        class="w-20 h-20 object-contain cursor-pointer border-2 rounded-md transition-all duration-300 "
                        :class="index === currentIndex ? 'border-casa-black  scale-110 ' :
                            'border-transparent hover:scale-105 hover:border-casa-black/25'">
                </template>
            </div>

        </div>



        {{-- SECOND --}}
        <div class="flex flex-col ml-18 pt-4 pl-2  g-red-300 max-w-150">
            <h2 class="font-helvetica font-bold text-[30px] leading-[1.4] tracking-normal  flex justify-between pr-2">
                {{ ucfirst($lote->titulo) }}
                <span>
                    <x-hammer />

                </span>

            </h2>
            <ul
                class="flex space-x-2 [&>li]:rounded-2xl [&>li]:border [&>li]:px-3 [&>li]:py-1.5 [&>li]:border-gray-600 [&>li]:text-sm my-2">
                <li>{{ $lote->tipo?->nombre }}</li>
                <li>Lote: {{ $lote->id }}</li>
                <li>Subasta: objetos</li>

            </ul>


            <p class="text-lg"><span class="font-semibold">Descripción:</span> {{ $lote->descripcion }}.</p>

            <ul class="text-sm my-2 flex flex-col">

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
                                <li><span
                                        class="font-semibold mr-1">{{ $item->nombre }}:</span>{{ $formData[$item->id] }}
                                </li>
                            @endif
                        @endif
                    @endforeach
                @endif




                {{--  --}}
            </ul>

            <p><span class="font-semibold mr-1 ">Base: </span> {{ $moneda }}{{ (int) $base }}</p>
            <p class="font-bold mb-3"> <span class="mr-1">Oferta actual: </span>
                {{ $moneda }}{{ (int) $ultimaOferta }}</p>

            {{-- <audio controls controlsList="nodownload nofullscreen"  --}}
            @if ($url)
                <audio controls controlslist=" nodownload noplaybackrate volume"
                    class="h-9 text-xs w-full border border-gray-400 rounded-full my-1 audiodetalle max-w-90">
                    @if ($exists)
                        <source class="bg-yellow-400 text-blue-500" src="{{ $url }}?t={{ time() }}">
                    @endif
                    Tu
                </audio>



            @endif


            @role('adquirente')
                <div class="flex  flex-col  relative pb-4">
                    @if (auth()->user()?->adquirente?->estado_id == 1 ||
                            auth()->user()?->adquirente?->garantia($lote->ultimoContrato?->subasta_id))
                        <button
                            class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1 max-w-90 mt-4"
                            wire:click="addCarrito">
                            Ofertar
                            <svg fill="#fff" class="size-8 ">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </button>
                    @else
                        <button
                            class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1 max-w-90 mt-4">
                            Registrate para ofertar
                            <svg fill="#fff" class="size-8 ">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </button>
                    @endif
                @endrole
            </div>

    </article>






    <div class="w-5/6">

        <x-buscador />
    </div>

    {{-- CARRUSEL --}} <div class="swiper2 bg-green-800 my-10 p-4 w-[90vw] hidden ">
        <!-- Additional required wrapper -->
        <div class="swiper2-wrapper bg-orange-400 p-2 w-200">
            <!-- Slides -->
            <div class="swiper2-slide bg-red-500 px-20 size-40">Slide 1</div>
            <div class="swiper2-slide bg-blue-300 px-20 size-40">Slide 2</div>
            <div class="swiper2-slide bg-yellow-300 px-20 size-40">Slide 3</div>
            <div class="swiper2-slide bg-purple-300 px-20 size-40">Slide 4</div>
            ...
        </div>
        <!-- If we need pagination -->
        <div class="swiper2-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper2-button-prev"></div>
        <div class="swiper2-button-next"></div>

        <!-- If we need scrollbar -->
        <div class="swiper2-scrollbar"></div>
    </div>



    <div class="swiper hiden w-[90vw] px-20 mt-10">
        <div class="swiper-wrapper">
            {{-- <article class="flex  w-full px-12 gap-6 mt-18"> --}}


            @for ($i = 0; $i < 5; $i++)
                <div class="w-200 bg-casa-base-2 flex flex-col px-4 py-8 gap-y-4 border border-casa-black swiper-slide">

                    <div class="flex gap-x-4">

                        <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}"
                            class="size-36 obje " />


                        <div class="flex flex-col bg-purple grow">

                            <div class="flex items-center  mb-3">
                                <p class="font-semibold text-xl w-full  ">Nombre de lote {{ $i }}</p>
                                <x-hammer />
                            </div>

                            <p class="text-xl">Base: $1000</p>
                            <p class="text-xl font-semibold">Oferta actual: $12.000</p>
                        </div>
                    </div>

                    <div class="flex w-full g-green-300 justify-center px-8 items-center mt-4">
                        <span
                            class="text-4xl border rounded-full size-8 flex items-center pt-0 leading-0 p-2 justify-center border-gray-900">
                            +
                        </span>
                        <button
                            class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1  w-full ml-4">
                            Agregar al carrito
                            <svg class="size-8 ">
                                <use xlink:href="#arrow-right"></use>
                            </svg>
                        </button>
                    </div>

                </div>
            @endfor


            {{-- </article> --}}

        </div>
    </div>




    {{-- SUBSATAS ABIERTAS  --}}


    <section class="flex flex-col mt-20">
        <h2 class="text-center text-3xl font-bold ">subastas abiertas</h2>

        <div class="swiper hiden w-[90vw] px-20 mt-10">


            <div class="swiper-wrapper">
                {{-- <article class="flex  w-full px-12 gap-6 mt-18"> --}}


                @for ($i = 0; $i < 3; $i++)
                    <div
                        class="w-200 bg-casa-fndo-h flex flex-col px-4 py-8 gap-y-4 border border-casa-black swiper-slide">

                        <div class="flex gap-x-4">




                            <div class="flex flex-col bg-purple grow">

                                <div class="flex items-center  mb-3">
                                    <p class="font-semibold text-3xl   w-full font-librecaslon ">Objetos
                                        {{ $i }}</p>
                                    <svg class="size-8 text-black">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg>

                                </div>

                                <p class="text-xl">Abierta hasta el </p>
                                <p class="text-xl font-bold">22 AGO | 21hs </p>

                                <p class="text-xl mt-2">Lorem ipsum dolor sit amet consectetur. Vehicula adipiscing
                                    pellentesque volutpat dui rhoncus neque urna. Sem et praesent gravida tortor proin
                                    massa iaculis. </p>

                            </div>
                        </div>



                    </div>
                @endfor


                {{-- </article> --}}

            </div>
        </div>
    </section>






















    {{--  --}}
    <article class="bg-cyan-950/35 rounded-2xl p-5 hidden lex lg:flex-row flex-col gap-x-2 relative mt-32">

        <div class="bg-cyn-800 flex items-center justify-center bg-geen-100 p-1">
            <figure class="lg:min-h-72  min-h-52 ">
                <img class="lg:max-h-72 max-h-52 w-auto mx-auto "
                    src="{{ Storage::url('imagenes/lotes/normal/' . $lote->foto1) }}" />

            </figure>

        </div>



        <div class="bg-cyn-700 flex flex-col pl-2">






            <h1 class="lg:text-4xl text-2xl text-white mx-auto font-bold"> {{ $lote->titulo }} </h1>

            <p class="text-gray-100 mt-4 text-lg">Lote : <b>{{ $id }}</b></p>
            <p class="text-gray-100 mt-4 text-lg">Subasta : <b>{{ $lote->ultimoContrato?->subasta_id }}</b></p>
            <p class="text-gray-100 mt-4 text-lg">Precio base : <b>{{ (int) $base }}</b></p>
            <p class="text-gray-100 mt-2 text-lg">Precio actual : <b> {{ (int) $ultimaOferta }}</b></p>
            {{-- <p class="text-gray-100 mt-2 text-lg">TIEMPO: <b> {{ $lote->ultimoConLote?->tiempo_post_subasta_fin }}</b> --}}
            </p>



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
