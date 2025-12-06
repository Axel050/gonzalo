<div class="flex flex-col justify-center items-center hvh w-full  pt-0  ">

    {{-- <div class="mt-10   w-full max-w-7xl">
        @livewire('buscador', ['todas' => true, 'from' => 'subastas'])
    </div> --}}

    {{-- @role('adquirente') --}}
    {{-- @if (auth()->user())
        @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}

    <div class="flex flex-col  px-4 mt-10 gap-8  w-full max-w-7xl">

        {{-- @if (isset($lotes) && count($lotes)) --}}

        @if ($subastas->count())
            {{-- <p class="lg:text-3xl  text-lg font-bold lg:text-center   text-start w-full px-4  lg:mb-0 -mb-2">
                subastas
                abiertas
            </p> --}}
            <x-fancy-heading text="s{u}bast{a}s a{b}iert{a}s" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[32px] text-[20px]  text-center text-wrap font-normal " />
        @endif
        @foreach ($subastas as $sub)
            <div class="w-full  flex flex-col lg:p-8  lg:pb-8  p-4 pb-20  gap-y-1 border border-casa-black relative">


                <div class="flex  gap-x-12">



                    <div class="flex  flex-col justify-between items-start  w-full ">
                        <p class="font-casa-caslon  lg:text-4xl text-[26px]  mb-3">{{ $sub->titulo }}</p>

                        @php
                            $fecha = \Carbon\Carbon::parse($sub->fecha_fin);
                            $dia = $fecha->translatedFormat('d'); // 06
                            $mes = Str::upper($fecha->translatedFormat('M')); // AGO
                            $hora = $fecha->format('H'); // 11
                        @endphp

                        <p class="mb-2 lg:text-xl text-sm ">Abierta hasta el
                            <b>{{ $dia }} de {{ $mes }} | {{ $hora }}hs</b>
                        </p>


                        @php
                            $routeAbi = route('subasta.lotes', $sub->id);
                        @endphp

                        <div class="flex flex-col g-violet-400 w-full md:w-fit">

                            <p class="lg:text-xl text-sm ">{{ $sub->descripcion }} </p>

                            @if ($sub->desc_extra)
                                <x-modal-desc-extra :titulo="$sub->titulo" :desc="$sub->desc_extra" :route="$routeAbi" />
                            @endif

                        </div>



                    </div>

                    <a href="{{ $routeAbi }}"
                        class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-gray-50 rounded-full px-4 flex lg:relative absolute bottom-3  items-center justify-between  py-2  lg:w-70 w-[90%]  lg:text-xl text-sm font-bold h-fit">
                        Quiero entrar
                        <svg class="lg:size-8 size-6">
                            <use xlink:href="#arrow-right"></use>
                        </svg>
                    </a>


                </div>



                @php
                    $lotesAct = $sub->lotesActivosDestacadosFoto()->get();
                @endphp
                @if ($lotesAct->count() > 0)
                    <div class="flex justify-center lg:mt-8 mt-6 lg:h-39   w-full overflow-hidden">

                        <div class="swiper-destacados-img   w-full " id="swiper-subastas-{{ $loop->index }}">

                            <div class="swiper-wrapper  ">
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

        @if ($subastasProx->count())
            {{-- <p class="lg:text-3xl  text-lg font-bold lg:text-center   text-start w-full px-4  lg:mb-0 -mb-2">
                subastas próximas
            </p> --}}´

            <x-fancy-heading text="s{u}bast{a}s p{r}óxi{m}as" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[32px] text-[20px]  text-center text-wrap font-normal " />
        @endif

        @foreach ($subastasProx as $subP)
            <div
                class="w-full bg-casa-black flex flex-col   gap-y-1  lg:p-8  lg:pb-8  p-4 pb-20 text-casa-base relative">


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

                            {{--  --}}



                            {{--  --}}
                        </div>


                        @php
                            $routeProx = route('subasta-proximas.lotes', $subP->id);
                        @endphp


                        <div class="flex flex-col bgviolet-400 w-full md:w-fit">

                            <p class="lg:text-xl text-sm ">{{ $subP->descripcion }} </p>

                            @if ($subP->desc_extra)
                                <x-modal-desc-extra :titulo="$subP->titulo" :desc="$subP->desc_extra" :route="$routeProx" />
                            @endif

                        </div>

                    </div>

                    <a href="{{ $routeProx }}"
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


        @if ($subastasFin->count())
            {{-- <p class="lg:text-3xl  text-lg font-bold lg:text-center   text-start w-full px-4  lg:mb-0 -mb-2">
                subastas pasadas
            </p> --}}
            <x-fancy-heading text="s{u}bast{a}s p{a}sa{d}as" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[32px] text-[20px]  text-center text-wrap font-normal " />
        @endif

        @foreach ($subastasFin as $subF)
            <div
                class="w-full bg-casa-base-2 flex flex-col lg:p-8  lg:pb-8  p-4 pb-20   gap-y-1 border border-casa-black/50  relative">


                <div class="flex  gap-x-12">

                    <div class="flex  flex-col justify-between items-start g-red-100 w-full  bg-rd-50 ">
                        <p class="font-librecaslon lg:text-4xl text-[26px]  mb-3">{{ $subF->titulo }}</p>

                        @php
                            $fechaFin = \Carbon\Carbon::parse($subF->fecha_fin);
                            $diaFin = $fechaFin->translatedFormat('d'); // 06
                            $mesFin = Str::upper($fechaFin->translatedFormat('M')); // AGO
                            $horaFin = $fechaFin->format('H'); // 11
                        @endphp


                        <div class="flex justify-between gap-14 bg-ble-50">
                            <div class="flex  lg:text-xl text-sm mb-2">
                                <p>Finalizada el</p>
                                <p class="font-bold ml-1">{{ $diaFin }} de {{ $mesFin }} |
                                    {{ $horaFin }}hs</p>
                            </div>






                        </div>

                        @php
                            $routePas = route('subasta-pasadas.lotes', $subF->id);
                        @endphp

                        <div class="flex flex-col g-violet-400 w-full md:w-fit">

                            <p class="lg:text-xl text-sm ">{{ $subF->descripcion }} </p>

                            @if ($subF->desc_extra)
                                <x-modal-desc-extra :titulo="$subF->titulo" :desc="$subF->desc_extra" :route="$routePas" />
                                {{-- <x-modal-desc-extra :titulo="$subF->titulo" :desc="$subF->desc_extra" route="routePas" /> --}}
                            @endif

                        </div>

                    </div>
                    <a href="{{ $routePas }}"
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
