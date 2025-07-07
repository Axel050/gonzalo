<x-layouts.guest>
    <x-slot name="headerT">
        Lotes
    </x-slot>

    <h1 class="text-5xl text-white mx-auto mt-6 mb-4 text-center font-bold">Lotes </h1>
    @dump($subasta->lotes)

    <div class="grid grid-cols-3 gap-5 bg-gray-00 my-5 ">
        {{-- @for ($i = 0; $i < 10; $i++) --}}
        @foreach ($lotes as $item)
            <article class="rounded-lg bg-gray-600  text-gray-50  ">
                <a href="{{ route('lotes.show', $item->id) }}"
                    class="flex flex-col hover:bg-gray-700 px-4 py-2 rounded-lg">
                    <h2 class="text-lg font-bold mt-1 mb-2 text-center">{{ $item->titulo }} {{ $item->id }}</h2>
                    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Iusto quod quae dolore molestiae ipsa
                        voluptates qui aperiam ratione, sed eveniet, distinctio libero assumenda quo delectus ut quos,
                        fuga
                        culpa perspiciatis!
                        Incidunt, rerum sapiente distinctio earum alias quibusdam eaque quis minus? Temporibus nostrum
                        fuga
                        voluptatem ea minima, aperiam illum in facilis unde doloribus recusandae, laudantium aliquam rem
                        ipsam
                        exercitationem amet neque.

                    </p>
                </a>
            </article>
        @endforeach
        {{-- @endfor --}}


    </div>


</x-layouts.guest>
