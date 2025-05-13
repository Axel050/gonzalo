@props([
    'img' => '',
])

<div class="fixed inset-0  bg-gray-600/70 backdrop-blur-xs flex items-center justify-center z-50 animate-fade-in-scale cursor-pointer"
    @click="openModal = false" x-show="openModal" x-transition:leave="animate-fade-out-scale"
    x-transition:leave-end="opacity-0 scale-100">
    <div
        class="relative max-w-[95%] lg:max-w-4xl max-h-[90vh] rounded-lg shadow-xl flex items-center my-auto border-6 border-gray-100 overflow-y-hidden hover:scale-110 transition-transform">
        @if (method_exists($img, 'temporaryUrl'))
            <img src="{{ $img->temporaryUrl() }}">
        @elseif($img)
            <img src="{{ Storage::url('imagenes/lotes/normal/' . $img) }}" class="max-h-[90vh] w-auto rounded-lg"
                alt="Imagen grande">
        @endif
    </div>
</div>
