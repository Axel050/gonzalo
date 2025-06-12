<x-layouts.guest>
    <x-slot name="headerT">
        Detalles
    </x-slot>

    {{-- @livewire('admin.adquirentes.index')   --}}
    <div class="flex justify-center items-center h-lvh w-full ">
        <h1 class="text-5xl text-white mx-auto font-bold">Detalle lote {{ $id }}</h1>
    </div>
</x-layouts.guest>
