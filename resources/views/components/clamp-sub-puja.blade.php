@props(['subasta_id', 'activa', 'subasta_titulo'])

<li x-data="{
    expanded: false,
    truncated: false,
    check() {
        this.$nextTick(() => {
            const el = this.$refs.title
            if (!el) return
            this.truncated = el.scrollHeight > el.clientHeight + 2
        })
    }
}" x-init="check()"
    class="md:px-3 px-2 md:py-2 py-0.5 rounded-full border border-casa-rojo
           md:text-sm text-xs text-casa-rojo font-semibold
           hover:bg-casa-rojo hover:text-casa-base
           flex-1 min-w-0 relative">


    <a href="{{ route($activa ? 'subasta.lotes' : 'subasta-pasadas.lotes', $subastaId) }}" title="Ir a subasta"
        class="flex items-center gap-1 min-w-0">
        <!-- Texto fijo -->
        <span class="whitespace-nowrap">
            Subasta:
        </span>

        <!-- Texto truncado -->
        <span x-ref="title" :class="expanded ? 'line-clamp-none' : 'line-clamp-1'"
            class="transition-all duration-200 min-w-0 ">
            {{ $subasta_titulo }}
        </span>


        <button x-show="truncated || expanded"
            @click.stop.prevent="
        expanded = !expanded;
        $nextTick(() => check())
    "
            class="ml-0 flex-shrink-0 w-4 h-4
           flex items-center justify-center pb-1
           text-sm font-bold
           border border-current rounded-full
           hover:bg-white hover:text-casa-rojo
           transition"
            type="button" aria-label="Expandir / contraer" title="">
            <span x-show="!expanded" title="ver mas">+</span>
            <span x-show="expanded" title="ver menos">−</span>
        </button>


    </a>
</li>
