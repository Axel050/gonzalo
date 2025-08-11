<div>

    <h1 class="text-white font-bold text-xl">Lotes</h1>
    <button class="bg-blue-600 text-white px-2 my-2 ml-60 rounded-2xl  text-center" wire:click="mp">MP</button>
    <button class="bg-red-600 text-white px-2 my-2 ml-60 rounded-2xl  text-center" wire:click="crearDevolucion(21)">MP -
        REFOUND</button>

    <hr>
    {{-- <button class="bg-white rounded text-red-700 px-5 py-0 ml-40 mr-30 " wire:click="activar">Cheack Activar</button>
    <button class="bg-white rounded text-red-700 px-5 py-0 mx-auto " wire:click="job">Cheack Desactivar</button>
    <hr><br> --}}


    <div class="grid grid-cols-3 gap-7 pb-8 mt-2">
        @if (isset($lotes) && count($lotes))

            @foreach ($lotes as $lote)
                <article class="flex flex-col bg-cyan-950 rounded-2xl p-3">

                    <a href="{{ route('lotes.show', $lote['id']) }}">
                        <h2 class="text-gray-100 text-lg mb-1">{{ $lote['titulo'] }}</h2>

                        <img class="max-h-48" src="{{ Storage::url('imagenes/lotes/normal/' . $lote['foto']) }}" />
                        </figure>
                        <p class="text-gray-200 mt-1">{{ $lote['precio_base'] }}</p>
                        <p class="text-gray-200 mt-1">Lote: {{ $lote['id'] }}</p>

                    </a>
                </article>
            @endforeach
        @endif


    </div>


</div>
