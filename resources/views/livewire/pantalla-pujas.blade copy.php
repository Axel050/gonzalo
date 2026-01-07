<div class="flex flex-col justify-center items-center  w-full  md:gap-y-24 gap-y-16 pt-12 md:px-24 px-4">



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
    class="flex md:flex-wrap md:flex-row flex-col   md:gap-12 gap-2 place-content-center justify-center max-w-8xl  w-full items-stretch md:px-0 x-2  ">

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

    // $de = $actual + $lote['fraccion_min'];

    @endphp



    <div class="flex flex-col  md:w-[30%] w-full">


      <div class="flex  flex-col py-2   md:p-6 p-4  bg-casa-base-2 md:border border-casa-black">

        <div class="md:flex hidden w-full justify-between">

          {{-- <h2 class="  md:text-3xl  font-bold line-clamp-1 ">
                                {{ $lote['titulo'] }} aeeee eeee eeee
          </h2> --}}

          {{-- <x-clamp :text="$lote['titulo']" /> --}}
          <x-clamp :text="$lote['titulo']" bclass=" mr-1" mas="absolute -bottom-2 -right-2 md:right-0 " />


          {{-- --}}

          <button class=" -mt-3 -mr-3 h-fit disabled:opacity-30 disabled:cursor-not-allowed"
            wire:click="quitar({{ $lote['id'] }})"
            title="{{ $adquirenteEsGanador ? 'No puedes quitar, tu oferta es la ultima' : 'Quitar del listado' }}"
            @disabled($adquirenteEsGanador)>
            <svg class="size-8 ">
              <use xlink:href="#trash"></use>
            </svg>
          </button>
        </div>


        <div class="flex md:flex-col ">


          <div class="flex  md:py-4 py-3 md:w-full w-20 justify-center ">
            <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}"
              class="md:size-49 size-20 " {{-- class=" size-20 " --}} />
          </div>

          <div class="flex flex-col   w-full md:pl-0 pl-2 ">

            <div class="md:hidden flex w-full  justify-between ">
              {{-- <h1 class="  text-sm  font-bold "> {{ $lote['titulo'] }}</h1> --}}
              <x-clamp :text="$lote['titulo']" class="text-sm font-bold " />

              <div class=" flex items-center gap-2">
                <div class="inline-block md:hidden">
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
              <ul class="flex gap-4 text-sm  mb-2 mt-1 md:mt-0">
                <li
                  class="md:px-3 px-2 md:py-2 py-0.5 rounded-full border border-casa-black md:text-sm text-xs">
                  <a href="{{ route('lotes.show', $lote['id']) }}" title="Ir a lote">Lote:
                    {{ $lote->id }}</a>
                </li>

                @php
                if ($subastaActiva) {
                $rou = 'subasta.lotes';
                } else {
                $rou = 'subasta-pasadas.lotes';
                }
                @endphp
                <li
                  class="md:px-3 px-2 md:py-2 py-0.5 rounded-full border border-casa-rojo md:text-sm text-xs text-casa-rojo font-semibold hover:bg-casa-rojo hover:text-casa-base">
                  {{-- <a href="{{ route('subasta.lotes', $lote->ultimoContrato?->subasta_id) }}" --}}
                  <a href="{{ route($rou, $lote->ultimoContrato?->subasta_id) }}"
                    title="Ir a subasta">Subasta:
                    {{ $lote->ultimoContrato?->subasta?->titulo }}</a>
                </li>
              </ul>

              <div class="md:inline-block hidden">
                @if ($subastaActiva)
                @if (count($lote->pujas))
                <x-hammer />
                @else
                <x-hammer-fix />
                @endif
                @endif
              </div>

            </div>



            <p class=" md:text-xl text-sm"> Base :
              {{ $signo }}
              {{ number_format($lote['ultimoConLote']['precio_base'], 0, ',', '.') }}
            </p>
            <p class=" md:text-xl text-sm font-bold"> Oferta actual :
              {{ $signo }} {{ $actual }}
            </p>

          </div>

        </div>

        <div class=" flex flex-col  gap-y-2">

          <div class=" text-sm md:text-xl md:mt-2"> Fracción minima :
            {{ $signo }} {{ number_format($lote['fraccion_min'], 0, ',', '.') }}
          </div>




          {{-- <input type="number"
                            class="bg-base border border-casa-black text-casa-black rounded-full px-4 md:py-2 py-1 w-full md:text-xl  text-sm font-semibold "
                            placeholder="Tu oferta" wire:model.defer="ofertas.{{ $lote->id }}" />

          <button
            class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-casa-base rounded-full px-4 flex items-center justify-between  md:py-2 py-1  w-full  md:text-xl  text-sm font-bold   "
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
            <svg class="md:size-8 size-6 ">
              <use xlink:href="#arrow-right"></use>
            </svg>
          </button>

          <x-input-error-front for="puja.{{ $lote['id'] }}"
            class="absolte bottom-0 text-red-500 order-4 text-md" /> --}}
          @if ($adquirenteEsGanador)
          @if ($subastaActiva)
          <p
            class="text-casa-black border border-black rounded-full px-4 md:py-2 py-1 md:flex items-center justify-center w-full md:text-xl text-sm md:mb-2 mb-1 bg-casa-base   md:order-7 mt-auto">
            Ofertaste: <b class="ml-1">{{ $signo }} {{ $actual }}</b>
          </p>
          @else
          {{-- <span
                                        class="text-casa-black border border-black rounded-full md:px-4  px-1 md:py-2 py-1 w-full md:text-xl text-sm font-bold text-center  md:mb-2 mb-0 block  md:order-7  order-8 md:mt-0 mt-1">
                                        Puja finalizada
                                    </span> --}}

          {{-- <h2
                                    class="text-casa-black border border-black rounded-full px-2 py-0.5 w-full text-xs font-bold text-center   md:hidden order-10">
                                    {{ $subastaActiva ? 'Tu puja es la última' : 'El lote es tuyo' }}
          </h2> --}}

          @if ($lote->ultimoContrato?->subasta->estado == 'finalizada')
          <a href="{{ route('carrito') }}"
            class="bg-casa-green hover:bg-casa-fondo border border-green-500 hover:text-casa-green text-casa-base rounded-full px-4 flex items-center justify-between  md:py-1.5 py-1  w-full  md:text-xl text-sm font-bold order-10 md:mt-1  md:order-11 ">
            Pagar
            <svg class="size-[26px]">
              <use xlink:href="#arrow-right1"></use>
            </svg>

          </a>
          @else
          <span
            class="bg-casa-black   border border-casa-black  text-casa-base rounded-full px-4 flex items-center justify-between  md:py-2 py-1  w-full  md:text-xl text-sm font-bold order-10 md:mt-1  md:order-11 ">
            Preparando orden ...
            <svg
              class="md:size-8  size-6  text-casa-base animate-[spin_3s_linear_infinite]">
              <use xlink:href="#loader"></use>
            </svg>

          </span>
          @endif
          @endif

          {{-- <h2
                                    class="text-casa-black border border-black rounded-full px-4 md:py-2 py-1 w-full md:text-xl text-sm font-bold text-center  block  md:order-10 order-9 relative">

                                    <span
                                        class="relative z-10">¡{{ $subastaActiva ? 'Tu puja es la última' : '¡Ganaste este lote!' }}</span>
          </h2> --}}
          <h2
            class="text-casa-blak border border-black rounded-full px-4 md:py-2 py-1 w-full md:text-xl text-sm font-bold text-center block md:order-10 order-9 relative @if (!$subastaActiva) animate-reverse-pulse @endif">
            <span>
              {{ $subastaActiva ? 'Tu puja es la última' : '¡Ganaste este lote!' }}
            </span>

          </h2>
          @else
          @if ($subastaActiva)
          <div class="flex flex-col md:gap-3 gap-2">


            <div class="flex bg-base border border-casa-black text-casa-black rounded-full px-4 md:text-xl text-sm font-semibold focus-within:border-casa-black focus-within:ring-1 focus-within:ring-casa-black transition"
              x-data="{
                                                valor: @entangle('ofertas.' . $lote->id),
                                                formatNumber() {
                                                    // Solo mantener dígitos
                                                    let num = this.valor?.toString().replace(/\D/g, '') || '0';
                                                    // Aplicar formato con puntos
                                                    this.valor = num ? parseInt(num, 10).toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
                                                },
                                                get valorLimpio() {
                                                    // Devuelve valor limpio como número entero
                                                    let clean = this.valor?.toString().replace(/\D/g, '') || '0';
                                                    return parseInt(clean, 10).toString(); // Elimina ceros a la izquierda y asegura un número
                                                }
                                            }" x-init="$watch('valor', () => formatNumber());
                                            formatNumber()"
              x-on:input="formatNumber(); $wire.set('ofertas.{{ $lote->id }}', valorLimpio, true)">
              <span class="mr-1 py-2">{{ $signo }}</span>
              <input type="text"
                class="md:py-2 py-1 w-full outline-none bg-transparent"
                placeholder="Tu oferta" x-model="valor" pattern="[0-9.]*">
            </div>

            <button
              class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-casa-base rounded-full px-4 flex items-center justify-between  md:py-1.5 py-1  w-full  md:text-xl text-sm font-bold   "
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
              <svg class="size-[26px]">
                <use xlink:href="#arrow-right1"></use>
              </svg>
            </button>





            <x-input-error-front for="puja.{{ $lote['id'] }}"
              class="absolte bottom-0 text-red-500 order-4 text-md" />
            {{-- <x-input-error-front for="quitarx.{{ $lote['id'] }}"
            class="bottom-0 text-red-500 order-4 text-md" /> --}}
          </div>
          @else
          <div class="flex flex-col md:gap-2 gap-0.5 items-center order-7 t-2 mt-auto">
            <span
              class="text-casa-base border bg-casa-rojo rounded-full md:px-4 px-2 md:py-2 py-1 w-full md:text-xl  text-sm font-bold text-center">
              Puja finalizada
            </span>
            <span
              class="text-casa-black border border-black rounded-full md:px-4 px-2 md:py-2 py-1 w-full md:text-xl  text-sm font-bold text-center mt-1">
              Alguien ofertó más
            </span>
          </div>
          @endif
          @endif



          @error('quitar.' . $lote['id'])
          <div class='flex items-center  text-sm text-red-600  relative order-11   md:pt-0 pt-1.5'>
            <svg class="w-4 h-3.5 md:mr-2 mr-1">
              <use xlink:href="#error-icon"></use>
            </svg>
            <p class="">
            <p class='md:max-w-600 leading-[12px] '>
              {{ $message }}
            </p>
          </div>
          @enderror




        </div>
      </div>


      {{-- --}}

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
          class="flex justify-between items-center bg-casa-black w-full md:py-2 py-1     border-casa-black text-casa-base md:px-6 px-2 text-sm  ">
          Tiempo restante:
          <span x-text="timeRemaining" class="text-casa-base font-extrabold"></span>
        </p>
      </div>
      @endif
      {{-- --}}

    </div>
    @endforeach



    {{-- @if ($tieneOrdenes)
                <div class="flex md:flex-row flex-col gap-3 w-full  mt4 px-4 bg-red-900">

                    <p class="md:text-3xl font-bold text-sm md:w-1/2 md:text-start text-center w-full">Tenés lotes para
                        pagar en tu carrito</p>

                    <a href="{{ route('carrito') }}"
    class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-casa-base rounded-full px-4 flex items-center justify-between md:py-2 py-1 md:text-xl text-sm font-bold md:w-1/2 w-full">
    Ver tu carrito
    <svg class="size-[26px]">
      <use xlink:href="#arrow-right1"></use>
    </svg>
    </a>

  </div>
  @endif

  --}}
  @else
  <div class="flex flex-col bg-casa-black px-5 py-10 font-semibold text-casa-base my-30 gap-y-8">

    <h2 class="bg-casa-black md:px-15  mx-auto md:text-3xl text-xl">
      ¡Agrega lotes para empezar a pujar!</h2>
    <a href="{{ route('subastas') }}"
      class="bg-casa-base-2 text-casa-black text-xl px-8 py-2 rounded-full w-fit mx-auto text-center">Subastas</a>
  </div>

  @endif





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