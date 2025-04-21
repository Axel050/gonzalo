@props([
    'label' => '',
    'method' => '',
    'model' => '',
    'type' => 'text',
    'auto' => 'false',
    'step' => '1',
    'min' => 0,
])


<div {{ $attributes->merge(['class' => 'items-start  lg:w-auto w-[85%] mx-auto  mb-[-5px] ']) }}>
    <label class="w-full text-start text-gray-500 leading-[16px] text-base">{{ $label }}</label>
    <div class="relative w-full ">
        <input type={{ $type }} wire:model="{{ $model }}" step={{ $step }} min={{ $min }}
            class="lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 p-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600"
            @disabled($method === 'view') />
        <x-input-error for="{{ $model }}" class="top-full py-0 leading-[12px] text-red-500" />
    </div>
</div>
