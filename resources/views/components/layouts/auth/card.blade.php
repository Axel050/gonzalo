<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
    @include('sprite-front')
</head>

<body class="min-h-screen bg-casa-base antialiased ">
    <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
        {{-- <x-placeholder-pattern class="absolute inset-0 size-full stroke-cyan-900/70 " /> --}}
        <div class="flex w-full max-w-md flex-col gap-6">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                {{-- <span class="flex h-9 w-9 items-center justify-center rounded-md"> --}}
                {{-- <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" /> --}}


                {{-- </span> --}}
                {{-- <span class="sr-only">{{ config('app.name', 'Laravel') }}</span> --}}
            </a>

            <div class="flex flex-col gap-6">
                {{-- <div class="rounded-xl border g-linear-to-r from-cyan-800 to-cyan-950  dark:border-stone-800 text-stone-800 shadow-xs bg-red-200"> --}}
                <div class="rounded-xl border bg-casa-black  dark:border-stone-800 text-stone-800 shadow-xs ">

                    <div class="px-10 py-8">{{ $slot }}</div>
                </div>
            </div>
        </div>
    </div>
    @fluxScripts
</body>

</html>
