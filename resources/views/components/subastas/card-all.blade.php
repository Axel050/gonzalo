@props([
    'subasta',
    'tipo', // 'abierta', 'proxima', 'pasada'
    'lotes' => collect([]),
    'route',
])

@php
    // Definición de estilos dinámicos según el tipo
    $config = match ($tipo) {
        'abierta' => [
            'container' => 'border border-casa-black text-casa-black',
            'cta' => 'bg-casa-black text-casa-base hover:bg-casa-fondo-h hover:text-casa-black',
            'label' => 'Quiero entrar',
            'enlaceModal' => null,
            'loading' => 'eager',
            'priority' => 'high',
        ],
        'proxima' => [
            'container' => 'bg-casa-black text-casa-base',
            'cta' => 'bg-casa-base text-casa-black hover:bg-casa-black hover:text-casa-base hover:border-casa-base ',
            'label' => 'Ver',
            'enlaceModal' => 'text-casa-base hover:text-casa-base-2',
            'loading' => 'eager',
            'priority' => null,
        ],
        'pasada' => [
            'container' => 'bg-casa-base-2 border border-casa-black/50 text-casa-black',
            'cta' => 'bg-casa-black text-casa-base hover:bg-casa-fondo-h hover:text-casa-black',
            'label' => 'Ver',
            'enlaceModal' => 'text-casa-black hover:text-casa-black-2',
            'loading' => 'lazy',
            'priority' => null,
        ],
    };
@endphp

<article
    {{ $attributes->merge(['class' => 'w-full flex flex-col gap-y-1 relative md:p-8 md:pb-8 p-4 pb-20 ' . $config['container']]) }}>


    <div class="flex gap-x-12">
        <div class="flex flex-col justify-between w-full">
            <p class="font-caslon md:text-4xl text-[26px] mb-3">
                {{ $subasta['titulo'] }}
            </p>

            <div class="mb-2 md:text-xl text-sm">
                @if ($tipo === 'abierta')
                    <p>Abierta hasta el <b>{{ $subasta['fecha_fin'] }}</b></p>
                @elseif ($tipo === 'proxima')
                    <div class="flex gap-14">
                        <div>
                            <p>Desde el</p>
                            <p class="font-bold">{{ $subasta['fecha_inicio'] }}</p>
                        </div>
                        <div>
                            <p>Hasta el</p>
                            <p class="font-bold">{{ $subasta['fecha_fin'] }}</p>
                        </div>
                    </div>
                @else
                    <p>Finalizada el <b>{{ $subasta['fecha_fin'] }}</b></p>
                @endif
            </div>

            <div class="w-full md:w-fit flex flex-col">
                <p class="md:text-xl text-sm">
                    {{ $subasta['descripcion'] }}
                </p>

                @if ($subasta['desc_extra'])
                    <x-modal-desc-extra :titulo="$subasta['titulo']" :desc="$subasta['desc_extra']" :route="$route" :enlace="$config['enlaceModal']" />
                @endif
            </div>
        </div>

        <a href="{{ $route }}"
            class="rounded-full px-4 py-2 font-bold h-fit md:relative absolute bottom-3 md:bottom-0 md:w-70 w-[90%] md:text-xl text-md flex items-center justify-between transition-colors duration-300 border  border-casa-black {{ $config['cta'] }}">
            {{ $config['label'] }}
            <svg class="size-[26px]">
                <use xlink:href="#arrow-right1"></use>
            </svg>
        </a>
    </div>


    @if ($lotes->isNotEmpty())
        <div class="flex justify-center md:mt-8 mt-6 md:max-h-39 max-h-24 w-full overflow-hidden">
            <div class="swiper-destacados-img w-full">
                <div class="swiper-wrapper">
                    @foreach ($lotes as $lote)
                        <div class="swiper-slide">
                            <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $lote['foto']) }}"
                                alt="{{ $lote['titulo'] }}" class="w-full max-h-full object-contain" decoding="async"
                                loading="{{ $config['loading'] }}"
                                @if ($config['priority']) fetchpriority="{{ $config['priority'] }}" @endif>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</article>
