@props(['titulo', 'desc'])



<div x-data="{ open: false }" class="inline-bock relative ">

    <!-- Botón para abrir -->
    <button class="text-blue-600 underline text-sm hover:text-blue-800 w-fit  " @click.prevent="open=true">
        Ver descripción extra
    </button>

    <!-- Overlay -->
    <div x-show="open" x-transition.opacity @click.self="open = false"
        class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">

        <!-- Modal -->
        <div x-show="open" x-transition.scale
            class="bg-casa-base rounded-xl md:py-6 py-4 md:max-w-3/4 max-w-4/5   mx-4 shadow-xl  text-casa-black md:px-6">

            <h3 class="md:text-2xl text-xl font-semibold mb-3 px-2 text-center">
                {{ $titulo }}
            </h3>

            <h4 class="md:text-xl text-lg fontsemibold mb-2 px-4 md:px-6">Descripción
                Extra
            </h4>

            <p
                class="text-sm  md:text-base leading-relaxed whitespace-pre-lin md:max-h-[50vh] max-h-[60vh] overflow-y-auto px-4 md:px-6">
                {!! nl2br(e($desc)) !!}
            </p>

            <div class="text-right md:mt-8 mt-6">
                <button @click="open = false"
                    class="px-2 py-1 rounded-full border border-casa-black  transition bg-casa-black text-casa-base flex items-center hover:bg-casa-base-2 hover:text-casa-black mx-auto font-bold">
                    Cerrar

                    <svg class="lg:size-6 size-5  ml-12 ">
                        <use xlink:href="#close"></use>
                    </svg>
                </button>
            </div>

        </div>
    </div>

</div>
