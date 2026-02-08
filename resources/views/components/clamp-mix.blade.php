@props(['text', 'class' => 'md:text-3xl font-bold', 'tag' => 'h2', 'variant' => 'italic'])


<div x-data="{
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
    <{{ $tag }} x-ref="title"@click="(truncated || expanded) && (expanded = !expanded)"
        :class="expanded ? 'line-clamp-none' : 'line-clamp-1'"
        class="
            transition-all duration-200
            {{ $class }}
            cursor-pointer
        "
        :class="truncated ? 'cursor-pointer' : 'cursor-default'" title="Click para expandir">
        <x-fancy-heading-v-clamp :text="$text" :variant="$variant" />
        </{{ $tag }}>
</div>
