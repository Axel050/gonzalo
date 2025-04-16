<div class="fixed  inset-0 flex items-center justify-center  z-50 animate-fade-in-scale"
    wire:transition.out.class="animate-fade-out-scale" wire:transition.out.duration.600ms>

    <div class="absolute inset-0  bg-gray-600/70 backdrop-blur-xs transition-opacity duration-300"
        wire:click="$parent.$set('method',false)">
    </div>



    <div
        {{ $attributes->merge([
            'class' => ' border  border-gray-500   md:max-w-md  lg:w-[40%] w-[90%] x-auto  z-50  shadow-gray-400 shadow-md max-h-[95%] 
                                    transition delay-150 duration-300 ease-in-out hover:-translate-y-1 hover:scale-105 rounded-2xl    
                                                                                                        ',
        ]) }}>

        {{ $slot }}
    </div>
</div>
