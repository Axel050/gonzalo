<x-layouts.guest>
    <x-slot name="headerT">
        Lotes
    </x-slot>

    @livewire('lotes-activos', ['subasta' => $subasta])

</x-layouts.guest>
