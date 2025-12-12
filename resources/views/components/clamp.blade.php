@props([
    'text',
    'class' => 'lg:text-3xl font-bold', // clases por defecto, puedes cambiarlas
    'bclass' => 'md:text-xs text-[10px]', // clases por defecto, puedes cambiarlas
    'mas' => 'absolute', // clases por defecto, puedes cambiarlas
    'menos' => 'absolute right-2 top-1/2', // clases por defecto, puedes cambiarlas
])

<div x-data="{
    expanded: false,
    truncated: false,
    checkTruncate(el) {
        this.$nextTick(() => {
            if (el) {
                // Umbral de 2px para ignorar ruido de renderizado (padding/fuente)
                const threshold = 2;
                this.truncated = el.scrollHeight > (el.offsetHeight + threshold);
                // console.log('Debug truncado:', this.truncated, '- diff:', el.scrollHeight - el.offsetHeight); // Descomenta para más pruebas
            }
        });
    },
    $watch: {
        'expanded': function(value) {
            if (!value) {
                this.$nextTick(() => this.checkTruncate(this.$refs.title));
            }
        }
    }
}" x-init="checkTruncate($refs.title)" class="relative ">
    <h2 x-ref="title" @click="expanded = !expanded" :class="expanded ? 'line-clamp-none' : 'line-clamp-1'"
        class="cursor-pointer transition-all duration-200 mr-1 {{ $class }}">
        {{ $text }}



    </h2>
    <button x-show="truncated" @click="expanded = !expanded"
        class="text-[10px] -mt-1  absolute transition-colors duration-200 {{ $bclass }}"
        :class="{
            'text-blue-600  right-1  {{ $mas }} ': !expanded,
            {{-- Estilo para "Ver más" --}} 'text-red-600     {{ $menos }} ': expanded
        
        
            {{-- Estilo para "Ver menos" --}}
        }">
        <span x-show="!expanded">Ver más</span>
        <span x-show="expanded">Ver menos</span>
    </button>
</div>
