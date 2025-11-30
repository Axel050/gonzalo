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
            id: Date.now(),
            mensaje1: `Tu puja fue superada en el lote ${$event.detail.loteId} `,
            mensaje2: `Nuevo monto: ${$event.detail.signo}<strong style='margin-left:3px'>${formatMonto($event.detail.monto)}</strong>`
        });
        setTimeout(() => notificaciones.shift(), 10000);
    "
    {{-- <div x-data="{ notificaciones: [] }"
    x-on:nueva-puja.window="
        notificaciones.push({
            id: Date.now(),
            mensaje1: `Tu puja fue superada en el lote ${$event.detail.loteId} `,
            mensaje2: `Nuevo monto: ${$event.detail.signo}${$event.detail.monto}`
        });
        setTimeout(() => notificaciones.shift(), 10000);
    " --}} class="fixed lg:top-35 top-25 right-0 space-y-3 !z-100">
    <template x-for="(notif, index) in notificaciones" :key="notif.id">
        <div x-data="{ shown: true }" x-init="() => {
            $el.classList.remove('progress-active');
            void $el.offsetWidth; // Forzar reflow
            $el.classList.add('progress-active'); // Inicia animación
        }" x-transition x-show="shown"
            class="
                relative
                overflow-hidden
                bg-red-500 text-white  pr-2 py-1  rounded-md rounded-r-none shadow-lg flex items-center justify-between md:gap-4 gap-2
                border-l-4 border-red-600 z-50
                
                before:content-['']
                before:absolute before:bottom-0 before:left-0 before:h-1 before:bg-red-600
                before:w-0 before:transition-all before:duration-[10000ms] before:ease-linear
                
                after:content-['']
                after:absolute after:top-0 after:left-0 after:h-1 after:bg-red-600
                after:w-0 after:transition-all after:duration-[10000ms] after:ease-linear
                
                [&.progress-active]:before:w-full
                [&.progress-active]:after:w-full
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
