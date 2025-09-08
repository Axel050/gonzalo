<article class="bg-red-00 flex idden  w-full justify-center flex-col  mb-8">

    @if ($from != 'home')


        <h2 class="font-librecaslon font-normal text-[64px] leading-[1] tracking-normal text-center">
            @if ($todas)
                Subastas
            @elseif($view)
                Lotes
            @else
                {{ $subasta_bus->titulo }}
            @endif
        </h2>
        <h3 class="font-helvetica font-semibold text-3xl leading-[1] tracking-normal text-center mt-4 mb-2 ">Otros
            lotes
        </h3>
        <p class="text-center text-3xl">Vehicula adipiscing pellentesque volutpat dui rhoncus neque urna.</p>

    @endif

    <div
        class=" g-blue-200 flex border rounded-full  w-6/6  mx-auto justify-between pl-3 pr-1 py-1 items-center mt-5 border-casa-black">

        <div class="flex items-center">
            <svg fill="#fff" class="size-8 ">
                <use xlink:href="#lupa"></use>
            </svg>
            {{-- <span class="text-nowrap">¿Que buscas?</span> --}}
        </div>



        <input type="search" class="w-full mx-3 focus:outline-0 placeholder:text-gray-600 placeholder:text-xl "
            wire:model.live.debounce.500ms="search" placeholder="¿Qué buscas?" />

        <button
            class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between  py-1 w-67"
            wire:click="buscarLotes">
            {{-- wire:click="$parent.filtrar('{{ $search }}')" --}}

            Buscar
            <svg class="size-8 ">
                <use xlink:href="#arrow-right"></use>
            </svg>
        </button>

    </div>





</article>
