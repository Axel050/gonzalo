@props([
    'subasta',
    'route',
    'lotes',
    'modo' => 'abierta', // abierta | proxima | pasada
])

<article @class([
    'w-full flex flex-col relative gap-y-1 md:p-8 p-4 pb-20',
    'border border-casa-black text-casa-black' => $modo === 'abierta',
    'bg-casa-black text-casa-base' => $modo === 'proxima',
    'bg-casa-base-2 border border-casa-black/50 text-casa-black' =>
        $modo === 'pasada',
])>
    <div class="flex gap-x-12">
        <div class="flex flex-col w-full">
            <p class="font-caslon md:text-4xl text-[26px] mb-3">
                {{ $subasta->titulo }}
            </p>

            {{ $slot }}
        </div>

        <a href="{{ $route }}"
            class="rounded-full px-4 py-2 md:w-70 w-[90%] font-bold flex justify-between items-center absolute md:relative bottom-3 md:bottom-0">
            {{ $modo === 'abierta' ? 'Quiero entrar' : 'Ver' }}
            <svg class="size-[26px]">
                <use xlink:href="#arrow-right1"></use>
            </svg>
        </a>
    </div>

    @if ($lotes->count())
        <div class="flex justify-center md:mt-8 mt-6 w-full overflow-hidden">
            <div class="swiper-destacados-img w-full">
                <div class="swiper-wrapper">
                    @foreach ($lotes as $lote)
                        <div class="swiper-slide">
                            <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote->foto1) }}"
                                alt="{{ $lote->titulo }}" class="mx-auto">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</article>
