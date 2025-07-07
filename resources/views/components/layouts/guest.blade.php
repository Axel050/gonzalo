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
        /* @view-transition {
            navigation: auto;
        }

        ::view-transition-group(*) {
            animation-duration: 0.5s;
        }


        #img1,
        #img2 {
            view-transition-name: poster;
        } */

        /* ::view-transition-old(imagen-destacada) {
            animation: slide-out 0.5s ease-in;
        }

        ::view-transition-new(imagen-destacada) {
            animation: slide-in 0.5s ease-out;
        } */

        /* Animación: sale hacia la izquierda, entra desde la derecha */
        @keyframes slide-out {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(-100%);
                opacity: 0;
            }
        }

        @keyframes slide-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }



        /* Define una transición para un elemento con view-transition-name */
        /* ::view-transition-old(root) {
            animation: fade-out 0.5s ease-in;
        }

        ::view-transition-new(root) {
            animation: fade-in 0.5s ease-out;
        } */

        @keyframes fade-out {

            /* opacity: 1; */
            /* transform: translateX(0); */
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(-100%);
                opacity: 0;
            }

        }

        @keyframes fade-in {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
    </style>

</head>

<body class="font-sans antialiased ">
    @include('sprite')


    <x-banner />


    <div class="flex bg-gradient-to-br from-sky-900 via-gray-900 to-sky-950  " x-data="{ openSide: true }" x-cloak>


        <div class="transition-all duration-500  overflow-y-auto w-full   ">


            <nav
                class="h-12 sticky top-0 z-50  flex  w-full -200 justify-between py-2 bg-gradient-to-br from-sky-900 via-gray-900 to-sky-950 ">
                {{-- <div
                    class="  w-full h-12  z-10 justify-center flex flex-row items-center border-b-2 border-ky-900 b-sky-950 bg-linear-to-r from-cyan-800 to-cyan-950 border border-green-300"> --}}


                <a href="{{ route('home') }}"
                    class="px-3 py-1 rounded-2xl bg-cyan-700 text-white  ml-2 lg:text-base text-xs  ">Home</a>




                <div class="flex gap-4 text-gray-300">

                    <a href="{{ route('adquirentes.create') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-cyan-800">
                        Adquirentes
                    </a>
                    <a href="{{ route('comitentes.create') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-cyan-800">
                        Comitentes
                    </a>
                    <a href="{{ route('subasta.lotes', 9) }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal bg-cyan-800">
                        Subasta 9
                    </a>

                </div>
                <div class="flex">
                    @auth


                        {{-- @role(['super-admin', 'admin']) --}}
                        {{-- @role('adquirente') --}}
                        @unlessrole('adquirente')
                            <a href="{{ url('/dashboard') }}"
                                class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border txt-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal mr-8 bg-cyan-800 text-gray-300">
                                Dashboard
                            </a>
                            {{-- @endrole --}}
                        @endunlessrole

                        <div
                            class="flex justify-end ml-auto mr-4 bg-cya-800 text-white rounded-lg bg-linear-to-l from-cyan-800 to-cyan-950 z-50">

                            <x-dropdownlog />
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-gray border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal bg-cyan-700 mr-2 text-white">
                            Log in
                        </a>

                    @endauth
                </div>


                {{-- </div> --}}

            </nav>

            <!-- Page Content -->



            {{-- <main class=" bg-gray-900  px-4 lg:px-6  "> --}}
            {{-- bg-[repeating-linear-gradient(45deg,currentColor_0,currentColor_1px,transparent_1px,transparent_5px)] --}}
            <main class="  px-4 lg:px-6  bgred-500 h-[calc(100dvh-48px)]" style="min-height: calc(100dvh - 48px);">
                {{ $slot }}
            </main>

        </div>

    </div>
    </div>

    @livewireScripts



    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    @stack('captcha')
</body>

</html>
