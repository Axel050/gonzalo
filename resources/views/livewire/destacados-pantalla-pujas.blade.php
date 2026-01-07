<div class="  lg:px-24  px-4 overflow-x-hidden  w-full g-blue-300 max-w-8x pr-0.5" wire:show="contador">


    <div class="swiper-destacados-pujas   overflow-x-hidden w-full    max-w-8xl mx-auto" wire:ignore>
        <x-fancy-heading text="l{o}te{s} d{e}st{a}ca{d}os" variant="italic mr-[1px] font-medium"
            class=" md:text-[40px] text-[26px]  text-center text-wrap font-medium mb-4" />


        <div class="swiper-wrapper bgred-500  pr-0.5    ">

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
