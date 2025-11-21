@props(['records' => [], 'currentIndex' => 0])

<div class="fixed inset-0 bg-gray-600/70 backdrop-blur-xs flex  items-center justify-center z-50 cursor-pointer animate-fade-in-scale"
    x-data="{
        records: @js($records),
        currentIndex: {{ $currentIndex }},
        show: true,
        next() { this.currentIndex = (this.currentIndex + 1) % this.records.length; },
        prev() { this.currentIndex = (this.currentIndex - 1 + this.records.length) % this.records.length; }
    }" x-show="show" x-on:click.self="$dispatch('close-modal')"
    x-on:close-modal.window="show=false; setTimeout(() => { @this.set('modal_foto', null) }, 200)"
    x-transition:leave="animate-fade-out-scale">
    <span class="text-4xl font-bold text-white absolute top-10 right-10 cursor-pointer"
        @click="$dispatch('close-modal')">X</span>

    <div
        class="relative max-w-[95%]    max-h-[90vh]  shadow-xl   lg:inline-flex  grid   grid-cols-2  items-center border-6 border-gray-100 overflow-hidden p-4 bg-casa-base lg:gap-x-10 gap-x-20 gap-y-5">
        <!-- Flecha izquierda -->

        <button x-show="records.length > 1" @click.stop="prev"
            class=" z-10 bg-hite/70 rounded-full p-2 hover:scale-105 lg:order-1 order-2 col-span-1  ml-auto">
            <svg class="rotate-180 lg:w-10 w-7 lg:h-17 h-14 " viewBox="0 0 39 67" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M2.269 65.5L36.731 33.5 2.269 1.5" stroke="#262626" stroke-width="3" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>

        <img :src="records[currentIndex].image"
            class="max-h-[90vh] w-auto  mx-auto transition-all duration-300    col-span-2 lg:order-2 order-1">

        <!-- Flecha derecha -->
        <button x-show="records.length > 1" @click.stop="next"
            class=" z-10 bg-hite/70 rounded-full p-2 hover:scale-105  order-3 col-span-1">
            <svg class=" lg:w-10 w-7 lg:h-17 h-14 " viewBox="0 0 39 67" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M2.269 65.5L36.731 33.5 2.269 1.5" stroke="#262626" stroke-width="3" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </div>
</div>
