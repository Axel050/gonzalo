<div class="     rounded-lg px-0  h-8  z-50" x-data="{ open: false }" @click.outside="open = false" x
    :class="{ ' block idden lock transition-all duration-1000': !openSide }">
    {{-- <div class="     rounded-lg px-0  h-8  z-50" x-data="{ open: false }" @click="open = ! open" @click.outside="open = false" x
    :class="{ ' block idden lock transition-all duration-1000': !openSide }"> --}}


    <div class="flex   justify-start items-center py-1  border-1  rounded-2xl  border-casa-black  px-2 h-7"
        :class="{ 'bg-casa-fondo-h ': open }" @click="open = ! open">

        <span class="text-sm text-gray-800" x-show="!open">
            Menu
        </span>

        <!-- Cuando está abierto muestra una X -->
        <span class="text-sm text-gray-800" x-show="open">
            ✖ Cerrar
        </span>

    </div>


    <div class="flex flex-col  absolute botton-2 right-0 w-full mt-2   text-gray-500  gap-y-1   border border-accent  bg-casa-base"
        x-show="open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95">

        <div class=" mx-0 my-2   w-full flex flex-col">

            <div class="flex justify-between  px-2 pt-1  pb-2 border-b border-accent">
                @auth

                    <p class="flex justify-between  items-center ">
                        <span class="   text-sm  text-gray-900 ">
                            {{ Auth::user()->name }}
                        </span>

                        <svg fill="#fff" class="size-9 ">
                            <use xlink:href="#user"></use>
                        </svg>
                    </p>

                    {{-- @role('adquirente')
                        <a href="{{ route('pre-carrito') }}" class=" px-2 rounded    pt-1">
                            <svg fill="#fff" class="size-7">
                                <use xlink:href="#cart"></use>
                            </svg>
                        </a>
                    @endrole --}}

                    @role(['admin', 'super-admin'])
                        <a href="{{ url('/dashboard') }}"
                            class="rounded-full px-2 py-0.5  bg-casa-black text-casa-base text-sm flex items-center">
                            Admin
                        </a>
                    @endrole
                @else
                    <div class="flex w-full">
                        <a href="{{ route('login') }}"
                            class="flex items-center py-1   mb-1 mt-1 text-casa-base bg-casa-black rounded-full mx-auto px-10 w-fit  text-base font-semibold">
                            Login</a>
                    </div>
                @endauth
            </div>



            <div class="flex justify-between  p-2 border-b border-accent">
                <div class="flex flex-col items-start gap-2 justify-start">

                    <a href="{{ route('subastas') }}"
                        class=" text-sm border rounded-full px-3 py-1 border-black hover:text-casa-black bg-casa-black text-casa-base  h-fit w-fit ">
                        Subastas
                    </a>

                    <a href="{{ route('adquirentes.create') }}"
                        class=" text-sm border rounded-full px-3 py-1 border-black text-black h-fit w-fit">
                        ¿Primera vez?
                    </a>

                    <a href="{{ route('comitentes.create') }}"
                        class=" text-sm border rounded-full px-3 py-1 border-black mr-8 text-black  h-fit  w-fit">
                        ¿Tenés algo para vender?
                    </a>

                </div>

                <div class="flex  gap-3 ">

                    <a href="https://www.instagram.com/casablanca.ar.subastasonline/" target="_blank">
                        <svg fill="#fff" class="size-6 ">
                            <use xlink:href="#instagram"></use>
                        </svg>
                    </a>

                    <a href="https://wa.me/+541130220449" target="_blank">
                        <svg fill="#fff" class="size-6 ">
                            <use xlink:href="#what"></use>
                        </svg>
                    </a>

                    <a href="mailto:info@casablanca.ar">
                        <svg fill="#fff" class="size-6 ">
                            <use xlink:href="#mail"></use>
                        </svg>
                    </a>

                    <a href="https://www.facebook.com/profile.php?id=61586654246260&rdid=VB7wE43ebenqdLPn&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1AVDgpgN6W%2F#"
                        target="_blank">
                        <svg fill="#fff" class="size-6 ">
                            <use xlink:href="#face"></use>
                        </svg>
                    </a>

                </div>

            </div>

            <div class="flex justify-between  p-2 ">

                <form action="{{ route('subasta-buscador.lotes') }}" method="GET"
                    class="  flex border rounded-full  w-6/6  mx-auto justify-between  py-1 px-2 items-center my-2 border-casa-black">

                    <div class="flex items-center">
                        <svg fill="#fff" class="size-6 ">
                            <use xlink:href="#lupa"></use>
                        </svg>

                    </div>



                    <input type="search" name="searchParam"
                        class="w-full mx-3 focus:outline-0 placeholder:text-gray-600   placeholder:text-sm"
                        wire:model.live.debounce.500ms="search" placeholder="¿Qué buscas?" />

                    <input type="hidden" name="from" value="home">

                    <button
                        class="bg-casa-black text-gray-50 rounded-full px-2 flex items-center justify-between  py-1 "
                        type="submit">


                        <svg class="size-5">
                            <use xlink:href="#arrow-right"></use>
                        </svg>
                    </button>



                </form>

            </div>









            @auth

                <form method="POST" action="{{ route('logout') }}" x-data class="w-full border-t border-casa-black">
                    @csrf

                    <a href="{{ route('logout') }}"
                        class="flex items-center py-1   mb-1 text-gray-200 bg-casa-black rounded-full mx-auto px-5 w-fit mt-3 text-sm"
                        @click.prevent="$root.submit();">

                        <svg fill="currentColor" class="size-6 ">
                            <use xlink:href="#exit"></use>
                        </svg>
                        Cerrar sesion
                    </a>
                </form>
            @endauth
        </div>

    </div>
</div>
