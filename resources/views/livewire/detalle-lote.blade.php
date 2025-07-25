<div class="flex flex-col justify-center items-center h-lvh w-full ">


    <article class="bg-cyan-950/35 rounded-2xl p-5 flex lg:flex-row flex-col gap-x-2 relative">

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

            <hr>
            <br>
            {{-- @dump($lote_id) --}}
            {{-- @dump($subasta_id) --}}

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
                        <span class="bg-red-800 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl ">No
                            habilitado para esta subasta</span>
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
    @endpush
</div>
