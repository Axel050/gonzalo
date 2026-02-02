@props(['text', 'class' => 'md:text-3xl font-bold', 'tag' => 'h2'])

<div {{-- x-data="{
    expanded: false,
    truncated: false,
    checkTruncate(el) {
        this.$nextTick(() => {
            if (!el) return
            const threshold = 2
            this.truncated = el.scrollHeight > (el.offsetHeight + threshold)
        })
    }
}"
 x-init="checkTruncate($refs.title)"  --}} x-data="{
    expanded: false,
    truncated: false,
    observer: null,
    checkTruncate(el) {
        if (!el) return
        const threshold = 2
        this.truncated = el.scrollHeight > (el.offsetHeight + threshold)
    },
    init() {
        this.$nextTick(() => {
            this.checkTruncate(this.$refs.title)

            this.observer = new ResizeObserver(() => {
                this.checkTruncate(this.$refs.title)
            })

            this.observer.observe(this.$refs.title)
        })
    }
}" x-init="init()" class="relative z-30">
    <{{ $tag }} x-ref="title" {{-- @click="truncated && (expanded = !expanded)" --}} @click="(truncated || expanded) && (expanded = !expanded)"
        :class="expanded ? 'line-clamp-none' : 'line-clamp-1'"
        class="cursor-pointer transition-all duration-200 mr-1 {{ $class }}" title="Click para expandir">
        {{ $text }}
        </{{ $tag }}>
</div>
