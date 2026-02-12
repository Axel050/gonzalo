@props(['titulo', 'envio', 'enlace' => 'text-gray-500 hover:text-casa-black', 'home' => false])



<div x-data="{ open: false }" class="inline-block g-amber-500   {{ $home ? '' : 'relative' }} 2 z-40">

    <!-- Botón para abrir -->
    <button
        class="{{ $enlace }} group flex items-center  md:text-sm text-xs font-medium  hover:text-black  transition-colors mt-2  z-30 {{ $home ? 'absolute bottom-2' : '' }}"
        @click.prevent="open = true" title="ver info envio">
        <svg class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d=" M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
        </svg>

        <span
            class="underline underline-offset-3 transition-colors ml-1
    {{ $enlace && $enlace !== 'text-gray-500 hover:text-casa-black'
        ? 'decoration-gray-400 group-hover:decoration-gray-300'
        : 'decoration-gray-500 group-hover:decoration-black' }}">



            Cómo funciona el envío?
        </span>
    </button>



    <template x-teleport="body">
        <!-- Overlay -->
        <div x-show="open" x-transition.opacity @click.self="open = false"
            class="fixed inset-0 bg-black/50 z-60   flex items-center justify-center">

            <!-- Modal -->
            <div x-show="open" x-transition.scale
                class="bg-casa-base  md:py-6 py-4 md:max-w-3xl  max-w-4/5   mx-4 shadow-xl  text-casa-black md:px-6 px-4">

                <h3 class="md:text-2xl text-xl font-semibold mb-3 px-2 text-center">
                    {{ $titulo }}</h3>

                <h4 class="md:text-xl text-lg fontsemibold mb-2 px-4 md:px-6">Descripción envio subasta
                </h4>

                <p
                    class="text-sm md:text-base leading-relaxed whitespace-pre-lin md:max-h-[50vh] max-h-[60vh] overflow-y-auto px-4 md:px-6">
                    Si vivís en CABA o Gran Buenos Aires, solo te va a costar lo que sale un viaje de aplicación.
                </p>
                {{-- <p
                class="text-sm md:text-base leading-relaxed whitespace-pre-lin md:max-h-[50vh] max-h-[60vh] overflow-y-auto px-4 md:px-6 mx-auto text-center">
                <b>${{ $envio }}</b>
            </p> --}}

                <div class="md:mt-8 mt-6 flex justify-center md:gap-x-12 gap-x-6 ">

                    <button @click="open = false"
                        class="px-2 py-1 rounded-full border border-casa-black  transition bg-casa-base-2 text-casa-black flex items-center hover:bg-casa-black hover:text-casa-base font-bold ">
                        Cerrar

                        <svg class="lg:size-6 size-5  md:ml-12 ml-8 ">
                            <use xlink:href="#close"></use>
                        </svg>

                    </button>



                </div>

            </div>
        </div>

    </template>
</div>
