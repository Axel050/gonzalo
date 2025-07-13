<div>

    <h1 class="text-white font-bold text-xl">Lotes</h1>

    <hr>
    {{-- {{ $test }} --}}
    <hr><br>


    <div class="grid grid-cols-3 gap-7">
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


    </div>


</div>
