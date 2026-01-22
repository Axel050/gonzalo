@props(['subasta_id', 'route', 'subasta_titulo'])

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
           fex-1 min-w-0 relative ">


    <a href="{{ route($route, $subastaId) }}" title="Ir a subasta" class="flex items-center gap-1 min-w-0">
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
            class="ml-0 flex-shrink-0 
                          rounded-4xl
           hover:bg-white hover:text-casa-rojo
           transition"
            type="button" aria-label="Expandir / contraer" title="">
            {{-- <span x-show="!expanded" title="ver mas">+</span> --}}
            <svg class="md:size-[24px] size-[22px]" x-show="!expanded" title="ver mas">
                <use xlink:href="#plus"></use>
            </svg>

            <svg class="md:size-[24px] size-[22px]" x-show="expanded" title="ver menos"
                :class="{ 'bg-casa-rojo rounded-4xl text-casa-base hover:text-casa-rojo hover:bg-casa-base': expanded }">
                <use xlink:href="#minus"></use>
            </svg>
        </button>


    </a>
</li>
