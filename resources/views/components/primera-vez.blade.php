  <div
      class="flex flex-col bg-casa-base-2 w-full lg:items-center lg:px-24 lg:py-24 px-4 py-11   border-y-1 border-accent  text-casa-black">
      {{-- 
      <svg class="w-120 h-30 lg:block hidden ">
          <use xlink:href="#primera-vez"></use>
      </svg> --}}


      <div class="bg-oange-500 w-fit md:mx-auto ">


          <x-fancy-heading text="¿Pri{m}era v{e}z " variant="italic mx-[0.5px] font-normal text-casa-black"
              class="md:text-[64px] text-4xl md:text-center text-wrap font-normal md:-mb-6 -mb-2 !text-casa-black md:!leading-[70px] !leading-[32px]" />


          <x-fancy-heading text="e{n} un{a} sub{a}sta?" variant="italic mx-[0.5px] font-normal !text-casa-black "
              class="md:text-[64px] text-4xl text-center text-wrap font-normal text-casa-black" />
      </div>



      {{-- 
      <h3 class="lg:hidden block text-[37px]  leading-[39px] font-sans ">
          ¿Primera vez en una subasta?
      </h3> --}}

      <p class="lg:text-3xl text-lg font-bold lg:mt-7 mt-5">Así funciona: </p>

      <p class="lg:text-xl text-sm font-bold lg:mt-7 mt-6">Ingresá:</p>
      <p class="lg:text-xl text-sm  mt-1">Para poder ofertar necesitás abonar un seguro reembolsable.</p>
      <p class="lg:text-xl text-sm  ">Si no comprás, te lo devolvemos.</p>

      <p class="lg:text-xl text-sm font-bold lg:mt-7 mt-6">Ofertá: </p>
      <p class="lg:text-xl text-smtext-xl  mt-1">Si al terminar la subasta nadie más ofrece, el producto es
          tuyo.
      </p>
      <p class="lg:text-xl text-smtext-xl  ">Si alguien más ofertó al final de la subasta, ténes 2 minutos más
          para pujar.
      </p>

      <p class="lg:text-xl text-sm font-bold lg:mt-7 mt-6">No te muevas de tu casa: </p>
      <p class="lg:text-xl text-sm  mt-1">Todo es online: mirás, ofertás y pagás desde donde estés.</p>
      <p class="lg:text-xl text-sm  ">Si ganás, coordinamos la entrega con vos</p>

      <a href="{{ route('adquirentes.create') }}"
          class=" bg-casa-black rounded-4xl flex  items-center px-4 py-1 mx-auto text-casa-base mt-8 lg:text-xl text-sm font-bold  lg:w-fit w-full lg:justify-center justify-between">
          Registrarme
          <svg fill="#fff" class="size-7  ml-6 shrink-0 self-start">
              <use xlink:href="#arrow-right"></use>
          </svg>
      </a>
  </div>
  6
