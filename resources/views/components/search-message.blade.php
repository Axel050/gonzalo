 @props(['search'])

 <div class=" bg-casa-black flex  border rounded-full    mx-auto justify-between pl-3 pr-1 py-0.5 items-center  border-casa-black col-span-3 w-fit "
     wire:show="filtered">

     <p class="text-nowrap text-casa-base-2 ml-2">Resultados para <b>"{{ $search }}"</b>
     </p>


     <button wire:click="todos"
         class="bg-casa-base-2 hover:bg-casa-black-h hover:text-casa-base border border-casa-base  text-casa-black rounded-full px-4 flex items-center justify-between  py-0.5 w-fit md:ml-20 ml-4">
         Ver todos los lotes
         <span class="text-xl leading-0 ml-8">X</span>
     </button>
 </div>


 <div class=" bg-casa-black flex  border rounded-full  w-fit  mx-auto justify-between  py-2 items-center  border-casa-black col-span-3 text-casa-base-2  px-4 md:text-xl text-lg"
     wire:show="noSearch">
     <button wire:click="$set('noSearch',false)">¡Sin resultados para <b>"{{ $search }}"</b>!

         <svg class="lg:size-8 size-7 lg:ml-20 ml-7 inline hover:scale-105">
             <use xlink:href="#x"></use>
         </svg>


     </button>

 </div>
