<div>

    <h1 class="text-white font-bold text-xl">Carrito</h1>

    <hr>
    {{-- <button class="bg-white rounded text-red-700 px-5 py-2 mt-4 ml-40 mr-30 " wire:click="activar">Cheack Activar</button>
    <button class="bg-white rounded text-red-700 px-5 py-2 mt-4 mx-auto " wire:click="job">Cheack Desactivar</button> --}}
    <hr><br>

    {{-- EVALUAR SI PUEDO TRAER DESDE  CARRITO SERVICE YA LOS LOTES CON MAS INFO ; POR EJEMPLO SUBASTA ID ; TIEMPO FIN DUSBASTA ; ETC PARA EVITAR TENER QUE LLAMAR A LOS MODEL TRAS MODEL DESDE BLADE  por  ej: ($lote->ultimoContrato?->subasta->fecha_fin) 
     VER SI DETALLE LOTE PONGO CONTADOR , CREO QUE SI 
    --}}

    <div class="grid grid-cols-3 gap-7 pb-8">
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
