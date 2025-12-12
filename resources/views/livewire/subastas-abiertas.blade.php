<div class="flex flex-col   w-full items-center lg:px-24   ">
    {{-- <p class="lg:text-3xl  text-lg font-bold lg:text-center   text-start w-full px-4 mb-4 lg:mb-8">subastas abiertas</p> --}}

    <x-fancy-heading text="s{u}bast{a}s a{b}iert{a}s" variant="italic mx-[0.5px] font-normal"
        class=" md:text-[32px] text-[20px]  text-center self-start md:self-center md:ml-0 ml-6  text-wrap font-normal  mb-4" />



    <div class="swiper-home-subastas     w-full  lg:overflow-x-hidden lg:px-0 px-4">

        <div class="swiper-wrapper  flex lg:flex-row flex-col">

            @foreach ($subastasAct as $subA)
                <a href="{{ route('subasta.lotes', $subA->id) }}"
                    class="flex flex-col   lg:p-6 p-4 mb-6 swiper-slide border-1 border-casa-black">


                    <div class="flex justify-between items-center lg:mb-4 mb-2">

                        <p class="text-[26px]  lg:text-[40px] font-caslon leading-[40px]">{{ $subA->titulo }} </p>
                        <svg fill="#fff" class="size-8  ml-8 shrink-0 self-start">
                            <use xlink:href="#arrow-right"></use>
                        </svg>
                    </div>

                    @php
                        $fecha = \Carbon\Carbon::parse($subA->fecha_fin);
                        $dia = $fecha->translatedFormat('d'); // 06
                        $mes = Str::upper($fecha->translatedFormat('M')); // AGO
                        $hora = $fecha->format('H'); // 11
                    @endphp

                    <div class="flex flex-col">
                        <p>Hasta el</p>


                        <b>{{ $dia }} de {{ $mes }} | {{ $hora }}hs</b>
                    </div>

                    <p class="text-xl line-clamp-3">{{ $subA->descripcion }} </p>

                    @if ($subA->desc_extra)
                        <x-modal-desc-extra-home :titulo="$subA->titulo" :desc="$subA->desc_extra" :route="route('subasta.lotes', $subA->id)" />
                    @endif




                </a>
                {{-- @endfor --}}
            @endforeach

        </div>
    </div>

</div>
