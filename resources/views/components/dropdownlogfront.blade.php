<div class="    relative rounded-lg px-0  h-8  z-50" x-data="{ open: false }" @click="open = ! open"
    @click.outside="open = false" x :class="{ ' block idden lock transition-all duration-1000': !openSide }">


    <div class="flex   justify-start items-center py-0.5 pl-2 borde rounded-2xl   hover:bg-casa-fondo-h"
        :class="{ 'bg-casa-fondo-h rounded-b-none border border-gray-600 border-b-0': open }">

        <span class="ml-2 mr-2    truncate text-sm lg:text-base text-gray-800 ">
            {{ Auth::user()->name }}
        </span>

        <svg fill="#fff" class="size-9 ">
            <use xlink:href="#user"></use>
        </svg>

    </div>


    <div class="flex flex-col  absolute botton-1.5 right-0   wfull  text-gray-500 pl-2 gap-y-1 pr-2 rounded-lg rounded-tr-none border border-gray-500 bg-casa-fondo-h"
        x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95">

        <div class="border-l-2 ml-1 my-2 px-1 border-gray-400 w-full flex flex-col">
            <p class="font-medium text-sm text-gray-600 p-1  truncte ">{{ Auth::user()->email }}</p>


            @role(['admin', 'super-admin'])
                <a href="{{ url('/dashboard') }}"
                    class="ilex items-center p-1  hover:text-gray-200 hover:font-bold  hover:bg-casa-black rounded-lg mb-2 text-gray-800 mt-1">
                    Dashboard
                </a>
            @endrole


            {{-- <a href=""
                class="font-medium  text-gray-200 p-1 pl-3 hover:text-gray-200 hover:font-bold  hover:bg-cyan-900 rounded-lg ">Perfil</a> --}}

            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf

                <a href="{{ route('logout') }}"
                    class="flex items-center p-1  hover:text-gray-200 hover:font-bold  hover:bg-casa-black rounded-lg mb-2 text-gray-800"
                    @click.prevent="$root.submit();">

                    <svg fill="currentColor" class="size-7 ">
                        <use xlink:href="#exit"></use>
                    </svg>
                    Salir
                </a>
            </form>
        </div>

    </div>
</div>
