<div class="flex flex-col   w-full items-center p-10 rder-1 border-accent mt-8   g-blue-500 ">
    <p class="text-3xl font-bold  ">subastas abiertas</p>

    <div class="swiper-home-subastas hiden    w-full g-red-300  g-red-300 overflow-x-hidden flex justify-center ">

        <div class="swiper-wrapper      g-blue-300  ">

            @foreach ($subastasAct as $subA)
                {{-- @for ($i = 0; $i < 2; $i++) --}}
                <a href="{{ route('subasta.lotes', $subA->id) }}"
                    class="flex flex-col  -h p-6 mt-8 swiper-slide border-1 border-casa-black">

                    <div class="flex justify-between items-center mb-4">
                        <p class="text-[40px] font-librecaslon leading-[40px]">{{ $subA->titulo }} </p>
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

                    <p class="text-xl">Lorem ipsum dolor sit amet consectetur. Vehicula adipiscing
                        pellentesque volutpat dui rhoncus neque urna. Sem et praesent gravida tortor proin
                        massa iaculis. </p>
                </a>
                {{-- @endfor --}}
            @endforeach

        </div>
    </div>

</div>
