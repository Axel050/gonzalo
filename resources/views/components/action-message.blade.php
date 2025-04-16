@props([
    'on',
])




<div
    x-data="{ shown: false, timeout: null }"
    x-init="() => {
        @this.on('{{ $on }}', () => {
            clearTimeout(timeout);
            // Reinicia la animación quitando la clase y forzando reflow
            $el.classList.remove('progress-active');
            void $el.offsetWidth; // Truco para forzar reflow y que reinicie la transición CSS

            shown = true;
            $el.classList.add('progress-active'); // Añade la clase para iniciar la animación del borde

            timeout = setTimeout(() => {
                shown = false;
                // No necesitas quitar 'progress-active' aquí necesariamente,
                // se quitará la próxima vez que se muestre.
                // Opcional: $el.classList.remove('progress-active');
            }, 2000); // Duración de la visibilidad y la animación del borde
        })
    }"
    x-show="shown"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-90"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-1500"  {{-- Duración del fade out --}}
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
    style="display: none;" {{-- Alpine manejará la visibilidad --}}
    {{ $attributes->merge(['class' => '
        overflow-hidden {{-- Necesario para contener el pseudo-elemento --}}
        lg:text-base text-sm text-white font-extrabold        
        lg:pl-6 lg:pr-16 pr-6 pl-2 rounded-l-2xl py-2 border-r-6 h-12 z-50
              
        before:content-[\'\']
        before:absolute before:bottom-0 before:right-0 before:h-1 {{-- Altura del borde animado --}}
        before:w-0 {{-- Ancho inicial 0 --}}        
        before:transition-all before:duration-[2000ms] before:ease-linear {{-- Transición del ancho --}}
        
        after:content-[\'\']
        after:absolute after:top-0 after:right-0 after:h-1
        after:w-0        
        after:transition-all after:duration-[2000ms] after:ease-linear        
              
        [&.progress-active]:before:w-full {{-- Estado activo: ancho 100% --}}
        [&.progress-active]:after:w-full
        

    ']) }}
    role="status" {{-- Accesibilidad --}}
    aria-live="polite" {{-- Accesibilidad --}}
>
    {{-- El slot/contenido --}}
    {{ $slot->isEmpty() ? __('Saved.') : $slot }}

</div>