<div class="flex flex-col justify-center items-center hvh w-full  pt-0  ">

    <div class="mt-10   w-full max-w-7xl">
        @livewire('buscador', ['todas' => true, 'from' => 'subastas'])
    </div>

    {{-- @role('adquirente') --}}
    {{-- @if (auth()->user())
        @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}

    <div class="flex flex-col  px-4 mt-10 gap-8  w-full max-w-7xl">

        {{-- @if (isset($lotes) && count($lotes)) --}}
        @foreach ($subastas as $sub)
            <div class="w-full  flex flex-col lg:p-8  lg:pb-8  p-4 pb-20  gap-y-1 border border-casa-black relative">


                <div class="flex  gap-x-12">

                    <div class="flex  flex-col justify-between items-start  w-full ">
                        <p class="font-librecaslon lg:text-4xl text-[26px]  mb-3">{{ $sub->titulo }}</p>

                        @php
                            $fecha = \Carbon\Carbon::parse($sub->fecha_fin);
                            $dia = $fecha->translatedFormat('d'); // 06
                            $mes = Str::upper($fecha->translatedFormat('M')); // AGO
                            $hora = $fecha->format('H'); // 11
                        @endphp

                        <p class="mb-2 lg:text-xl text-sm ">Abierta hasta el
                            <b>{{ $dia }} de {{ $mes }} | {{ $hora }}hs</b>
                        </p>
                        <p class=" lg:text-xl text-sm"><b>Lorem ipsum dolor sit amet consectetur. Vehicula
                                adipiscing.</b></p>
                        <p class="lg:text-xl text-sm">Lorem ipsum dolor sit amet
                            consectetur. Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna. Sem et
                            praesent gravida tortor proin massa iaculis. Lorem ipsum dolor sit amet consectetur. </p>
                    </div>

                    <a href="{{ route('subasta.lotes', $sub->id) }}"
                        class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex lg:relative absolute bottom-3  items-center justify-between  py-2  lg:w-70 w-[90%]  lg:text-xl text-sm font-bold h-fit">
                        Quiero entrar
                        <svg class="lg:size-8 size-6">
                            <use xlink:href="#arrow-right"></use>
                        </svg>
                    </a>


                </div>


                <div class="flex justify-center lg:mt-8 mt-6 lg:h-39   w-full overflow-hidden">


                    <div class="swiper-destacados-img   w-full " id="swiper-subastas-{{ $loop->index }}">

                        <div class="swiper-wrapper  ">

                            @php
                                $lotesAct = $sub->lotesActivosDestacadosFoto()->get();
                            @endphp
                            @if ($lotesAct->count() > 0)
                                @foreach ($lotesAct as $lote)
                                    <div class="swiper-slide border-gray-700">
                                        <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}"
                                            class="mx-auto" alt="{{ $lote->titulo }}">
                                    </div>
                                @endforeach

                        </div>
                    </div>


                </div>
        @endif




    </div>
    @endforeach

    @foreach ($subastasProx as $subP)
        <div class="w-full bg-casa-black flex flex-col   gap-y-1  lg:p-8  lg:pb-8  p-4 pb-20 text-casa-base relative">


            <div class="flex  gap-x-12">

                <div class="flex  flex-col justify-between items-start  w-full ">
                    <p class="font-librecaslon lg:text-4xl text-[26px]  mb-3">{{ $subP->titulo }}</p>


                    @php
                        $fechaIni = \Carbon\Carbon::parse($subP->fecha_inicio);
                        $diaIni = $fechaIni->translatedFormat('d'); // 06
                        $mesIni = Str::upper($fechaIni->translatedFormat('M')); // AGO
                        $horaIni = $fechaIni->format('H'); // 11

                        $fechaFin = \Carbon\Carbon::parse($subP->fecha_fin);
                        $diaFin = $fechaFin->translatedFormat('d'); // 06
                        $mesFin = Str::upper($fechaFin->translatedFormat('M')); // AGO
                        $horaFin = $fechaFin->format('H'); // 11

                    @endphp


                    <div class="flex justify-between gap-14">

                        <div class="flex flex-col mb-1.5 lg:text-xl text-sm">
                            <p>Desde el</p>
                            <p class="font-bold"> {{ $diaIni }} de {{ $mesIni }} |
                                {{ $horaIni }}hs</p>

                        </div>

                        <div class="flex flex-col lg:text-xl text-sm">
                            <p>Hasta el</p>
                            <p class="font-bold">{{ $diaFin }} de {{ $mesFin }} |
                                {{ $horaFin }}hs</p>

                        </div>

                    </div>
                    <p class="lg:text-xl text-sm"><b>Lorem ipsum dolor sit amet consectetur. Vehicula adipiscing.</b>
                    </p>
                    <p class="lg:text-xl text-sm">Lorem ipsum dolor sit amet
                        consectetur. Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna. Sem et
                        praesent gravida tortor proin massa iaculis. Lorem ipsum dolor sit amet consectetur. </p>
                </div>

                <a href="{{ route('subasta-proximas.lotes', $subP->id) }}"
                    class="bg-casa-base hover:bg-casa-black text-casa-black  hover:text-casa-base  rounded-full px-4 flex lg:relative absolute bottom-3  items-center justify-between  py-2  lg:w-70 w-[90%]  lg:text-xl text-sm font-bold h-fit hover:border hover:border-casa-base">
                    Ver
                    <svg class="lg:size-8 size-6">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </a>


            </div>


            @php
                $lotesProx = $subP->lotesProximosDestacadosFoto()->get();
            @endphp
            @if ($lotesProx->count() > 0)
                <div class="flex justify-center lg:mt-8 mt-6 lg:h-39   w-full overflow-hidden">


                    <div class="swiper-destacados-img  w-full " id="swiper-subastas-{{ $loop->index }}">

                        <div class="swiper-wrapper  ">

                            @foreach ($lotesProx as $lote)
                                <div class="swiper-slide border-gray-700">
                                    <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}"
                                        class="mx-auto" alt="{{ $lote->titulo }}">
                                </div>
                            @endforeach

                        </div>
                    </div>


                </div>
            @endif





        </div>
    @endforeach


    @foreach ($subastasFin as $subF)
        <div
            class="w-full bg-casa-base-2 flex flex-col lg:p-8  lg:pb-8  p-4 pb-20   gap-y-1 border border-casa-black/50  relative">


            <div class="flex  gap-x-12">

                <div class="flex  flex-col justify-between items-start g-red-100 w-full ">
                    <p class="font-librecaslon lg:text-4xl text-[26px]  mb-3">{{ $subF->titulo }}</p>

                    @php
                        $fechaFin = \Carbon\Carbon::parse($subF->fecha_fin);
                        $diaFin = $fechaFin->translatedFormat('d'); // 06
                        $mesFin = Str::upper($fechaFin->translatedFormat('M')); // AGO
                        $horaFin = $fechaFin->format('H'); // 11
                    @endphp


                    <div class="flex justify-between gap-14">
                        <div class="flex  lg:text-xl text-sm mb-2">
                            <p>Finalizada el</p>
                            <p class="font-bold ml-1">{{ $diaFin }} de {{ $mesFin }} |
                                {{ $horaFin }}hs</p>
                        </div>

                    </div>
                    <p class="lg:text-xl text-sm "><b>Lorem ipsum dolor sit amet consectetur. Vehicula adipiscing.</b>
                    </p>
                    <p class="lg:text-xl text-sm ">Lorem ipsum dolor sit amet
                        consectetur. Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna. Sem et
                        praesent gravida tortor proin massa iaculis. Lorem ipsum dolor sit amet consectetur. </p>
                </div>
                <a href="{{ route('subasta-pasadas.lotes', $subF->id) }}"
                    class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex lg:relative absolute bottom-3  items-center justify-between  py-2  lg:w-70 w-[90%]  lg:text-xl text-sm font-bold h-fit">
                    Ver
                    <svg class="lg:size-8 size-6">
                        <use xlink:href="#arrow-right"></use>
                    </svg>
                </a>


            </div>


            @php
                $lotesFin = $subF->lotesPasadosDestacadosFoto()->get();
            @endphp
            @if ($lotesFin->count() > 0)
                <div class="flex justify-center lg:mt-8 mt-6 lg:h-39   w-full overflow-hidden">

                    <div class="swiper-destacados-img   w-full " id="swiper-subastas-{{ $loop->index }}">

                        <div class="swiper-wrapper  b-orange-500">
                            @foreach ($lotesFin as $lote)
                                <div class="swiper-slide border-gray-700">
                                    <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}"
                                        class="mx-auto" alt="{{ $lote->titulo }}">
                                </div>
                            @endforeach
                        </div>

                    </div>

                </div>
            @endif





        </div>
    @endforeach




</div>


















</div>
