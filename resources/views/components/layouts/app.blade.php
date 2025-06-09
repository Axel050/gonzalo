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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles


</head>

<body class="font-sans antialiased ">
    @include('sprite')


    <x-banner />


    <div class="flex bg-gradient-to-br from-sky-900 via-gray-900 to-sky-950 " x-data="{ openSide: true }" x-cloak>
        <x-side-menu />

        <div class="transition-all duration-500  overflow-y-auto w-full   ">

            {{-- {{ $active ? 'bg-linear-to-r from-cyan-700 to-cyan-950 text-gray-200 font-bold' : '' }}" --}}
            <nav class=" sticky top-0 z-50  ">
                <div
                    class="  w-full h-12 sticky top-0 right-0 z-10 flex items-center border-b-2 border-sky-900 b-sky-950 bg-linear-to-r from-cyan-800 to-cyan-950 ">
                    <button @click="openSide = ! openSide"
                        class="h-6-w-6 bg-gray-200  p-1 m-2 flex justify-center items-center border border-gray-200 rounded-2xl hover:shadow shadow-sky-400 hover:cursor-pointer hover:bg-white">

                        <span :class="openSide ? 'block lg:hidden' : 'hidden lg:block'" x-cloak>
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6H20M4 12H20M4 18H20" stroke="#000000" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                        <span :class="openSide ? 'hidden  w-6 h-6 lg:block' : 'lg:hidden block  w-6 h-6 font-bold'"
                            x-cloak>X</span>

                    </button>
                    @if (isset($headerT))
                        <h1 class="lg:text-2xl text-lg lg:ml-8 ml-4  font-semibold text-gray-100">{{ $headerT }}
                        </h1>
                    @endif

                    <div
                        class="flex justify-end ml-auto mr-4 bg-cya-800 text-white rounded-lg bg-linear-to-l from-cyan-800 to-cyan-950 z-50">
                        <x-dropdownlog />
                    </div>
                </div>

            </nav>

            <!-- Page Content -->



            {{-- <main class=" bg-gray-900  px-4 lg:px-6  "> --}}
            {{-- bg-[repeating-linear-gradient(45deg,currentColor_0,currentColor_1px,transparent_1px,transparent_5px)] --}}
            <main class="  px-4 lg:px-6   " style="min-height: calc(100dvh - 48px);">
                {{ $slot }}
            </main>

        </div>

    </div>
    </div>

    @stack('modals')

    @livewireScripts
    @stack('js')

    @stack('sc')

</body>

</html>
