@props(['label' => '', 'method' => '', 'model' => '', 'live' => false])

<div class="items-start  lg:w-60 w-[85%] mx-auto ">
    <label class="w-full text-start text-gray-500 leading-[16px] text-base">{{ $label }}</label>
    <div class="relative w-full">
        <select wire:model{{ $live ? '.live' : '' }}="{{ $model }}"
            class =" h-6 py-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm"
            @disabled($method === 'view')>
            {{ $slot }}
        </select>
        <x-input-error for="{{ $model }}" class="absotule top-full py-0 leading-[12px] text-red-500" />
    </div>
</div>
