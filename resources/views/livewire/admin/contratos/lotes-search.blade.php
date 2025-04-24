<div wire:key="lotes-search">


    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-accent">
        <input type="search" wire:model.live="search" class="w-full p-2 border rounded" placeholder="Buscar lotes..." />

        @if ($si)
            <ul
                class="absolute z-10 w-full bg-white border border-gray-300 rounded mt-2 max-h-60 overflow-y-auto shadow-lg">
                @foreach ($lotes as $lote)
                    <li class="p-2 hover:bg-gray-100 cursor-pointer" wire:click="loteSelected({{ $lote->id }})">
                        {{ $lote->titulo }}
                    </li>
                @endforeach
            </ul>
        @endif



    </div>

</div>
