<x-layouts.guest>
    <x-slot name="headerT">
        Perfil
    </x-slot>

    {{-- @livewire('adquirentes.perfil') --}}
    <h1 class="text-5xl text-white mx-auto mt-12 text-center font-bold">Perfil adquirente logeado </h1>

    {{-- @dump($user->toArray()) --}}
    <h2 class="text-gray-50 text-xl mt-8 font-semibold mx-auto text-center">{{ $user->name }}</h2>
    <hr>

    {{-- @dump($adquirente->toArray()) --}}

</x-layouts.guest>
