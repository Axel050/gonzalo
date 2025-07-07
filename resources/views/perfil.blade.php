<x-layouts.guest>
    <x-slot name="headerT">
        Perfil
    </x-slot>

    {{-- @livewire('adquirentes.perfil') --}}
    <h1 class="text-5xl text-white mx-auto mt-12 text-center font-bold">Perfil adquirente logeado </h1>

    @dump($user->toArray())
    <hr>
    @dump($adquirente->toArray())

</x-layouts.guest>
