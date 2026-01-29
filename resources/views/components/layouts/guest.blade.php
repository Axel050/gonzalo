<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('img/fav.jpg') }}">

    <meta name="description"
        content="Subastas online, subastamos todo tipo de objetos. El mejor sitio de subastas online.">
    <meta name="keywords" content="Subastas. Subastas online. Vender. Remates. ">
    <meta name="url" content="https://casablanca.ar/">
    <meta name="category" content="Subastas online">
    <meta name='robots' content='index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1' />
    <meta name="revisit" content="14 days">
    <link rel="canonical" href="https://casablanca.ar/">
    <meta property="og:locale" content="es_ES" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Casablanca.ar - Subastas online" />
    <meta property="og:description"
        content="Subastas online, subastamos todo tipo de objetos. El mejor sitio de subastas online." />
    <meta property="og:url" content="https://casablanca.ar/" />
    <meta property="og:site_name" content="Subastas online | El mejor sitio mde subastas | Casablanca.ar" />

    <meta property="og:image" content="{{ asset('img/ogsmall.jpg') }}">


    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- <link href="{{ asset('assets/css/testview.css') }}" rel="stylesheet"> --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Styles -->
    @livewireStyles

    <style>
        .swiper-home-subastas .swiper-slide {
            height: auto;
        }
    </style>

</head>

