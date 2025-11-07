@props([
    'label' => '',
    'method' => '',
    'model' => '',
    'type' => 'text',
    'auto' => 'false',
    'step' => '1',
    'min' => 0,
    'live' => false,
])


<div {{ $attributes->merge(['class' => 'items-start  lg:w-60 w-[85%] mx-auto  b-[-6px] ']) }}>
    <label class="w-full text-start text-gray-500 leading-[18px] text-base">{{ $label }} </label>
    <div class="relative w-full ">

        <input type ="{{ $type }}" wire:model{{ $live ? '.live' : '' }}="{{ $model }}"
            step={{ $step }} min={{ $min }} {{-- class="lg:w-60 h-6 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600" --}}
            {{ $attributes->merge(['class' => 'lg:w-60 h-6 py-0 rounded-md border border-gray-400 w-full text-gray-500 pl-2 text-sm bg-gray-100 disabled:bg-gray-300 disabled:text-gray-600']) }}
            @disabled($method === 'view') />

        <x-input-error for="{{ $model }}" class="top-full py-0 leading-[12px] text-red-500" />
    </div>
</div>
