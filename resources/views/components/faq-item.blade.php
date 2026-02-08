<div x-data="{ open: false }" class="border-b border-casa-black/20 pb-4">
    <button @click="open = !open"
        class="w-full flex justify-between items-center text-left md:text-xl text-lg font-semibold">
        {{ $title }}
        <span x-text="open ? '−' : '+'"></span>
    </button>

    <div x-show="open" x-collapse class="mt-3 text-sm md:text-base">
        {{ $slot }}
    </div>
</div>
