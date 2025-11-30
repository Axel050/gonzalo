<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    {{-- <link href="{{ asset('assets/css/testview.css') }}" rel="stylesheet"> --}}
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Styles -->
    @livewireStyles

    <style>
        .swiper-destacados .swiper-wrapper {
            /* overflow: hidden; */

            /* background-color: blue; */

        }

        .swiper-subastas .swiper-slide {
            /* background-color: gray; */
            width: fit-content;
        }



        .swiper-home-subastas .swiper-wrapper {
            /* background-color: yellow; */
            /* width: fit-content; */

            /* margin: 0; */
            /* padding: 0; */
        }

        .swiper-home-subastas .swiper-slide {
            height: auto;
        }

        .swiper-home-subastas .swiper-slide:last-child {
            margin-right: 0px !important;
        }
    </style>

</head>

<body class="font-sans antialiased bg-base text-casa-black">
    @include('sprite-front')


    <div class="flex flex-col bg-casa-base  " x-data="{ openSide: true }" x-cloak>




        <nav x-data="{ scrolled: false }" @scroll.window="scrolled = window.pageYOffset > 50"
            :class="{ 'opacity-20 ': scrolled, 'bg-transparent': !scrolled }"
            class=" sticky top-0 z-50  flex  w-full -200 justify-between py-4 lg:px-24 px-4  text-gray-800  border-b  border-gray-700 shadow-lg lg:h-20 lg:h30  h16 h-11 items-center hover:bg-casa-base   transition-all duration-1000 ease-in-out hover:opacity-100 ">






            <div class="lg:flex hidden">

                <div class="flex  gap-4 text-gray-300 ">

                    <a href="" class="over:scale-105">
                        <svg fill="#fff" class="size-8 ">
                            <use xlink:href="#instagram"></use>
                        </svg>
                    </a>

                    <a href="" class="over:scale-105">
                        <svg fill="#fff" class="size-8 ">
                            <use xlink:href="#what"></use>
                        </svg>
                    </a>

                    <a href="" class="over:scale-105">
                        <svg fill="#fff" class="size-8 ">
                            <use xlink:href="#mail"></use>
                        </svg>
                    </a>

                </div>


                <a href="{{ route('subastas') }}"
                    class="over:scale-105 hover:bg-casa-fondo-h text-sm border rounded-full px-4 py-2 border-black text-black ml-8 mr-4 h-fit ">
                    Subastas
                </a>

                @guest
                    <a href="{{ route('adquirentes.create') }}"
                        class="over:scale-105 hover:bg-casa-fondo-h text-sm border rounded-full px-4 py-2 border-black text-black h-fit">
                        ¿Primera vez?
                    </a>
                @endguest


            </div>





            <a href="{{ route('home') }}" class=" over:scale-105">
                <svg fill="#fff" class="w-59  h-7  lg:flex hidden">
                    <use xlink:href="#casa-icon"></use>
                </svg>

                <svg fill="#fff" class="w-28  h-5  lg:hidden flex">
                    <use xlink:href="#casa-icon-mb"></use>
                </svg>
            </a>


            <div class="lg:flex hidden">

                @guest
                    <a href="{{ route('comitentes.create') }}"
                        class="over:scale-105 hover:bg-casa-fondo-h text-sm border rounded-full px-4 py-2 border-black mr-8 text-black  h-fit lg:flex hidden">
                        ¿Tenés algo para vender?
                    </a>
                @endguest




                @auth





                    <div class="flex justify-end ml-auto mr-4  text-black  z-50 cursor-pointer">

                        <x-dropdownlogfront />
                    </div>

                    @role('adquirente')
                        @if (!request()->routeIs('pantalla-pujas'))
                            <a href="{{ route('pantalla-pujas') }}"
                                class=" px-2   hover:scale-105  pt-0.5 flex  items-center rounded-3xl border border-casa-black"
                                title="Pantalla pujas">
                                <svg fill="#000" class="size-7">
                                    <use xlink:href="#cart"></use>
                                </svg>
                                <span class="pr-0.5">
                                    Pujas
                                </span>
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



            <div class="lg:hidden flex">
                @role('adquirente')
                    @if (!request()->routeIs('pantalla-pujas'))
                        <a href="{{ route('pantalla-pujas') }}"
                            class=" px-2   mr-3 flex items-center rounded-3xl border border-casa-black  h-7"
                            title="Pantalla pujas">
                            <svg fill="#fff" class="size-7">
                                <use xlink:href="#cart"></use>
                            </svg>
                            <span clas="text-xs">Pujas</span>
                        </a>
                    @endif
                @endrole

                <x-dropdownlogfront-mb />

            </div>

            {{-- </div> --}}

        </nav>

        <!-- Page Content -->

        @livewire('counter-header')

        {{-- <main class=" bg-gray-900  px-4 lg:px-6  "> --}}
        {{-- bg-[repeating-linear-gradient(45deg,currentColor_0,currentColor_1px,transparent_1px,transparent_5px)] --}}
        {{-- <main class="   bgred-500 h-[calc(100dvh-48px)]" style="min-height: calc(100dvh - 48px); "> --}}
        {{-- <main class="   bgred-500 h-dvh" style="min-height: calc(100dvh - 48px); "> --}}
        <main class="    -dvh ">
            {{ $slot }}
        </main>

        @livewire('notificaciones')


        {{-- </div> --}}

        {{-- Route::get('/adquirentes/crear', [AdquirenteController::class, "create"])->name('adquirentes.create'); --}}
        @if (!request()->routeIs('adquirentes.create', 'comitentes.create'))
            <x-footer />
        @endif

    </div>

    @livewireScripts



    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    {{-- <script src="resources/js/echo.js'"></script> --}}

    @stack('captcha')
    @stack('timer')
</body>

</html>
