@props(['label' => '', 'method' => '', 'model' => '', 'foto' => '', 'w' => '', 'h' => '', 'folder' => ''])

<div class="items-start  lg:w-auto w-[85%] mx-auto">

    <div class="pl-2">
        <label class="w-full text-start text-gray-500 mt-2 leading-[16px] text-base">{{ $label }}</label>
        <div class="mt-0.5">

            @php
                $url =
                    $foto && method_exists($foto, 'temporaryUrl')
                        ? $foto->temporaryUrl()
                        : ($foto
                            ? Storage::url('imagenes/' . $folder . '/' . $foto)
                            : asset('004b.jpg'));
            @endphp

            <img src="{{ $url }}" alt="Previsualización"
                style="max-width: {{ $w }}px; max-height: {{ $h }}px; object-fit: cover; display: block;"
                class="mx-auto border">

        </div>


        <div x-data="{ uploading: false, progress: 0 }" x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false" x-on:livewire-upload-cancel="uploading = false"
            x-on:livewire-upload-error="uploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress">


            <input
                class=" mt-2  mr-2 text-gray-700 text-xs flex flex-col border border-cyan-800 rounded-xl pr-1 lg:w-60
                                              file:bg-gradient-to-r file:from-cyan-800 file:to-cyan-950 file:rounded-l-xl file:px-2 file:text-gray-100 file:text-xs
                                              hover:file:bg-gradient-to-l hover:file:from-cyan-900 hover:file:to-cyan-950 hover:file:text-white 
                                              cursor-pointer file:cursor-pointer disabled:cursor-not-allowed disabled:file:cursor-not-allowed"
                id="file_input" type="file" wire:model="{{ $model }}" accept=".jpg, .jpeg, .png"
                @disabled($method === 'view') />


            <div class="mb-1" style="height: 7px;">
                <x-input-error for="foto" style="font-size: 13px" />
            </div>

            <!-- Progress Bar -->
            <div x-show="uploading" class="text-center">
                <progress max="100" x-bind:value="progress"></progress>
            </div>

        </div>



    </div>
</div>
