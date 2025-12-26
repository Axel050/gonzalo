<div
    class=" bg-casa-base-2/70 px-4 md:px-24 wfull max-w-8xl swiper-destacados-pujas  g-green-200 md:w-full w-[90vw] overflow-hidden">

    {{-- 
    <h2 class="lg:text-[40px] text-[26px] font-librecaslon w-full  lg:text-center text-start mb-1">
        Lotes destacados
    </h2> --}}
    {{-- <div
        class="max-w-8xl swiper-destacados-pujas  g-green-200 md:w-full w-[90vw] overflow-hidden   shadow pr-1 pb-1 bg-red-300"> --}}


    <x-fancy-heading text="l{o}te{s} d{e}st{a}ca{d}os" variant="italic mr-[1px] font-medium"
        class=" md:text-[40px] text-[26px]  text-center text-wrap font-medium mb-4" />


    <div class="swiper-wrapper bg-re  p-1   ">

        @foreach ($destacados as $des)
            <a href="{{ route('lotes.show', $des['id']) }}"
                class=" bg-casa-base flex  p-2 lg:p-4   lg: border border-casa-black swiper-slide">
                <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $des['foto']) }}"
                    class=" w-full sze-36 mx-auto" />
            </a>
        @endforeach


    </div>
    {{-- </div> --}}

</div>
