<x-layouts.guest>
    <x-slot name="headerT">
        Detalles
    </x-slot>

    {{-- @livewire('admin.adquirentes.index')   --}}
    <div class="flex flex-col justify-center items-center h-lvh w-full ">
        <h1 class="text-5xl text-white mx-auto font-bold">Detalle lote {{ $id }}</h1>



        @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia(9))
            <button
                class="bg-green-500 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-700">Pujar</button>
        @else
            <button
                class="bg-green-300 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-500">No
                habilitado para pujar</button>
        @endif

        {{-- @if (auth()->user()?->adquirente?->garantia(9))
            <button
                class="bg-green-300 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-500">
                Pujar G</button>
        @endif --}}


    </div>


</x-layouts.guest>
