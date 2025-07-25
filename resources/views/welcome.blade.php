<x-layouts.guest>
    {{-- <x-slot name="headerT">
        Lotes
    </x-slot> --}}

    <div class="flex flex-col justify-center items-center bg-gry-400 h-full">

        <h1 class="text-5xl text-white mx-auto   mb-4 text-center font-bold">CASABLANCA.AR </h1>
        <h2 class="text-3xl text-white mx-auto mt-2  mb-4 text-center font-bold">Pagina de inicio </h2>

        <div class="flex gap-x-14 text-white mt-8 bg-cyan-950/55 py-2 px-8 rounded-2xl">
            <a href="{{ route('subasta.lotes', 9) }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-cyan-800">
                Subasta 9
            </a>

            <a href="{{ route('subasta.lotes', 10) }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-cyan-800">
                Subasta 10
            </a>

            <a href="{{ route('subasta.lotes', 11) }}"
                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-cyan-800">
                Subasta 11
            </a>
        </div>


    </div>






</x-layouts.guest>
