<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale">


    <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300"
        wire:click="$parent.$set('method',false)">
    </div>

    <div
        {{ $attributes->merge([
            'class' => ' border  border-gray-500   md:max-w-xl  lg:w-[40%] w-[90%] x-auto  z-50  shadow-gray-400 shadow-md max-h-[95%] 
                                                        transition delay-150 duration-300 ease-in-out  rounded-2xl ',
        ]) }}>

        {{ $slot }}
    </div>
</div>
