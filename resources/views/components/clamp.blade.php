@props(['text', 'class' => 'md:text-3xl font-bold', 'tag' => 'h2'])

<div x-data="{
    expanded: false,
    truncated: false,
    checkTruncate(el) {
        this.$nextTick(() => {
            if (!el) return
            const threshold = 2
            this.truncated = el.scrollHeight > (el.offsetHeight + threshold)
        })
    }
}" x-init="checkTruncate($refs.title)" class="relative z-30">
    <{{ $tag }} x-ref="title" @click="truncated && (expanded = !expanded)"
        :class="expanded ? 'line-clamp-none' : 'line-clamp-1'"
        class="cursor-pointer transition-all duration-200 mr-1 {{ $class }}" title="Click para expandir">
        {{ $text }}
        </{{ $tag }}>
</div>
