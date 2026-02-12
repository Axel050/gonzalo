@props([
    'item',
    'route',
    'bg' => 'bg-casa-black',
    'text' => 'text-casa-base',
    'border' => '',
    'enlaceExtra' => null,
])

<a href="{{ $route }}"
    class="flex flex-col {{ $bg }} {{ $text }} p-6 swiper-slide {{ $border }} md:mb-0 mb-4">


    <div class="flex justify-between items-center md:mb-4 mb-2">
        <p class="text-[26px] md:text-[30px] lg:text-[36px] xl:text-[40px] font-caslon leading-[40px]">
            {{ $item->titulo }}
        </p>

        <svg class="size-[26px] ml-5 lg:ml-8 self-start flex-shrink-0">
            <use xlink:href="#arrow-right1"></use>
        </svg>
    </div>


    <div class="flex justify-between md:text-[17px] lg:text-lg xl:text-xl text-sm">
        <div class="flex flex-col mb-1.5">
            <p>Desde el</p>
            <p class="font-bold">{{ $item->fecha_inicio_humana }}</p>
        </div>

        <div class="flex flex-col">
            <p>Hasta el</p>
            <p class="font-bold">{{ $item->fecha_fin_humana }}</p>
        </div>
    </div>


    <p class="text-xl line-clamp-3">
        {{ $item->descripcion }}
    </p>



    {{-- Extra --}}
    @if ($item->desc_extra)
        <x-modal-desc-extra-home :titulo="$item->titulo" :desc="$item->desc_extra" :route="$route" :enlace="$enlaceExtra" />
    @endif

    {{-- @if ($item->envio)
        <x-modal-desc-envio :titulo="$item->titulo" :envio="$item->envio" home="true" :enlace="$enlaceExtra" />
    @endif --}}

</a>
