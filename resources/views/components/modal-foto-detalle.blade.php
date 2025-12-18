@props(['records' => [], 'currentIndex' => 0])

<div class="fixed inset-0 bg-gray-600/70 backdrop-blur-xs flex  items-center justify-center z-50 cursor-pointer animate-fade-in-scale"
    x-data="{
        records: @js($records),
        currentIndex: {{ $currentIndex }},
        show: true,
        touchStartX: 0,
        touchEndX: 0,
        get hasMultiple() {
            return this.records.length > 1;
        },
        next() {
            if (!this.hasMultiple) return;
            this.currentIndex = (this.currentIndex + 1) % this.records.length;
        },
        prev() {
            if (!this.hasMultiple) return;
            this.currentIndex = (this.currentIndex - 1 + this.records.length) % this.records.length;
        },
        goTo(index) {
            if (!this.hasMultiple) return;
            this.currentIndex = index;
        },
        handleSwipe() {
            if (!this.hasMultiple) return;
            const threshold = 50;
            const diff = this.touchStartX - this.touchEndX;
            if (Math.abs(diff) > threshold) {
                diff > 0 ? this.next() : this.prev();
            }
        }
    }" x-on:click.self="$dispatch('close-modal')"
    x-on:close-modal.window="show=false; setTimeout(() => { @this.set('modal_foto', null) }, 200)"
    x-transition:leave="animate-fade-out-scale">

    {{-- <span class="text-4xl font-bold text-white absolute top-10 right-10 cursor-pointer" @click="$dispatch('close-modal')"> --}}


    {{-- </span> --}}

    <div
        class="relative max-w-[95%]     max-h-[81vh]  shadow-xl   lg:inline-flex  grid   grid-cols-2  items-center border-6 border-gray-100 overlow-hidden p-4 bg-casa-base lg:gap-x-10 gap-x-20 gap-y-5">

        <svg class="size-16 text-casa-base  absolute -top-16 -right-5 cursor-pointe z-10"
            @click="$dispatch('close-modal')">
            <use xlink:href="#x"></use>
        </svg>



        <!-- Flecha izquierda -->
        {{-- <button x-show="records.length > 1" @click.stop="prev"
            class=" z-10 bg-hite/70 rounded-full p-2 hover:scale-105 lg:order-1 order-2 col-span-1  ml-auto"> --}}
        <button x-show="hasMultiple" @click.stop="prev"
            class="hidden lg:inline-flex z-10 rounded-full p-2 hover:scale-105 order-2">


            <svg class="rotate-180 lg:w-10 w-7 lg:h-17 h-14 " viewBox="0 0 39 67" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M2.269 65.5L36.731 33.5 2.269 1.5" stroke="#262626" stroke-width="3" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>



        </button>

        <img :src="records[currentIndex].image"
            class="md:max-h-[80vh] max-h-[70vh] w-auto mx-auto transition-all duration-300 col-span-2 lg:order-2 order-1"
            x-on:touchstart="touchStartX = $event.touches[0].clientX"
            x-on:touchend="touchEndX = $event.changedTouches[0].clientX; handleSwipe()" />

        <div x-show="hasMultiple" class="flex lg:hidden col-span-2 justify-center gap-3 mt-2 order-2">
            <template x-for="(record, index) in records" :key="index">
                <button @click.stop="goTo(index)" class="w-3 h-3 rounded-full transition-all duration-300"
                    :class="index === currentIndex ?
                        'bg-casa-black scale-125' :
                        'bg-gray-300'"></button>
            </template>
        </div>



        <!-- Flecha derecha -->
        <button x-show="hasMultiple" @click.stop="next"
            class="hidden lg:inline-flex z-10 rounded-full p-2 hover:scale-105 order-3">

            <svg class=" lg:w-10 w-7 lg:h-17 h-14 " viewBox="0 0 39 67" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M2.269 65.5L36.731 33.5 2.269 1.5" stroke="#262626" stroke-width="3" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </button>
    </div>
</div>
