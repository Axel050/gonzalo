<x-layouts.guest>

    <div class="flex flex-col items-center min-h-[30vh] px-4 pt-10">

        <x-fancy-heading tag="h1" text="P{r}eg{u}nt{a}s Fr{e}cue{n}t{e}s" variant="italic mx-[0.5px] font-normal"
            class=" md:text-[64px] text-[28px] leading-9 md:text-center text-start   md:mb-1 text-wrap font-normal" />

        <div class="w-full max-w-4xl mx-auto mt-12 space-y-4">

            <div x-data="{ open: false }" class="border-b border-casa-black/20 pb-4">
                <button @click="open = !open"
                    class="w-full flex justify-between items-center text-left md:text-xl text-lg font-semibold">
                    ¿Cómo funciona el proceso de venta?
                    <span x-text="open ? '−' : '+'"></span>
                </button>

                <div x-show="open" x-collapse class="mt-3 text-sm md:text-base">
                    <p>
                        Evaluamos tu objeto, lo tasamos y lo incorporamos a la subasta.
                        Nos ocupamos de la publicación, difusión y gestión completa.
                    </p>
                </div>
            </div>


            <div x-data="{ open: false }" class="border-b border-casa-black/20 pb-4">
                <button @click="open = !open"
                    class="w-full flex justify-between items-center text-left md:text-xl text-lg font-semibold">
                    ¿Cuál es nuestra comsión?
                    <span x-text="open ? '−' : '+'"></span>
                </button>

                <div x-show="open" x-collapse class="mt-3 text-sm md:text-base">
                    <p>
                        Nuestros honorarios son del 20% del valor de venta.
                    </p>
                </div>
            </div>

        </div>




        <div class="w-full max-w-5xl mx-auto mt-16 border-t pt-12">

            <h2 class="text-2xl font-semibold mb-2 text-center">
                ¿No encontraste tu respuesta?
            </h2>

            <p class="text-center mb-8 text-sm md:text-base">
                Escribinos y te ayudamos con tu consulta.
            </p>

            <livewire:contact-form />
        </div>

        {{-- Volver --}}
        <div class="lg:px-24 px-4 flex flex-col gap-y-2 max-w-7xl mt-16">
            <a href="{{ route('home') }}"
                class="bg-casa-base-2 hover:bg-casa-black-h text-casa-black  hover:text-casa-base rounded-full px-4 flex items-center justify-between gap-x-5 py-1 lg:w-fit w-full mx-auto font-bold border  border-casa-black">
                <svg class="size-8 sm:mr-8 rotate-180">
                    <use xlink:href="#arrow-right"></use>
                </svg>
                Volver a inicio
            </a>
        </div>

    </div>






</x-layouts.guest>
