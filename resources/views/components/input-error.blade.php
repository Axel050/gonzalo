@props(['for'])

@error($for)
    <div {{ $attributes->merge(['class' => 'flex items-center text-sm text-red-600 bsolute ']) }}>

        <svg class="w-4 h-3.5 mr-1">
            <use xlink:href="#error-icon"></use>
        </svg>
        <p class="lg:max-w-60 leading-[12px]">
            {{-- <p {{ $attributes->merge(['class' => 'text-sm text-red-600']) }}>       --}}
            {{ $message }}
        </p>
    </div>
@enderror
