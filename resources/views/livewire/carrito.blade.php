<div class="flex flex-col justify-center items-center hvh w-full     md:gap-y-24 gap-y-15 md:pt-12 pt-6 md:px-24 px-4">



    <article class=" flex  w-full md:justify-center justify-start flex-col  md:px-0 px-4">

        {{-- <svg fill="#fff" class="w-[262px] h-[47px] mx-auto mb-2 md:block hidden">
            <use xlink:href="#tucarrito"></use>
        </svg> --}}

        <x-fancy-heading text="t{u}  c{a}rri{t}o" variant="italic mx-[1px] font-normal"
            class=" md:text-[64px] text-[36px]  md:text-center text-start text-wrap font-medium md:mb-0 mb-2" />

        {{-- <h2 class="md:hidden text-4xl font-helvetica">tu carrito</h2> --}}



        <h3
            class="font-helvetica font-semibold md:text-3xl text-sm leading-[1] tracking-normal md:text-center md:mt-3 mb-2 ">
            Pagá por los
            lotes que ganaste.
        </h3>
        {{-- <p class="md:text-center md:text-3xl text-sm">Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna.
        </p> --}}
    </article>

    @if ($modalPago)
        @livewire('modal-option-pago', ['orden' => $orden, 'subasta' => $subasta, 'adquirente' => $adquirente, 'from' => 'orden', 'conEnvio' => $conEnvio])
    @endif

    <div class="flex md:flex-row flex-col md:gap-8 gap-2  items-start  w-full max-w-8xl">



        <div class="flex  flex-col     mb-2 md:mb-0  w-full gap-2  ">

            @if (isset($lotes) && count($lotes))
                @foreach ($lotes as $lote)
                    <div
                        class="w-full bg-casa-base-2  grid md:grid-cols-4 grid-cols-3 md:p-6 p-4 gap-y-1 md:border border-casa-black justify-between">


                        <div class="flex gap-x-4 justify-center  md:size-34 size-20 col-span-1">
                            <img src="{{ Storage::url('imagenes/lotes/normal/' . $lote->lote->foto1) }}"
                                class="w-full   " />
                        </div>

                        {{-- @dump('CHGECK SINO HAY PUJA ; , VERIFICAR QUE SEA BASE , antes que fraccion') --}}
                        <div class="flex flex-col justify-center col-span-2">

                            <ul class="flex md:flex-row flex-col md:gap-3 gap-2 text-sm">
                                <li
                                    class="md:px-3 px-2 md:py-2 py-0.5 rounded-full border border-casa-black md:text-sm text-xs w-fit">
                                    <a href="{{ route('lotes.show', $lote->lote->id) }}">
                                        Lote: {{ $lote->lote->id }}
                                    </a>
                                </li>
                                <li
                                    class="md:px-3 px-2 md:py-2 py-0.5 rounded-full border border-casa-black md:text-sm text-xs w-fit">
                                    <a
                                        href="{{ route('subasta-pasadas.lotes', $lote->lote->ultimoContrato?->subasta?->id) }}">
                                        Subasta: {{ $lote->lote->ultimoContrato?->subasta?->titulo }}
                                    </a>
                                </li>
                            </ul>


                            <a href="{{ route('lotes.show', $lote['id']) }}"
                                class="font-bold md:text-xl text-sm w-full  my-1 ">{{ $lote->lote->titulo }}</a>




                            <p class="md:text-xl text-sm font-bold mb-3">
                                {{ $lote->lote->moneda_signo }}{{ number_format($lote->lote->monto_actual, 0, ',', '.') }}
                            </p>

                            {{-- </div> --}}



                        </div>


                        <p
                            class="text-center text-casa-black   border border-black rounded-full px-4   py-2    md:text-xl text-sm  mb-2 font-bold  md:w-fit w-full h-fit self-center  md:col-span-1 col-span-3 self">
                            El lote es tuyo
                        </p>





                    </div>
                @endforeach

            @endif

        </div>




        <div class="flex flex-col  md:p-12 p-4 border border-casa-black  md:self-stretch ">
            <h3 class="font-bold md:text-3xl   text-md mb-4">Resumen</h3>
            <p class="md:text-xl text-sm font-semibold">Lorem ipsum</p>
            <p class="md:text-xl text-sm mb-3">Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna</p>



            @foreach ($ordenes as $orden)
                <div class="shadow-md md:p-4 p-2 mb-6 relative ">
                    <h3 class="md;text-2xl text-md font-bold mb-2">
                        Subasta: {{ $orden->subasta->titulo }}
                    </h3>
                    <p class="text-sm mb-3">Orden #{{ $orden->id }} - Estado: {{ ucfirst($orden->estado) }}</p>

                    <ul class="mb-4">
                        @foreach ($orden->lotes as $ol)
                            <li class="flex justify-between">
                                <span>Lote #{{ $ol->lote->id }} - {{ $ol->lote->titulo }}</span>
                                <span>${{ number_format($ol->precio_final, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <p class="flex justify-between border-t border-gray-400 pt-2 font-bold">
                        Subtotal
                        <span>${{ number_format($orden->lotes->sum('precio_final'), 0, ',', '.') }}</span>
                    </p>

                    @php
                        $garantia = collect($garantiasAplicadas)->firstWhere('subasta_id', $orden->subasta->id);
                    @endphp

                    @if ($garantia)
                        <p class="flex justify-between text-sm">
                            Deposito:
                            {{-- {{ $garantia['subasta_titulo'] }} --}}
                            <span>-${{ number_format($garantia['monto'], 0, ',', '.') }}</span>
                        </p>
                    @endif
                    @if ($orden->subasta->envio)
                        <div class="flex justify-between items-center mb-1 text-sm">
                            <p class="flex items-center">Envio </p>

                            ${{ $orden->monto_envio }}
                        </div>
                    @endif

                    @php
                        $total = $orden->lotes->sum('precio_final') - ($garantia['monto'] ?? 0);
                        // $total = $orden->lotes->sum('precio_final') - ($garantia['monto'] ?? 0);

                        if ($envios[$orden->id]) {
                            $total += $orden->subasta->envio;
                        }
                    @endphp
                    <p class="flex justify-between border-t border-black pt-2 text-xl font-bold">
                        Total
                        <span>
                            ${{ number_format($total, 0, ',', '.') }}
                        </span>
                    </p>

                    <button wire:click="mp({{ $orden->id }})"
                        class="bg-casa-black text-casa-base font-bold rounded-full px-4 py-2 mt-4 inline-flex items-center justify-center hover:bg-casa-base-2 hover:text-casa-black m:w-fit w-full border border-casa-black">
                        Pagar esta subasta
                        <svg class="size-[26px] md:ml-auto ml-2 ">
                            <use xlink:href="#arrow-right1"></use>
                        </svg>
                    </button>

                    <x-input-error for="monto" class="abslute -bottom-1 text-red-700  text-md mt-2" />

                </div>
            @endforeach


        </div>




    </div>







</div>
