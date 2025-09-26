<article
    class="g-red-500 flex idden  lg:w-5/6 w-full  lg:justify-center justify-start flex-col lg:mt-10 mt-6 mb-8 mx-auto lg:px-12 lg:py-12 px-6 py-10  bg-casa-fondo-h border border-casa-black">
    <h2 class=" font-bold lgtext-3xl  text-xl lg:text-center text-start">¿Como puedo ofertar?</h2>

    <div
        class="     lg:grid lg:grid-cols-3 grid-cols-1     w-6/6  mx-auto justify-between lg:pl-3 lg:pr-1 py-1 items-start lg:mt-5 mt-4 border-casa-black lg:text-xl text-sm gap-8 ">

        <div class="flex flex-col   lg:px-4 mb-3">
            <h3 class="font-bold lg:text-center text-start lg:mb-1 mb-0.5">Ingresá.</h3>
            <p class="text-pretty lg:text-center text-start">Para poder ofertar necesitás abonar un seguro reembolsable.
                Si no comprás,
                te lo
                devolvemos.</p>
        </div>
        <div class="flex flex-col   lg:px-4 mb-3">
            <h3 class="font-bold lg:text-center text-start lg:mb-1 mb-0.5">Ofertá.</h3>
            <p class="text-pretty lg:text-center text-start">Si al terminar la subasta nadie más ofrece, el producto es
                tuyo.
                Si alguien más ofertó al final de la subasta, tenés 2 min más para pujar.</p>
        </div>
        <div class="flex flex-col   lg:px-4">
            <h3 class="font-bold lg:text-center text-start lg:mb-1 mb-0.5">No te muevas de tu casa.</h3>
            <p class="text-pretty lg:text-center text-start">Todo es online: mirás, ofertás y pagás desde donde estés.
                Si ganás, coordinamos la entrega con vos.</p>
        </div>




    </div>


    <button
        class="bg-casa-black hover:bg-transparent hover:text-casa-black border border-casa-black text-gray-50 rounded-full px-4 flex items-center justify-between  py-1  col-span-3 mx-auto mt-5 lg:text-xl font-semibold text-sm lg:w-fit lg w-full"
        wire:click="mp">
        Quiero entrar
        <svg class="size-7 ml-5">
            <use xlink:href="#arrow-right"></use>
        </svg>
    </button>

</article>