<body class="font-sans antialiased bg-base text-casa-black bg-casa-base">
    @include('sprite-front')


    <div class="flex flex-col bg-casa-base  " x-data="{ openSide: true }" x-cloak>





        <nav {{-- x-data="{ scrolled: false }" @scroll.window="scrolled = window.pageYOffset > 50" :class="{ 'opacity-5 ': scrolled, 'bg-transparent': !scrolled }" --}}
            class=" sticky top-0 z-50  flex  w-full -200  py-4    text-gray-800  -gray-700 shadw-lg lg:h-20 lg:h30  h16 h-11 items-center hover   bg-casa-base   transition-all duration-1000 ease-in-out hover:opacity-100   mx-auto md:px-16 xl:px-24 px-4  border-b border-casa-black ">


            <div class="max-w-8xl  md:grid md:grid-cols-5 flex   w-full justify-between items-center  mx-auto">





                <div class="lg:flex hidden   lg:col-span-2 ">

                    <div class="hidden xl:flex  xl:gap-2 text-casa-base mr-4">

                        <a href="https://www.instagram.com/casablanca.ar.subastasonline/" target="_blank">
                            <svg fill="#fff" class="size-8 ">
                                <use xlink:href="#instagram"></use>
                            </svg>
                        </a>

                        <a href="https://wa.me/+541130220449" target="_blank">
                            <svg fill="#fff" class="size-8 ">
                                <use xlink:href="#what"></use>
                            </svg>
                        </a>

                        <a href="mailto:info@casablanca.ar">
                            <svg fill="#fff" class="size-8 ">
                                <use xlink:href="#mail"></use>
                            </svg>
                        </a>

                        <a href="https://www.facebook.com/profile.php?id=61586654246260&rdid=VB7wE43ebenqdLPn&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1AVDgpgN6W%2F#"
                            target="_blank">
                            <svg fill="#fff" class="size-8 ">
                                <use xlink:href="#face"></use>
                            </svg>
                        </a>

                    </div>


                    <a href="{{ route('subastas') }}"
                        class="over:scale-105 bg-casa-black hover:bg-casa-fondo-h text-sm border rounded-full  xl:px-4 px-2 py-2 border-black hover:text-casa-black  mr-3 h-fit text-casa-base">
                        Subastas
                    </a>

                    @guest
                        <a href="{{ route('adquirentes.create') }}"
                            class="over:scale-105 hover:bg-casa-fondo-h text-sm border rounded-full px-4 py-2 border-black text-black h-fit">
                            ¿Primera vez?
                        </a>
                    @else
                        <a href="{{ route('terminos-comitentes') }}"
                            class=" hover:bg-casa-fondo-h text-sm border rounded-full px-4  py-2 border-black xl:mr-2 md:mr-1 text-black  h-fit lg:flex hidden ">
                            ¿Tenés algo para vender?
                        </a>

                    @endguest


                </div>





                <a href="{{ route('home') }}">
                    <svg fill="#fff" class="lg:w-59  h-7  lg:flex hidden mx-auto">
                        <use xlink:href="#casa-icon"></use>
                    </svg>

                    <svg fill="#fff" class="w-28  h-5  lg:hidden flex">
                        <use xlink:href="#casa-icon-mb"></use>
                    </svg>
                </a>


                <div class="lg:flex hidden justify-end lg:col-span-2 ">

                    @guest
                        <a href="{{ route('terminos-comitentes') }}"
                            class="over:scale-105 hover:bg-casa-fondo-h text-sm border rounded-full xl:px-4 md:px-1 py-2 border-black xl:mr-8 md:mr-1 text-black  h-fit lg:flex hidden ">
                            ¿Tenés algo para vender?
                        </a>
                    @endguest




                    @auth





                        <div class="flex justify-end ml-uto mr-4 md:mr-0  text-black  z-50 cursor-pointer">

                            <x-dropdownlogfront />
                        </div>

                        @role('adquirente')
                            @if (!request()->routeIs('pantalla-pujas'))
                                <a href="{{ route('pantalla-pujas') }}"
                                    class=" px-2   hover:scale-105  pt-0.5 flex  items-center rounded-3xl border border-casa-black text-sm ml-3"
                                    title="Pantalla pujas">
                                    <x-hammer-icon />
                                    <span class="pr-0.5 ">
                                        Pujas
                                    </span>
                                </a>
                            @endif


                            @if (!request()->routeIs('carrito'))
                                <a href="{{ route('carrito') }}"
                                    class=" px-1.5   hover:scale-105  pt-0.5 flex  items-center rounded-3xl border border-casa-black text-sm ml-3 bg-casa-black text-casa-base"
                                    title="Carrito">
                                    <svg class="size-7">
                                        <use xlink:href="#cart"></use>
                                    </svg>
                                </a>
                            @endif
                        @endrole
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block px-3 py-2  text-white  rounded-full text-sm bg-casa-black hover:scale-105">
                            Log in
                        </a>

                    @endauth
                </div>



                <div class="lg:hidden flex   justify-end">
                    @role('adquirente')
                        @if (!request()->routeIs('pantalla-pujas'))
                            <a href="{{ route('pantalla-pujas') }}"
                                class=" pl-2 pr-1   mr-3 flex items-center rounded-3xl border border-casa-black  h-7"
                                title="Pantalla pujas">
                                {{-- <svg fill="#fff" class="size-7">
                                <use xlink:href="#cart"></use>  
                            </svg> --}}
                                <x-hammer-icon />
                                {{-- <span clas="text-xs">Pujas</span> --}}
                            </a>
                        @endif

                        @if (!request()->routeIs('carrito'))
                            <a href="{{ route('carrito') }}"
                                class=" px-2    mr-3 flex items-center rounded-3xl border border-casa-black  h-7 bg-casa-black text-casa-base"
                                title="Carrito">
                                <svg class="size-7">
                                    <use xlink:href="#cart"></use>
                                </svg>

                            </a>
                        @endif


                    @endrole

                    <x-dropdownlogfront-mb />

                </div>

            </div>

        </nav>








        <!-- Page Content -->

        @livewire('counter-header')

        {{-- 
        @if (!request()->routeIs('subastas', 'adquirentes.create', 'comitentes.create'))
            <div class="fixed right-2 md:right-5 bottom-5 md:bottom-7 z-40 flex items-center flex-col group">
      
      
                <a href="{{ route('subastas') }}" 
                    class="bg-rd-500 border md:border-2 border-casa-black rounded-4xl md:px-4 md:text-xl px-2 py-1 md:py-1.5  bg-casa-base hover:bg-casa-base-2 "
                    title="Ir a subastas">Subastas</a>
            </div>
        @endif --}}


        <main class="relative ">
            {{ $slot }}
        </main>


        @livewire('notificaciones')


        {{-- </div> --}}


        @if (!request()->routeIs('adquirentes.create', 'comitentes.create'))
            <x-footer />
        @endif

    </div>

    @livewireScripts



    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    @stack('captcha')
    @stack('timer')
</body>

</html>
