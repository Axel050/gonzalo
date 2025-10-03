<div
    class="swiper-destacados-pujas  g-green-200 w-ful w-[90vw] overflow-hidden  lg:mt-14 mt-10  shadow p-2 pr-4 pb-4 bg-casa-base-2">


    <h2 class="lg:text-[40px] text-[26px] font-librecaslon w-full  lg:text-center text-start mb-1">
        Lotes destacados
    </h2>


    <div class="swiper-wrapper g-red-200  p-1   ">

        @foreach ($destacados as $des)
            <a href="{{ route('lotes.show', $des['id']) }}"
                class=" bg-casa-base flex  p-2 lg:p-4   lg: border border-casa-black swiper-slide">
                <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $des['foto']) }}"
                    class=" w-full sze-36 mx-auto" />
            </a>
        @endforeach


    </div>

</div>
