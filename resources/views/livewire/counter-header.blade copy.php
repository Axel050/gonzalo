<div class="w-full bg-casa-black flex lg:flex-row flex-col text-white pt-2 lg:pb-4 pb-5 justify-between lg:px-24 px-4  items-center relative "
    x-data="{ open: true }">
    {{-- class="w-full bg-casa-black flex lg:flex-row flex-col text-white pt-4 lg:pb-8 pb-10 justify-between lg:px-24 px-4 items-center relative"> --}}

    <div class="max-w-8xl  flex lg:flex-row flex-col  justify-between  w-full  mx-auto">


        <!-- Parte que SÍ debe actualizarse al navegar (título, fecha, botón móvil) -->
        <div class="flex lg:flex-col flex-row lg:items-start justify-between w-full items-center bg--500">
            <a href="{{ route('subasta.lotes', $last->id) }}"
                class="lg:text-[43px] lg:leading-[47px] text-[26px] leading-[25px]  lg:mb-1 mb-0 hover:font-semibold font-caslon italic">
                {{ $last->titulo ?? 'Subasta' }}
            </a>

            <div class="flex lg:flex-col flex-row gap-x-2">
                {{-- <p class="lg:text-3xl text-xs font-semibold">Termina el</p> --}}
                <p class="lg:text-2xl text-xs font-semibold">Termina el</p>
                <p class="lg:text-2xl text-xs font-semibold">
                    {{ $fechaFin?->translatedFormat('d M | H:i') }}
                </p>
            </div>
        </div>


        {{-- <div class="flex  items-center g-blue-200 lg:justify-end  justify-between w-full"
        x-show="open || window.innerWidth >= 1024" x-transition:enter.duration.500ms x-transition:leave.duration.400ms> --}}



        <!-- SOLO ESTA PARTE lleva wire:ignore → el contador numérico -->
        <div class="flex items-center lg:justify-end justify-between w-full " wire:ignore x-show="open"
            x-transition:enter.duration.500ms x-transition:leave.duration.400ms>
            <p class="lg:text-lg text-xs mr-6">Faltan</p>



            {{-- 
        <div class="flex">
      <div class="flex flex-col items-center  justify-center ">
        <p id="dias" class="lg:text-[120px] text-[50px] lg:leading-[120px] leading-[50px]">00</p> --}}


            <div class="flex" data-fecha-fin="{{ $fechaFin?->format('Y-m-d H:i:s') ?? '' }}">
                <div class="flex flex-col items-center justify-center">
                    {{-- <p id="counter-dias" class="lg:text-[120px] text-[50px] lg:leading-[120px] leading-[50px]">00</p> --}}
                    <p id="counter-dias" class="lg:text-[80px] text-[35px] lg:leading-[80px] leading-[35px]">00</p>
                    <p class="lg:text-2xl text-xs font-bold">dias</p>
                </div>
                {{-- <p class="lg:text-[120px] text-[50px] self-start mx-1 animate-pulse">:</p> --}}
                {{-- <p class="lg:text-[120px] text-[50px] lg: self-start mx-1 lg:leading-[120px] leading-[50px] animate-pulse"> --}}
                <p
                    class="lg:text-[80px] text-[35px] lg: self-start mx-1 lg:leading-[80px] leading-[35px] animate-pulse">
                    :</p>
                <div class="flex flex-col items-center">
                    {{-- <p id="counter-horas" class="lg:text-[120px] text-[50px] lg:leading-[120px] leading-[50px]">00</p> --}}
                    <p id="counter-horas" class="lg:text-[80px] text-[35px] lg:leading-[80px] leading-[35px]">00</p>
                    <p class="lg:text-2xl text-xs font-bold">horas</p>
                </div>
                {{-- <p class="lg:text-[120px] text-[50px] self-start mx-1 animate-pulse">:</p> --}}
                {{-- <p class="lg:text-[120px] text-[50px] lg: self-start mx-1 lg:leading-[120px] leading-[50px] animate-pulse"> --}}
                <p
                    class="lg:text-[80px] text-[35px] lg: self-start mx-1 lg:leading-[80px] leading-[35px] animate-pulse">
                    :</p>
                <div class="flex flex-col items-center">
                    {{-- <p id="counter-minutos" class="lg:text-[120px] text-[50px] lg:leading-[120px] leading-[50px]">00</p> --}}
                    <p id="counter-minutos" class="lg:text-[80px] text-[35px] lg:leading-[80px] leading-[35px]">00</p>
                    <p class="lg:text-2xl text-xs font-bold">minutos</p>
                </div>
            </div>
        </div>


        <!-- Botón móvil (fuera de wire:ignore para que funcione el x-data open) -->
        <button class="text-white absolute lg:hidden bottom-0 left-1/2 py-2" @click="open = !open">
            <svg fill="#fff" class="w-4 h-2.5 transition-transform" :class="{ 'rotate-180': !open }">
                <use xlink:href="#arrow-up"></use>
            </svg>
        </button>
    </div>
</div>

@once
    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            window.startCounter = function() {
                if (window.counterInterval) clearInterval(window.counterInterval);

                const container = document.querySelector('[wire\\:ignore] [data-fecha-fin]');
                if (!container) return;

                const fechaFin = new Date(container.dataset.fechaFin);
                if (isNaN(fechaFin)) return;

                const update = () => {
                    const diff = (fechaFin - new Date()) / 1000;
                    if (diff <= 0) {
                        ['dias', 'horas', 'minutos'].forEach(u => {
                            const el = document.getElementById('counter-' + u);
                            if (el) el.textContent = '00';
                        });
                        clearInterval(window.counterInterval);
                        return;
                    }

                    const dias = Math.floor(diff / 86400);
                    const horas = Math.floor((diff % 86400) / 3600);
                    const minutos = Math.ceil((diff % 3600) / 60);

                    document.getElementById('counter-dias').textContent = String(dias).padStart(2, '0');
                    document.getElementById('counter-horas').textContent = String(horas).padStart(2, '0');
                    document.getElementById('counter-minutos').textContent = String(minutos).padStart(2,
                        '0');
                };

                update();
                window.counterInterval = setInterval(update, 1000);
            };

            window.startCounter();
            document.addEventListener('livewire:navigated', window.startCounter);
        });
    </script>
@endonce
