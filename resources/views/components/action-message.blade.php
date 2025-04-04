@props([
    'on',
])

<div
    x-data="{ shown: false, timeout: null }"
    x-init="@this.on('{{ $on }}', () => { clearTimeout(timeout); shown = true; timeout = setTimeout(() => { shown = false }, 2000); })"
    x-show.transition.out.opacity.duration.1500ms="shown"
    x-transition:leave.opacity.duration.1500ms
    style="display: none"
    {{ $attributes->merge(['class' => 'lg:text-base text-sm text-white font-extrabold bg-linear-to-r  lg:pl-4 lg:pr-12 pr-6 pl-2 rounded-l-2xl py-2  border-r-6   h-11 mt-1']) }}
>
    {{ $slot->isEmpty() ? __('Saved.') : $slot }}
</div>
