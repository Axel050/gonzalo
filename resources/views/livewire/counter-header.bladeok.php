<div class="w-full bg-casa-black flex  lg:flex-row flex-col text-white pt-4 lg:pb-8 pb-10  justify-between lg:px-24 px-4 items-center relative"
  x-data="{ open: true }">


  <div class="flex lg:flex-col flex-row lg:items-start  justify-between w-full  items-center ">

    <a href="{{ route('subasta.lotes', $last->id) }}"
      class="lg:text-[43px] lg:leading-[47px] text-[26px]  font-librecaslon mb-1 hover:font-semibold">{{ $last->titulo ?? 'Objeto' }}
    </a>

    <div class="flex lg:flex-col flex-row gap-x-2">
      <p class="lg:text-3xl text-xs font-semibold">Termina el</p>
      <p class="lg:text-3xl text-xs font-semibold">
        {{ str_replace('.', '', mb_strtoupper($fechaFin->translatedFormat('d M | H:i'))) }}
      </p>
    </div>

  </div>


  {{-- <div class="flex  items-center g-blue-200 lg:justify-end  justify-between w-full"
        x-show="open || window.innerWidth >= 1024" x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-700" x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"> --}}
  <div class="flex  items-center g-blue-200 lg:justify-end  justify-between w-full"
    x-show="open || window.innerWidth >= 1024" x-transition:enter.duration.500ms x-transition:leave.duration.400ms>

    <p class="lg:text-lg text-xs mr-6">Faltan</p>

    <div class="flex">
      <div class="flex flex-col items-center  justify-center ">
        <p id="dias" class="lg:text-[120px] text-[50px] lg:leading-[120px] leading-[50px]">00</p>
        <p class="lg:text-3xl  text-xs font-bold ">dias</p>
      </div>
      <p class="lg:text-[120px] text-[50px] lg: self-start mx-1 lg:leading-[120px] leading-[50px] animate-pulse">
        :</p>
      <div class="flex flex-col items-center justify-center">
        <p id="horas" class="lg:text-[120px] text-[50px] lg:leading-[120px] leading-[50px]">00</p>
        <p class="lg:text-3xl  text-xs font-bold">horas</p>
      </div>
      <p class="lg:text-[120px] text-[50px] lg: self-start mx-1 lg:leading-[120px] leading-[50px] animate-pulse">
        :</p>
      <div class="flex flex-col items-center justify-center">
        <p id="minutos" class="lg:text-[120px] text-[50px] lg:leading-[120px]  leading-[50px]">00</p>
        <p class="lg:text-3xl  text-xs font-bold">minutos</p>
      </div>
    </div>

  </div>

  <button class="text-white absolute lg:hidden bottom-3 left-1/2  py-2" @click="open = ! open">

    <svg fill="#fff" class="w-4 h-2.5" :class="{ 'rotate-180 ': !open }">
      <use xlink:href="#arrow-up"></use>
    </svg>
  </button>
</div>


<script>
  console.log("cccoooooo")
  // Fecha de fin desde PHP hacia JS
  const fechaFin = new Date("{{ $fechaFin->format('Y-m-d H:i:s') }}");

  function actualizarContador() {
    const ahora = new Date();
    let diferencia = fechaFin - ahora;

    if (diferencia <= 0) {
      document.getElementById("dias").innerText = "00";
      document.getElementById("horas").innerText = "00";
      document.getElementById("minutos").innerText = "00";
      return;
    }

    const dias = Math.floor(diferencia / (1000 * 60 * 60 * 24));
    diferencia -= dias * (1000 * 60 * 60 * 24);

    const horas = Math.floor(diferencia / (1000 * 60 * 60));
    diferencia -= horas * (1000 * 60 * 60);

    const minutos = Math.floor(diferencia / (1000 * 60)) + 1;

    document.getElementById("dias").innerText = String(dias).padStart(2, '0');
    document.getElementById("horas").innerText = String(horas).padStart(2, '0');
    document.getElementById("minutos").innerText = String(minutos).padStart(2, '0');
  }

  // Ejecutar la función cada segundo, sincronizada
  setInterval(actualizarContador, 1000);
  actualizarContador(); // Primera ejecución inmediata
</script>