<div class="flex flex-col justify-center items-center hvh w-full  pt-0  lg:px-20">



    <article class="bg-red-00 flex  w-full lg:justify-center justify-start flex-col mt-10 lg:mb-8 mb-4 lg:px-0 px-4">
        <svg fill="#fff" class="w-[262px] h-[47px] mx-auto mb-2 lg:block hidden">
            <use xlink:href="#tucarrito"></use>
        </svg>

        <h2 class="lg:hidden text-4xl font-helvetica">tu carrito</h2>



        <h3
            class="font-helvetica font-semibold lg:text-3xl text-sm leading-[1] tracking-normal lg:text-center mt-4 mb-2 ">
            Pagá por los
            lotes que ganaste.
        </h3>
        <p class="lg:text-center lg:text-3xl text-sm">Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna.
        </p>
    </article>



    <div class="flex lg:flex-row flex-col lg:gap-8 gap-2  items-start   ">



        <div class="flex  flex-col  lg:mt-0 mt-8   mb-2 lg:mb-0  w-full gap-2 px-3 lg:px-0 ">

            @if (isset($lotes) && count($lotes))
                @foreach ($lotes as $lote)
                    <div
                        class="w-full bg-casa-base-2  grid lg:grid-cols-4 grid-cols-3 lg:p-6 p-4 gap-y-1 lg:border border-casa-black justify-between">


                        <div class="flex gap-x-4 justify-center  lg:size-34 size-20 col-span-1">
                            <img src="{{ Storage::url('imagenes/lotes/normal/' . $lote->foto1) }}" class="w-full   " />
                        </div>


                        <div class="flex flex-col justify-center col-span-2">

                            <ul class="flex lg:flex-row flex-col lg:gap-3 gap-2 text-sm">
                                <li
                                    class="lg:px-3 px-2 lg:py-2 py-0.5 rounded-full border border-casa-black lg:text-sm text-xs w-fit">
                                    <a href="{{ route('lotes.show', $lote['id']) }}">
                                        Lote: {{ $lote['id'] }}
                                    </a>
                                </li>
                                <li
                                    class="lg:px-3 px-2 lg:py-2 py-0.5 rounded-full border border-casa-black lg:text-sm text-xs w-fit">
                                    <a href="{{ route('lotes.show', $lote['id']) }}">
                                        Subasta: {{ $lote->ultimoContrato?->subasta?->titulo }}
                                    </a>
                                </li>
                            </ul>


                            <a href="{{ route('lotes.show', $lote['id']) }}"
                                class="font-bold lg:text-xl text-sm w-full  my-1 ">{{ $lote['titulo'] }}</a>

                            @php
                                // $signo = $this->getMonedaSigno($lote->moneda);
                            @endphp




                            <p class="lg:text-xl text-sm font-bold mb-3">
                                {{ $lote->moneda_signo }}{{ number_format($lote->monto_actual, 0, ',', '.') }}
                            </p>

                            {{-- </div> --}}



                        </div>


                        <p
                            class="text-center text-casa-black   border border-black rounded-full px-4   py-2    lg:text-xl text-sm  mb-2 font-bold  lg:w-fit w-full h-fit self-center  lg:col-span-1 col-span-3 self">
                            El lote es tuyo
                        </p>





                    </div>
                @endforeach

            @endif

        </div>




        <div class="flex flex-col  lg:p-12 p-4 border border-casa-black lg:mx-0 mx-3 lg:self-stretch ">
            <h3 class="font-bold lg:text-3xl   text-lg mb-4">Resumen</h3>
            <p class="lg:text-xl text-sm font-semibold">Lorem ipsum</p>
            <p class="lg:text-xl text-sm mb-3">Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna</p>



            <p class="lg:text-xl text-sm mb-0 flex justify-between border-t border-casa-black pt-1 mt-1">Seña</p>

            <ul class=" ml-2">

                {{-- @dump('DEBO CORROBAR EL ULTIMA PUJA ; NO SOLO QU ESTE DENRO DE L CARRITO DEL ADQUIERENTE Y SEA ESTADO VENDIDO ') --}}

                @foreach ($garantiasAplicadas as $gar)
                    <li class="flex justify-between">subasta: {{ $gar['subasta_titulo'] }}
                        <span>{{ $gar['monto'] }}</span>
                    </li>
                @endforeach

            </ul>
            <b class="ml-auto">-$ {{ $descuentoGarantias }}</b>


            <p class="lg:text-xl text-sm mb-3 flex justify-between border-t border-casa-black pt-1">Lotes
                <b>$ {{ $totalLotes }}</b>
            </p>

            <p class="lg:text-3xl text-lg mb-3 flex justify-between border-t border-casa-black pt-1">Total
                <b>$ {{ $totalCarrito }}</b>
            </p>



            <a href="{{ route('carrito') }}"
                class="bg-casa-black hover:bg-casa-base-2 border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2 lg:text-xl text-sm font-bold w-full mt-12 lg:mt-auto">
                Pagar
                <svg class="size-8 ">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </a>
        </div>




    </div>







</div>
