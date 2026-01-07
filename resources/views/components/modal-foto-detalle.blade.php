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
        class="relative bg-white shadow-2xl
         max-w-[95vw] max-h-[91vh]
         w-auto h-auto
         pt-2 px-2 pb-1 md:p-5
         flex flex-col items-center justify-center">

        <svg class="md:size-14 lg:size-16 size-12 text-casa-base  absolute -top-10 -right-2  sm:-top-6 sm:-right-10  md:-right-14 md:-top-7 cursor-pointe z-10"
            @click="$dispatch('close-modal')">
            <use xlink:href="#x"></use>
        </svg>

        <!-- Flecha izquierda -->
        <button x-show="hasMultiple" @click.stop="prev"
            class="hidden lg:flex absolute -left-14 top-1/2 -translate-y-1/2 z-20
         rounded-full p-2 shadow text-casa-base hover:border-casa-base-2 hover:border">

            <svg class="rotate-180 w-9  h-16  " viewBox="0 0 39 67" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.269 65.5L36.731 33.5 2.269 1.5" stroke="currentColor" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>

        </button>

        <div class="flex-1 flex items-center justify-center ">
            <img :src="records[currentIndex].image"
                class="max-w-full md:max-h-[calc(90vh-40px)] max-h-[calc(82vh-26px)] object-contain transition-all duration-300"
                x-on:touchstart="touchStartX = $event.touches[0].clientX"
                x-on:touchend="touchEndX = $event.changedTouches[0].clientX; handleSwipe()" />
        </div>

        <div x-show="hasMultiple" class="lg:hidden 
         flex  gap-x-4 h-16px pt-1 mt-0.5">
            <template x-for="(record, index) in records" :key="index">
                <button @click.stop="goTo(index)" class="w-3 h-3 rounded-full transition-all duration-300"
                    :class="index === currentIndex ?
                        'bg-casa-black scale-125' :
                        'bg-gray-300'"></button>
            </template>
        </div>



        <!-- Flecha derecha -->
        <button x-show="hasMultiple" @click.stop="next"
            class="hidden lg:flex absolute -right-14 top-1/2 -translate-y-1/2 z-20
          rounded-full p-2 shadow text-casa-base hover:border-casa-base-2 hover:border">

            <svg class=" w-9 h-16 " viewBox="0 0 39 67" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M2.269 65.5L36.731 33.5 2.269 1.5" stroke="currentColor" stroke-width="3"
                    stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </button>
    </div>
</div>
