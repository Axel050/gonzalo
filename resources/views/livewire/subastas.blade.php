<div class="flex flex-col justify-center items-center hvh w-full  pt-0  md:gap-y-24 gap-y-16  ">

    <div class="mt-10   w-full [&>article]:max-w-5xl">
        @livewire('buscador', ['todas' => true, 'from' => 'subastas'])
    </div>

    {{-- @role('adquirente') --}}
    {{-- @if (auth()->user())
        @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia($subasta->id) || !auth()->user()?->hasRole('adquirente')) --}}

    {{-- <div class="flex flex-col  px-4 mt-10 gap-8  w-full max-w-7xl"> --}}






    @if (count($subastas))
        <section class="w-full md:max-w-7xl gap-4 flex flex-col">

            <x-fancy-heading text="s{u}bast{a}s a{b}iert{a}s" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[32px] text-[20px]  text-center text-wrap font-normal " />

            @foreach ($subastas as $item)
                <x-subastas.card-all :subasta="$item['subasta']" tipo="abierta" :lotes="$item['lotes']" :route="route('subasta.lotes', $item['subasta']['id'])" />
            @endforeach

        </section>
    @endif


    @if (count($subastasProx))

        <section class="w-full md:max-w-7xl  gap-4 flex flex-col md:scroll-mt-30 scroll-mt-20" id="proximas">


            <x-fancy-heading text="s{u}bast{a}s p{r}óxi{m}as" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[32px] text-[20px]  text-center text-wrap font-normal " />


            @foreach ($subastasProx as $subP)
                <x-subastas.card-all :subasta="$subP['subasta']" tipo="proxima" :lotes="$subP['lotes']" :route="route('subasta-proximas.lotes', $subP['subasta']['id'])" />
            @endforeach
        </section>
    @endif


    @if (count($subastasFin))
        <section class="w-full md:max-w-7xl  gap-4 flex flex-col md:scroll-mt-30 scroll-mt-20" id="pasadas">

            <x-fancy-heading text="s{u}bast{a}s p{a}sa{d}as" variant="italic mx-[0.5px] font-normal"
                class=" md:text-[32px] text-[20px]  text-center text-wrap font-normal " />


            @foreach ($subastasFin as $subF)
                <x-subastas.card-all :subasta="$subF['subasta']" tipo="pasada" :lotes="$subF['lotes']" :route="route('subasta-pasadas.lotes', $subF['subasta']['id'])" />
            @endforeach
        </section>
    @endif









</div>
