<article class="flex   md:justify-center flex-col   px-4 md:px-0  md:mx-auto  w-full">

    @if ($from != 'home')


        {{-- <h2
            class="font-librecaslon font-normal md:text-[64px]  text-[37px] leading-[1] tracking-normal md:text-center text-start"> --}}
        @if ($todas)
            {{-- Subastas --}}

            <x-fancy-heading text="S{u}bast{a}s" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[64px] text-[37px] leading-9 md:text-center text-start   md:mb-1 text-wrap font-normal" />
        @elseif($view)
            {{-- Lotes --}}

            <x-fancy-heading text="L{o}te{s}" variant="italic mr-[1px]"
                class=" md:text-[64px] text-[37px] leading-9 text-center  md:mb-1 text-wrap " />
        @else
            {{-- <h2
                class="font-librecaslon font-normal md:text-[64px]  text-[37px] leading-[1] tracking-normal md:text-center text-start">
                {{ $subasta_bus->titulo }}
            </h2> --}}
            <x-fancy-heading-v text="{{ $subasta_bus->titulo }}" variant="italic  font-normal   -tracking-[3px] "
                class=" md:text-[64px] text-[37px] leadin-9 md:text-center text-start  md:mb-1 text-wrap font-normal   " />
        @endif



        @if ($route)
            <a href="{{ route($route, $subasta_id) }}"
                class="font-helvetica font-semibold md:text-xl text-sm  tracking-normal md:text-center text-start md:mt-3 mt-1 mb-2  flex border rounded-full px-4 justify-between md:mx-auto py-1 border-casa-black items-center hover:bg-casa-base-2 w-fit text-casa-black ">
                <span>Ver todos los lotes</span>
                <svg class="md:size-[26px] size-5 md:ml-15 ml-10">
                    <use xlink:href="#arrow-right1"></use>
                </svg>

            </a>
        @endif
        <p class="md:text-center text-start md:text-2xl text-sm ">Podés buscar tus lotes por título, característica,
            artista, material, época, etc.
        </p>

    @endif

    <div
        class="    flex border rounded-full  w-6/6  mx-auto justify-between pl-3 pr-1 py-1 items-center md:mt-5 mt-3 border-casa-black ">

        <div class="flex items-center">
            <svg fill="#fff" class="md:size-8  size-6 ">
                <use xlink:href="#lupa"></use>
            </svg>
            {{-- <span class="text-nowrap">¿Que buscas?</span> --}}
        </div>



        <input type="search"
            class="w-full md:mx-3 mx-1 focus:outline-0 placeholder:text-gray-600 placeholder:md:text-xl  placeholder:text-sm  "
            wire:model.live.debounce.500ms="search" placeholder="¿Qué buscas?" />

        <button
            class="bg-casa-black hover:bg-casa-black-h text-casa-base rounded-full md:px-4 px-2 flex items-center justify-between  py-2 md:w-67 w-9"
            wire:click="buscarLotes">
            {{-- wire:click="$parent.filtrar('{{ $search }}')" --}}

            <span class="md:block hidden font-bold">Buscar</span>
            <svg class="md:size-[26px] size-5 ">
                <use xlink:href="#arrow-right1"></use>
            </svg>
        </button>



    </div>
    @error('search')
        <div class ='flex items-center text-sm text-red-600  justify-center font-semibold pt-1'>

            <svg class="w-4 h-3.5 mr-1">
                <use xlink:href="#error-icon"></use>
            </svg>
            <p class="md:max-w-80 leading-[12px] ">
                {{ $message }}
            </p>
        </div>
    @enderror




</article>
