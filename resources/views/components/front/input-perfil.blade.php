@props(['label', 'model', 'type' => 'text', 'disabled' => false, 'placeholder' => ''])

<div class="items-start lg:w-64 w-full lg:mx-auto">
    <label class="w-full text-start text-casa-black text-base font-bold">{{ $label }}</label>
    <div class="relative w-full mt-1">
        <input type="{{ $type }}" wire:model="{{ $model }}" {{ $disabled ? 'disabled' : '' }}
            placeholder="{{ $placeholder }}" @class([
                'lg:w-64 rounded-full border border-casa-black w-full px-3 text-sm py-1 md:text-base transition-all',
                'bg-gray-100 text-gray-600 cursor-not-allowed opacity-70' => $disabled,
                'bg-casa-base text-gray-800' => !$disabled,
            ]) />
        <x-input-error for="{{ $model }}" class="top-full py-0 leading-[12px] text-red-500" />
    </div>
</div>
