<div class="flex flex-col justify-center items-center hvh w-full  pt-0 ">

    @if ($method == 'noHabilitado')
        @livewire('modal-no-habilitado-pujar', ['subasta' => $lote->ultimoContrato?->subasta_id, 'adquirente' => $adquirente->id, 'lote' => $lote_id], key('modal-contrato-lotes-'))
    @endif
    {{-- @dump($method) --}}
    {{-- @dump(config('services.mercadopago.host') . '/success') --}}




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




                <figure class="bg-oange-200 w-150 flex justify-center items-center relative">
                    <!-- Contenedor con el tamaño exacto de la imagen -->
                    {{-- <div class="relative group size-111" wire:click="$set('modal_foto',records[currentIndex].image )"> --}}
                    <div class="relative group size-111"
                        x-on:click="
        @this.set('modal_index', currentIndex);
        @this.set('modal_foto', records[currentIndex].image);
     ">
                        <!-- Imagen -->
                        <img :src="records[currentIndex].image"
                            class="size-111 object-contain transition-all duration-500 ease-in-out mx-auto cursor-pointer"
                            x-transition:enter="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">

                        <!-- Capa de superposición: solo aparece al hacer hover SOBRE la imagen -->
                        <span
                            class="absolute inset-0 bg-gray-800/60 text-casa-base-2 text-4xl font-bold 
             flex justify-center items-center 
             opacity-0 group-hover:opacity-100 transition-opacity duration-900
             pointer-events-none cursor-pointer ">
                            Agrandar
                        </span>
                    </div>
                </figure>

                @if ($modal_foto)
                    {{-- <div class="min-h-screen min-w-screen  absolute inset-0"> --}}
                    {{-- <x-modal-foto-detalle :img="$modal_foto" /> --}}
                    <x-modal-foto-detalle :records="$records" :current-index="$modal_index" />
                    {{-- </div> --}}
                @endif



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
                class="flex space-x-2 [&>li]:rounded-2xl [&>li]:border [&>li]:px-3 [&>li]:py-1.5 [&>li]:border-gray-600 [&>li]:text-sm my-2">
                <li>{{ $lote->tipo?->nombre }}</li>
                <li>Lote: {{ $lote->id }}</li>


                @php
                    $route = match ($lote->estado) {
                        'en_subasta' => 'subasta.lotes',
                        'asignado' => 'subasta-proximas.lotes',
                        default => 'subasta-pasadas.lotes',
                    };
                    // $route = match ($lote->estado) {
                    //     'en_subasta' => route('subasta.lotes', $subasta->id),
                    //     'asignado' => route('subasta-proximas.lotes', $subasta->id),
                    //     default => route('subasta-pasadas.lotes', $subasta->id),
                    // };
                @endphp

                <li>
                    <a href="{{ route($route, $subasta->id) }}">Subasta: {{ $subasta->titulo }}</a>
                </li>


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

            @if ($lote->estado == 'en_subasta')
                <p class="font-bold mb-3"> <span class="mr-1">Oferta actual: </span>
                    {{ $moneda }}{{ (int) $ultimaOferta }}</p>
            @endif

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
            {{-- @dump($lote->estado) --}}




            @role('adquirente')
                <div class="flex  flex-col  relative pb-4">
                    @if ($lote->estado == 'en_subasta')


                        @if (auth()->user()?->adquirente?->estado_id == 1 ||
                                auth()->user()?->adquirente?->garantia($lote->ultimoContrato?->subasta_id))
                            @if (!$inCart)
                                <button
                                    class="bg-casa-black hover:bg-casa-base-2 text-casa-base hover:text-casa-black border border-casa-black rounded-full px-4 flex items-center justify-between gap-x-5 py-1 max-w-90 mt-4"
                                    wire:click="addCarrito">
                                    Agregar al carrito
                                    <svg fill="#fff" class="size-8 ">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg>
                                </button>
                            @else
                                <a href="{{ route('pre-carrito') }}"
                                    class="bg-casa-fondo hover:bg-casa-black hover:text-casa-base  text-casa-black border  border-casa-black rounded-full px-4 flex items-center justify-between gap-x-5 py-1 max-w-90 mt-4"
                                    wire:click="addCarrito">
                                    Agregado a tu carrito
                                    <svg fill="#fff" class="size-8 ">
                                        <use xlink:href="#arrow-right"></use>
                                    </svg>
                                </a>
                            @endif
                            <x-input-error for="puja" class="absolute -bottom-1 text-red-800  text-lg" />
                            @if (session('message'))
                                <div class="text-green-600 text-lg ">
                                    {{ session('message') }}
                                </div>
                            @endif
                        @else
                            <button
                                class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1 max-w-90 mt-4">
                                Registrate para ofertar
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





    {{-- $route --}}
    <div class="mt-10">

        @livewire('buscador', ['subasta_id' => $subasta->id, 'route' => $route])

        {{-- <x-buscador /> --}}

    </div>

    {{-- <div class="w-5/6">

        <x-buscador />
    </div> --}}






    @livewire('destacados', ['subasta_id' => $subasta->id, 'route' => $route])


    @livewire('subastas-abiertas')

























    {{--  --}}
    <article class="bg-cyan-950/35 rounded-2xl p-5 hidden lex lg:flex-row flex-col gap-x-2 relative mt-32">




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
