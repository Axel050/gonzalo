@props(['label' => '', 'method' => '', 'model' => ''  ])

  <div class="!justify-start items-start  lg:w-auto w-[85%] mx-auto ">
      <label  class="w-full text-start text-gray-500 mt-2 leading-[16px] text-base">{{$label}}</label>
      <div class="relative w-full">
        <textarea   wire:model="{{$model}}"  class =" h-auto pt-0 rounded-md border border-gray-400 lg:w-60 w-full text-gray-500 bg-gray-100 pl-2 text-sm"    @disabled($method === 'view') >
        </textarea>
        <x-input-error for="{{$model}}"   class="absolute top-full"/>
      </div>
    </div>