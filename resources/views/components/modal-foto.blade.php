@props([
    'img' => '',
])

<div class="fixed inset-0 bg-gray-600/70 backdrop-blur-xs flex items-center justify-center z-50 animate-fade-in-scale cursor-pointer"
    x-data="{ show: true }" x-show="show" x-transition:leave="animate-fade-out-scale"
    x-transition:leave-end="opacity-0 scale-100"
    x-on:close-modal.window="show = false; setTimeout(() => { @this.set('modal_foto', null) }, 300)"
    x-on:click="$dispatch('close-modal')">

    <div
        class="relative max-w-[95%] lg:max-w-4xl max-h-[90vh] rounded-lg shadow-xl flex items-center  my-auto border-6 border-gray-100 overflow-y-hidden hover:scale-110 transition-transform">
        <img src="{{ Storage::url('imagenes/lotes/normal/' . $img) }}" class="max-h-[90vh] w-auto rounde-lg"
            alt="Imagen grande">
    </div>
</div>
