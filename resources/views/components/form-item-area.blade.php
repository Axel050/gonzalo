@props(['label' => '', 'method' => '', 'model' => ''])

<div {{ $attributes->merge(['class' => 'items-start  lg:w-auto w-[85%] mx-auto  mb-[-5px] ']) }}>
    <label class="w-full text-start text-gray-500  leading-[16px] text-base">{{ $label }}</label>
    <div class="relative w-full">
        <textarea wire:model="{{ $model }}"
            class =" h-auto pt-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm field-sizing-content"
            @disabled($method === 'view')>
        </textarea>
        <x-input-error for="{{ $model }}" class="absolute top-full" />
    </div>
</div>
