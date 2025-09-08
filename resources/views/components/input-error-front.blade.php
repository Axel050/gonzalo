@props(['for'])

@error($for)
    <div {{ $attributes->merge(['class' => 'flex items-center  text-sm text-red-600  ']) }}>

        <svg class="w-4 h-3.5 mr-1">
            <use xlink:href="#error-icon"></use>
        </svg>
        <p class="">
        <p {{ $attributes->merge(['class' => 'lg:max-w-60 leading-[12px] ']) }}>
            {{ $message }}
        </p>
    </div>
@enderror
