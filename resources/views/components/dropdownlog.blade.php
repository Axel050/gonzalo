<div class="    hover:text-gray-100 hover:shadow-md hover:shadow-cyan-700  relative rounded-lg px-0  h-8  z-50"
    x-data="{ open: false }" @click="open = ! open" @click.outside="open = false" x
    :class="{ ' block idden lock transition-all duration-1000': !openSide }">
    {{-- :class="{ ' lg:block hidden lock transition-all duration-1000': !openSide }"> --}}


    <div class="flex   justify-start items-center py-0.5 pl-2 borde lg:w-48 w-40 rounded-lg"
        :class="{ ' g-cyan-800 text-gray-200 ': open }">

        <svg class="text-white" width="20px" height="20px" viewBox="0 0 24 24" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M4 21C4 17.4735 6.60771 14.5561 10 14.0709M19.8726 15.2038C19.8044 15.2079 19.7357 15.21 19.6667 15.21C18.6422 15.21 17.7077 14.7524 17 14C16.2923 14.7524 15.3578 15.2099 14.3333 15.2099C14.2643 15.2099 14.1956 15.2078 14.1274 15.2037C14.0442 15.5853 14 15.9855 14 16.3979C14 18.6121 15.2748 20.4725 17 21C18.7252 20.4725 20 18.6121 20 16.3979C20 15.9855 19.9558 15.5853 19.8726 15.2038ZM15 7C15 9.20914 13.2091 11 11 11C8.79086 11 7 9.20914 7 7C7 4.79086 8.79086 3 11 3C13.2091 3 15 4.79086 15 7Z"
                stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        <span class="ml-2 lg:mr-10 mr-2    truncate text-sm lg:text-base">
            {{ Auth::user()->name }}
        </span>

        <svg class="ml-auto mr-2" fill="#fff" height="12px" width="12px" version="1.1" id="XMLID_287_"
            viewBox="0 0 24 24" xml:space="preserve" :class="{ 'rotate-90': open }">
            <g id="next">
                <g>
                    <polygon points="6.8,23.7 5.4,22.3 15.7,12 5.4,1.7 6.8,0.3 18.5,12 		" />
                </g>
            </g>
        </svg>
    </div>


    <div class="flex flex-col  absolute top-full  w-full bg-yan-800 text-gray-50 pl-2 gap-y-1 pr-2 rounded-lg border-t-2 border-cyan-900 bg-linear-to-l from-cyan-800 to-cyan-950 "
        x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95">
        {{-- }}}}}}}}}}}}}}}}}}}}}}}}}}}}}}}} --}}
        <div class="border-l-2 ml-2 my-2 px-1 border-cyan-900 w-full flex flex-col ">
            <p class="font-medium text-sm text-gray-200 p-1  truncate">{{ Auth::user()->email }}</p>




            <a href=""
                class="font-medium  text-gray-200 p-1 pl-3 hover:text-gray-200 hover:font-bold  hover:bg-cyan-900 rounded-lg ">Perfil</a>

            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf

                <a href="{{ route('logout') }}"
                    class="flex items-center p-1 pt-2 hover:text-gray-200 hover:font-bold  hover:bg-cyan-900 rounded-lg mb-2"
                    @click.prevent="$root.submit();">
                    <svg width="20px" height="20px" viewBox="0 0 24 24" fill="#fff"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4 4H13V9H11.5V5.5H5.5V18.5H11.5V15H13V20H4V4Z"
                            fill="#fff" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M17.1332 11.25L15.3578 9.47463L16.4184 8.41397L20.0045 12L16.4184 15.586L15.3578 14.5254L17.1332 12.75H9V11.25H17.1332Z"
                            fill="#fff" />
                    </svg>
                    Salir
                </a>
            </form>
        </div>

    </div>
</div>
