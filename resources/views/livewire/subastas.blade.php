<div class="flex flex-col justify-center items-center hvh w-full  pt-0  ">
    <x-counter-header />


    <article class="bg-red-00 flex idden  w-full justify-center flex-col mt-18 mb-8 items-center max-w-7xl ">

        <svg fill="#fff" class="w-[273px] h-[49px] mb-1 mt-3">
            <use xlink:href="#subastas"></use>
        </svg>
        <h3 class="font-helvetica font-semibold text-3xl leading-[1] tracking-normal text-center mt-4 mb-2 ">
            Lorem ipsum dolor sit amet consectetur.
        </h3>
        <p class="text-center text-3xl">Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna.</p>


        <div
            class=" g-blue-200 flex border rounded-full  w-6/6  mx-auto justify-between pl-3 pr-1 py-1 items-center mt-5 border-casa-black">

            <div class="flex items-center">
                <svg fill="#fff" class="size-8 ">
                    <use xlink:href="#lupa"></use>
                </svg>
                <span class="text-nowrap">¿Que buscas?</span>
            </div>


            <input class="w-full mx-3 focus:outline-0 " />

            <button
                class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between  py-1 w-67">
                Buscar
                <svg class="size-8 ">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </button>

        </div>

    </article>





    {{-- @role('adquirente') --}}
    {{-- @if (auth()->user())
        @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}




    <div class="flex flex-col px-20 mt-10 gap-8 w-5/6">

        {{-- @if (isset($lotes) && count($lotes)) --}}
        @foreach ($subastas as $sub)
            {{-- <div class="swiper-subastas hiden  x-20  w-full g-red-300" id="swiper-subastas-{{ $loop->index }}"> --}}
            {{-- @for ($i = 0; $i < 3; $i++) --}}
            <div class="w-full bg-casa-fondo-h flex flex-col p-8  gap-y-1 border border-casa-black ">


                <div class="flex g-yellow-200 gap-x-12">

                    <div class="flex  flex-col justify-between items-start g-red-100 w-full ">
                        <p class="font-librecaslon text-4xl mb-3">{{ $sub->titulo }}</p>

                        @php
                            $fecha = \Carbon\Carbon::parse($sub->fecha_fin);
                            $dia = $fecha->translatedFormat('d'); // 06
                            $mes = Str::upper($fecha->translatedFormat('M')); // AGO
                            $hora = $fecha->format('H'); // 11
                        @endphp

                        <p class="mb-2 text-xl ">Abierta hasta el
                            <b>{{ $dia }} de {{ $mes }} | {{ $hora }}hs</b>
                        </p>
                        <p class="text-xl"><b>Lorem ipsum dolor sit amet consectetur. Vehicula adipiscing.</b></p>
                        <p class="text-xl">Lorem ipsum dolor sit amet
                            consectetur. Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna. Sem et
                            praesent gravida tortor proin massa iaculis. Lorem ipsum dolor sit amet consectetur. </p>
                    </div>

                    <a href="{{ route('subasta.lotes', $sub->id) }}"
                        class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-2  w-70 text-xl font-bold h-fit">
                        Quiero entrar
                        <svg class="size-8 ">
                            <use xlink:href="#arrow-right"></use>
                        </svg>
                    </a>


                </div>


                <div class="flex justify-center mt-8 h-39  bg-lue-200 w-full overflow-hidden">


                    <div class="swiper-subastas hiden  x-20  w-full g-red-300" id="swiper-subastas-{{ $loop->index }}">

                        <div class="swiper-wrapper  b-orange-500">

                            @for ($y = 0; $y < 6; $y++)
                                <div class=" swiper-slide order border-gray-700 p-">
                                    <img src="{{ Storage::url('imagenes/lotes/thumbnail/img_1_68a37512b7bfa.png') }}"
                                        class="g-red-800  mx-auto">
                                </div>
                            @endfor

                        </div>
                    </div>


                </div>






            </div>
        @endforeach



    </div>













    {{-- @else --}}
    {{-- <div class="mt-5">
                <x-registrate />
            </div> --}}
    {{-- @endif
    @endif --}}
    {{-- @endrole --}}



    {{-- <button class="bg-blue-600 text-white px-2 my-2 ml-60 rounded-2xl  text-center" wire:click="mp">MP</button>
    <button class="bg-red-600 text-white px-2 my-2 ml-60 rounded-2xl  text-center" wire:click="crearDevolucion(21)">MP -
        REFOUND</button> --}}


    {{-- <button class="bg-white rounded text-red-700 px-5 py-0 ml-40 mr-30 " wire:click="activar">Cheack Activar</button>
    <button class="bg-white rounded text-red-700 px-5 py-0 mx-auto " wire:click="job">Cheack Desactivar</button>
    <hr><br> --}}





</div>
