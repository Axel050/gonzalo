<div class="flex flex-col justify-center items-center hvh w-full  pt-0  ">


    <x-counter-header />


    <article class="bg-red-00 flex idden  w-full justify-center flex-col mt-10 mb-8">
        <svg fill="#fff" class="w-[262px] h-[47px] mx-auto mb-2">
            <use xlink:href="#tucarrito"></use>
        </svg>
        <h3 class="font-helvetica font-semibold text-3xl leading-[1] tracking-normal text-center mt-4 mb-2 ">Pagá por los
            lotes que ganaste.
        </h3>
        <p class="text-center text-3xl">Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna.</p>
    </article>





    <div class="flex  idden  flex-col px-20 mt-10  mb-2 g-red-500 w-5/6">

        @if (isset($lotes) && count($lotes))
            @foreach ($lotes as $lote)
                <div class="w-full bg-casa-base-2  flex p-6 gap-y-1 border border-casa-black justify-between">


                    <div class="flex g-blue-300 gap-x-4 ">

                        <div class="flex gap-x-4 justify-center  size-34">
                            <img src="{{ Storage::url('imagenes/lotes/normal/' . $lote->foto1) }}" class="w-full   " />
                        </div>

                        <div class="flex flex-col justify-center">

                            <ul class="flex gap-3 text-sm">
                                <li class="px-3 py-2 rounded-full border border-casa-black">Lote: 29</li>
                                <li class="px-3 py-2 rounded-full border border-casa-black">Subasta: Objetos</li>
                            </ul>


                            <a href="{{ route('lotes.show', $lote['id']) }}"
                                class="font-bold text-xl w-full  my-1 ">{{ $lote['titulo'] }}</a>

                            @php
                                $actual =
                                    optional($lote->getPujaFinal())->monto !== null
                                        ? (int) $lote->getPujaFinal()->monto
                                        : 0;

                                if (is_int($actual)) {
                                    $actual = number_format($actual, 0, ',', '.');
                                }

                                $signo = $this->getMonedaSigno($lote->moneda);
                            @endphp




                            <p class="text-xl font-bold mb-3"> {{ $signo }}{{ $actual }}
                            </p>

                        </div>



                    </div>


                    <p
                        class="text-center text-casa-black   border border-black rounded-full px-8   py-2    text-xl  mb-2 font-bold  w-fit h-fit self-end">
                        El lote es tuyo
                    </p>





                </div>
            @endforeach
        @endif


        <a href="{{ route('carrito') }}"
            class="bg-casa-black hover:bg-casa-base-2 border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2 text-xl font-bold w-full mt-12">
            Pagar todos tus lotes
            <svg class="size-8 ">
                <use xlink:href="#arrow-right"></use>
            </svg>
        </a>


    </div>







</div>
