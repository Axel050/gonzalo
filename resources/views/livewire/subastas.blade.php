<div class="flex flex-col justify-center items-center hvh w-full  pt-0  md:gap-y-24 gap-y-16  ">

    <div class="mt-10   w-full [&>article]:max-w-5xl">
        @livewire('buscador', ['todas' => true, 'from' => 'subastas'])
    </div>

    {{-- @role('adquirente') --}}
    {{-- @if (auth()->user())
        @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}

    {{-- <div class="flex flex-col  px-4 mt-10 gap-8  w-full max-w-7xl"> --}}






    @if (count($subastas))
        <section class="w-full md:max-w-7xl gap-4 flex flex-col">

            <x-fancy-heading text="s{u}bast{a}s a{b}iert{a}s" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[32px] text-[20px]  text-center text-wrap font-normal " />

            @foreach ($subastas as $item)
                <article
                    class="w-full flex flex-col md:p-8 md:pb-8 p-4 pb-20 gap-y-1 border border-casa-black relative text-casa-black">

                    <div class="flex gap-x-12">

                        <div class="flex flex-col justify-between items-start w-full">

                            <p class="font-caslon md:text-4xl text-[26px] mb-3">
                                {{ $item['subasta']['titulo'] }}
                            </p>


                            @php
                                $fecha = \Carbon\Carbon::parse($item['subasta']['fecha_fin']);
                                $dia = $fecha->translatedFormat('d'); // 06
                                $mes = Str::upper($fecha->translatedFormat('M')); // AGO
                                $hora = $fecha->format('H'); // 11
                            @endphp

                            <p class="mb-2 md:text-xl text-sm ">Abierta hasta el
                                <b>{{ $dia }} de {{ $mes }} | {{ $hora }}hs</b>
                            </p>


                            @php
                                $routeAbi = route('subasta.lotes', $item['subasta']['id']);
                            @endphp

                            <div class="flex flex-col g-violet-400 w-full md:w-fit ">

                                <p class="md:text-xl text-sm ">{{ $item['subasta']['descripcion'] }} </p>

                                @if ($item['subasta']['desc_extra'])
                                    <x-modal-desc-extra :titulo="$item['subasta']['titulo']" :desc="$item['subasta']['desc_extra']" :route="$routeAbi" />
                                @endif

                            </div>

                        </div>

                        <a href="{{ $routeAbi }}"
                            class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-casa-base rounded-full px-4 flex md:relative absolute bottom-3 md:bottom-0  items-center justify-between  py-2  md:w-70 w-[90%]  md:text-xl text-md font-bold h-fit">
                            Quiero entrar
                            <svg class="size-[26px]">
                                <use xlink:href="#arrow-right1"></use>
                            </svg>
                        </a>

                    </div>


                    @if ($item['lotes']->isNotEmpty())
                        <div class="flex justify-center md:mt-8 mt-6 md:max-h-39 max-h-24  w-full overflow-hidden">

                            <div class="swiper-destacados-img   w-full " id="swiper-subastas-{{ $loop->index }}">

                                <div class="swiper-wrapper  ">
                                    @foreach ($item['lotes'] as $lote)
                                        <div class="swiper-slide  g-red-500 p-0">
                                            <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                                                class=" w-full max-w-full max-h-full object-contain  "
                                                alt="{{ $lote['titulo'] }}">
                                        </div>
                                    @endforeach

                                </div>
                            </div>


                        </div>
                    @endif
                </article>
            @endforeach

        </section>
    @endif


    @if (count($subastasProx))

        <section class="w-full md:max-w-7xl  gap-4 flex flex-col md:scroll-mt-30 scroll-mt-20" id="proximas">


            <x-fancy-heading text="s{u}bast{a}s p{r}óxi{m}as" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[32px] text-[20px]  text-center text-wrap font-normal " />


            @foreach ($subastasProx as $subP)
                <article
                    class="w-full bg-casa-black flex flex-col   gap-y-1  md:p-8  md:pb-8  p-4 pb-20 text-casa-base relative">


                    <div class="flex  gap-x-12">

                        <div class="flex  flex-col justify-between items-start  w-full ">
                            <p class="font-caslon md:text-4xl text-[26px]  mb-3">{{ $subP['subasta']['titulo'] }}</p>


                            @php
                                $fechaIni = \Carbon\Carbon::parse($subP['subasta']['fecha_inicio']);
                                $diaIni = $fechaIni->translatedFormat('d'); // 06
                                $mesIni = Str::upper($fechaIni->translatedFormat('M')); // AGO
                                $horaIni = $fechaIni->format('H'); // 11

                                $fechaFin = \Carbon\Carbon::parse($subP['subasta']['fecha_fin']);
                                $diaFin = $fechaFin->translatedFormat('d'); // 06
                                $mesFin = Str::upper($fechaFin->translatedFormat('M')); // AGO
                                $horaFin = $fechaFin->format('H'); // 11

                            @endphp


                            <div class="flex justify-between gap-14">

                                <div class="flex flex-col mb-1.5 md:text-xl text-sm">
                                    <p>Desde el</p>
                                    <p class="font-bold"> {{ $diaIni }} de {{ $mesIni }} |
                                        {{ $horaIni }}hs</p>

                                </div>

                                <div class="flex flex-col md:text-xl text-sm">
                                    <p>Hasta el</p>
                                    <p class="font-bold">{{ $diaFin }} de {{ $mesFin }} |
                                        {{ $horaFin }}hs</p>

                                </div>


                            </div>


                            @php
                                $routeProx = route('subasta-proximas.lotes', $subP['subasta']['id']);
                            @endphp


                            <div class="flex flex-col bgviolet-400 w-full md:w-fit">

                                <p class="md:text-xl text-sm ">{{ $subP['subasta']['descripcion'] }} </p>

                                @if ($subP['subasta']['desc_extra'])
                                    <x-modal-desc-extra :titulo="$subP['subasta']['titulo']" :desc="$subP['subasta']['desc_extra']" :route="$routeProx"
                                        enlace="text-casa-base hover:text-casa-base-2" />
                                @endif

                            </div>

                        </div>

                        <a href="{{ $routeProx }}"
                            class="bg-casa-base hover:bg-casa-black text-casa-black  hover:text-casa-base  rounded-full px-4 flex md:relative absolute bottom-3  md:bottom-0 items-center justify-between  py-2  md:w-70 w-[90%]  md:text-xl text-md font-bold h-fit hover:border hover:border-casa-base">
                            Ver
                            <svg class="size-[26px]">
                                <use xlink:href="#arrow-right1"></use>
                            </svg>
                        </a>


                    </div>



                    @if ($subP['lotes']->isNotEmpty())
                        <div class="flex justify-center md:mt-8 mt-6 md:max-h-39 max-h-24   w-full overflow-hidden">


                            <div class="swiper-destacados-img  w-full " id="swiper-subastas-{{ $loop->index }}">

                                <div class="swiper-wrapper  ">

                                    @foreach ($subP['lotes'] as $lote)
                                        <div class="swiper-slide border-gray-700">
                                            <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                                                class=" w-full max-w-full max-h-full object-contain "
                                                alt="{{ $lote['titulo'] }}">
                                        </div>
                                    @endforeach

                                </div>
                            </div>


                        </div>
                    @endif





                </article>
            @endforeach
        </section>
    @endif


    @if (count($subastasFin))
        <section class="w-full md:max-w-7xl  gap-4 flex flex-col md:scroll-mt-30 scroll-mt-20" id="pasadas">

            <x-fancy-heading text="s{u}bast{a}s p{a}sa{d}as" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[32px] text-[20px]  text-center text-wrap font-normal " />


            @foreach ($subastasFin as $subF)
                <article
                    class="w-full bg-casa-base-2 flex flex-col md:p-8  md:pb-8  p-4 pb-20   gap-y-1 border border-casa-black/50  relative text-casa-black">


                    <div class="flex  gap-x-12">

                        <div class="flex  flex-col justify-between items-start g-red-100 w-full  bg-rd-50 ">
                            <p class="font-caslon md:text-4xl text-[26px]  mb-3">{{ $subF['subasta']['titulo'] }}</p>

                            @php
                                $fechaFin = \Carbon\Carbon::parse($subF['subasta']['fecha_fin']);
                                $diaFin = $fechaFin->translatedFormat('d'); // 06
                                $mesFin = Str::upper($fechaFin->translatedFormat('M')); // AGO
                                $horaFin = $fechaFin->format('H'); // 11
                            @endphp


                            <div class="flex justify-between gap-14 bg-ble-50">
                                <div class="flex  md:text-xl text-sm mb-2">
                                    <p>Finalizada el</p>
                                    <p class="font-bold ml-1">{{ $diaFin }} de {{ $mesFin }} |
                                        {{ $horaFin }}hs</p>
                                </div>






                            </div>

                            @php
                                $routePas = route('subasta-pasadas.lotes', $subF['subasta']['id']);
                            @endphp

                            <div class="flex flex-col g-violet-400 w-full md:w-fit">

                                <p class="md:text-xl text-sm ">{{ $subF['subasta']['descripcion'] }} </p>

                                @if ($subF['subasta']['desc_extra'])
                                    <x-modal-desc-extra :titulo="$subF['subasta']['titulo']" :desc="$subF['subasta']['desc_extra']" :route="$routePas" />
                                    {{-- <x-modal-desc-extra :titulo="$subF['subasta']['titulo']" :desc="$subF->desc_extra" route="routePas" /> --}}
                                @endif

                            </div>

                        </div>
                        <a href="{{ $routePas }}"
                            class="bg-casa-black hover:bg-casa-fondo-h border border-casa-black hover:text-casa-black text-casa-base rounded-full px-4 flex md:relative absolute bottom-3 md:bottom-0 items-center justify-between  py-2  md:w-70 w-[90%]  md:text-xl text-md font-bold h-fit">
                            Ver
                            <svg class="size-[26px]">
                                <use xlink:href="#arrow-right1"></use>
                            </svg>
                        </a>


                    </div>

                    @if ($subF['lotes']->isNotEmpty())
                        <div class="flex justify-center md:mt-8 mt-6 md:max-h-39 max-h-24   w-full overflow-hidden">

                            <div class="swiper-destacados-img   w-full " id="swiper-subastas-{{ $loop->index }}">

                                <div class="swiper-wrapper  b-orange-500">
                                    @foreach ($subF['lotes'] as $lote)
                                        <div class="swiper-slide border-gray-700">
                                            <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                                                class=" w-full max-w-full max-h-full object-contain  "
                                                alt="{{ $lote['titulo'] }}">
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                        </div>
                    @endif



                </article>
            @endforeach
        </section>
    @endif









</div>
