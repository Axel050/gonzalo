<article class="flex  w-full lg:justify-center flex-col   px-4 ">

    @if ($from != 'home')


        {{-- <h2
            class="font-librecaslon font-normal lg:text-[64px]  text-[37px] leading-[1] tracking-normal lg:text-center text-start"> --}}
        @if ($todas)
            {{-- Subastas --}}

            <x-fancy-heading text="S{u}bast{a}s" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[64px] text-[37px] leading-9 text-center  md:mb-1 text-wrap font-normal" />
        @elseif($view)
            {{-- Lotes --}}

            <x-fancy-heading text="L{o}te{s}" variant="italic mr-[1px]"
                class=" md:text-[64px] text-[37px] leading-9 text-center  md:mb-1 text-wrap " />
        @else
            {{-- <h2
                class="font-librecaslon font-normal lg:text-[64px]  text-[37px] leading-[1] tracking-normal lg:text-center text-start">
                {{ $subasta_bus->titulo }}
            </h2> --}}
            <x-fancy-heading-v text="{{ $subasta_bus->titulo }}" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[64px] text-[36px] leading-9 text-center  md:mb-1 text-wrap font-normal tracking-[0.05em] md:tracking-normal" />
        @endif



        @if ($route)
            <a href="{{ route('subasta.lotes', $subasta_id) }}"
                class="font-helvetica font-semibold lg:text-xl text-sm  tracking-normal lg:text-center text-start mt-4 mb-2  flex border rounded-full px-4 justify-between lg:mx-auto py-1 border-casa-black items-center hover:bg-casa-base-2 w-fit ">
                <span>Ver todos los lotes</span>
                <svg class="lg:size-8 size-5 ml-15">
                    <use xlink:href="#arrow-right"></use>
                </svg>

            </a>
        @endif
        <p class="lg:text-center text-start lg:text-3xl text-sm ">Podés buscar tus lotes por título, característica,
            artista, material, época, etc.
        </p>

    @endif

    <div
        class=" g-blue-200 flex border rounded-full  w-6/6  mx-auto justify-between pl-3 pr-1 py-1 items-center lg:mt-5 mt-3 border-casa-black">

        <div class="flex items-center">
            <svg fill="#fff" class="lg:size-8  size-6 ">
                <use xlink:href="#lupa"></use>
            </svg>
            {{-- <span class="text-nowrap">¿Que buscas?</span> --}}
        </div>



        <input type="search"
            class="w-full lg:mx-3 mx-1 focus:outline-0 placeholder:text-gray-600 placeholder:lg:text-xl  placeholder:text-sm "
            wire:model.live.debounce.500ms="search" placeholder="¿Qué buscas?" />

        <button
            class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full lg:px-4 px-2 flex items-center justify-between  py-2 lg:w-67 w-9"
            wire:click="buscarLotes">
            {{-- wire:click="$parent.filtrar('{{ $search }}')" --}}

            <span class="lg:block hidden">Buscar</span>
            <svg class="lg:size-8 size-5 ">
                <use xlink:href="#arrow-right"></use>
            </svg>
        </button>



    </div>
    @error('search')
        <div class ='flex items-center text-sm text-red-600  justify-center font-semibold pt-1'>

            <svg class="w-4 h-3.5 mr-1">
                <use xlink:href="#error-icon"></use>
            </svg>
            <p class="lg:max-w-80 leading-[12px] ">
                {{ $message }}
            </p>
        </div>
    @enderror




</article>
