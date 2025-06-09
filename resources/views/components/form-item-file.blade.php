@props([
    'label' => '',
    'method' => '',
    'model' => '',
    'auto' => 'false',
])


<div {{ $attributes->merge(['class' => 'items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] ']) }}>
    <label class="w-full text-start text-gray-500 leading-[16px] text-base">{{ $label }} - {{ $model }}
    </label>
    @php
        $url =
            $model && method_exists($model, 'temporaryUrl')
                ? $model->temporaryUrl()
                : ($model
                    ? Storage::url('lotes/' . $model)
                    : '');
    @endphp
    <span>{{ $url }}</span>
    <span>{{ $model }}</span>
    <audio controls src="{{ $url }} "></audio>
    <div class="relative w-full ">

        <input type="file" wire:model="{{ $model }}"
            class="lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-xs bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600
          cursor-pointer file:cursor-pointer  pt-0.5 "
            @disabled($method === 'view') />

        <x-input-error for="{{ $model }}" class="top-full py-0 leading-[12px] text-red-500" />
    </div>
</div>
