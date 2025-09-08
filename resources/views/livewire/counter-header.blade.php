<div class="w-full bg-casa-black flex  text-white pt-4 pb-8  justify-between px-20 items-center">


    <div class="flex flex-col ">
        <p class="text-[43px] leading-[47px] font-librecaslon mb-1">{{ $last->titulo ?? 'Objeto' }}</p>
        <p class="text-3xl font-semibold">Termina el</p>
        <p class="text-3xl font-semibold">
            {{ str_replace('.', '', mb_strtoupper($fechaFin->translatedFormat('d M | H:i'))) }}hs</p>
    </div>


    <div class="flex items-center">
        <p class="text-lg mr-6">Faltan</p>
        <div class="flex flex-col items-center justify-center ">
            <p id="dias" class="text-[120px] leading-[120px]">00</p>
            <p class="text-3xl font-bold ">dias</p>
        </div>
        <p class="text-[120px]  self-start mx-1 leading-[120px] animate-pulse"> :</p>
        <div class="flex flex-col items-center justify-center">
            <p id="horas" class="text-[120px] leading-[120px]">00</p>
            <p class="text-3xl font-bold">horas</p>
        </div>
        <p class="text-[120px]  self-start mx-1 leading-[120px] animate-pulse"> :</p>
        <div class="flex flex-col items-center justify-center">
            <p id="minutos" class="text-[120px] leading-[120px]">00</p>
            <p class="text-3xl font-bold">minutos</p>
        </div>
    </div>
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
