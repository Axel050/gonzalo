@props([
    'label' => '',
    'method' => '',
    'model' => '',
    'foto' => '',
    'w' => '150',
    'h' => '150',
    'folder' => '',
    'view_foto' => false,
])

<div class="  lg:w-60 w-[85%] mx-auto  ">
    <div>
        <label class="w-full text-start text-gray-500 mt-2 leading-[16px] text-base">{{ $label }}</label>
        <div class="mt-0">
            @php
                if ($foto && method_exists($foto, 'temporaryUrl')) {
                    $url = $foto->temporaryUrl();
                    $click = true;
                } elseif ($foto) {
                    $url = Storage::url('imagenes/' . $folder . '/' . $foto);
                    $click = true;
                } else {
                    $url = asset('004b.jpg');
                    $url = Storage::url('imagenes/default.png');
                    $click = false;
                }
            @endphp

            <!-- Imagen con evento de clic condicional -->
            <div x-data="{ openModal: false }" @close-modal="openModal = false"
                class="lg:h-36 h-28 flex flex-col justify-center  lg:max-h-36 max-h-28 ">
                @if ($click)
                    <img src="{{ $url }}" alt="Previsualización"
                        class="mx-auto  cursor-pointer  max-h-full hover:scale-105 transition-transform"
                        @click="openModal = true ">
                @else
                    <svg class="mx-auto  cursor-pointer  lg:size-36 size-28 hover:scale-105 transition-transform "
                        @click="document.getElementById('{{ $model }}').click()">
                        <use xlink:href="#default-img-input"></use>
                    </svg>
                @endif



                <div x-show="openModal" @click.away="openModal = false">
                    <x-modal-foto2 :img="$foto" />
                </div>

            </div>
        </div>


        <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
            x-on:livewire-upload-error="uploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress" class="text-center">


            <button class="bg-cyan-800 rounded-lg px-4 py-1  text-xs hover:bg-cyan-950"
                @click="document.getElementById('{{ $model }}').click()">
                Seleccionar imagen
            </button>


            <input class="hidden" {{-- class="mt-2 mr-2 text-gray-700 text-xs hidden lex flex-col border border-cyan-800 rounded-xl pr-1 lg:w-60
                       file:bg-gradient-to-r file:from-cyan-800 file:to-cyan-950 file:rounded-l-xl file:px-2 file:text-gray-100 file:text-xs
                       hover:file:bg-gradient-to-l hover:file:from-cyan-900 hover:file:to-cyan-950 hover:file:text-white 
                       cursor-pointer file:cursor-pointer disabled:cursor-not-allowed disabled:file:cursor-not-allowed" --}} type="file" id="{{ $model }}"
                wire:model="{{ $model }}" accept=".jpg, .jpeg, .png" @disabled($method === 'view') />



            <div class="mb-1" style="height: 7px;">
                <x-input-error for="{{ $model }}" style="font-size: 13px" />
            </div>

            <!-- Progress Bar -->
            <div x-show="uploading" class="text-center">
                <progress max="100" x-bind:value="progress"></progress>
            </div>
        </div>
    </div>

</div>
