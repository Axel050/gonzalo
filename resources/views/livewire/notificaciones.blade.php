<div x-data="{
    notificaciones: [],
    formatMonto(monto) {
        return new Intl.NumberFormat('es-ES', {
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(monto);
    }
}"
    x-on:nueva-puja.window="
    notificaciones.push({
        id: Date.now(), // Usamos Date.now() como ID único
        loteId: $event.detail.loteId, // Agregamos loteId para identificación
        mensaje1: `Tu puja fue superada en el lote ${$event.detail.loteId} `,
        mensaje2: `Nuevo monto: ${$event.detail.signo}<strong style='margin-left:3px'>${formatMonto($event.detail.monto)}</strong>`
    });
    // LÍNEA DE TIMEOUT ELIMINADA: setTimeout(() => notificaciones.shift(), 10000);
"
    x-on:puja-exitosa.window="
    // Filtrar y eliminar la notificación del lote pujado
    notificaciones = notificaciones.filter(notif => notif.loteId != $event.detail.loteId);
"
    class="fixed lg:top-35 top-25 right-0 space-y-3 !z-100">
    <template x-for="(notif, index) in notificaciones" :key="notif.id">
        <div x-data="{ shown: true }" x-init="() => {
            $el.classList.remove('progress-active');
            void $el.offsetWidth; // Forzar reflow
            // Eliminamos la adición de 'progress-active' ya que el temporizador visual no tiene sentido
        }" x-transition x-show="shown"
            class="
            relative
            overflow-hidden
            bg-red-500 text-white  pr-2 py-1  rounded-md rounded-r-none shadow-lg flex items-center justify-between md:gap-4 gap-2
            border-l-4 border-red-600 z-50 
           "
            role="status" aria-live="polite">
            <button @click="notificaciones.splice(index, 1)"
                class="mr-2  text-white hover:text-gray-200 focus:outline-none md:text-2xl text-lg  font-semibold  h-full px-2 border-r-2 border-red-600   hover:bg-red-600 py-1">
                ✕
            </button>

            <div class="flex flex-col py-1  justify-center">
                <span x-text="notif.mensaje1" class="lg:text-lg text-sm lg:leading-5"></span>
                <span x-html="notif.mensaje2" class="lg:text-lg text-sm  lg:leading-5"></span>
            </div>

            <a href="{{ route('pantalla-pujas') }}" class=" px-2 rounded  hover:scale-105  " title="Pantalla pujas">
                <svg fill="#fff" class="size-8">
                    <use xlink:href="#cart"></use>
                </svg>
            </a>
        </div>
    </template>
</div>
