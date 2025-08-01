<x-modal>

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} subasta
            </h2>

            <form
                class="bg-red-80  w-full  flex flex-col gap-2 lg:text-lg  text-base lg:px-4 px-2 text-gray-200  [&>div]:flex
                            [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto"
                wire:submit={{ $method }}>

                @if ($method == 'delete')
                    <p class="text-center text-gray-600 lg:px-10 px-6"> Esta seguro de eliminar la subasta</p>
                    <p class="text-center text-gray-600"><strong>"{{ $subasta->id }}" </strong>?</p>
                @else
                    <x-form-item label="Numero" method="view" model="num" />

                    <x-form-item label="Titulo" :method="$method" model="titulo" />

                    <x-form-item label="Comision" :method="$method" model="comision" type="number" step="0.1"
                        min=0 />

                    <x-form-item label="Tiempo post subasta (min)" :method="$method" model="tiempoPos" type="number"
                        step="1" min=0 />

                    <x-form-item label="Garantia" :method="$method" model="garantia" type="number" step="1"
                        min=0 />


                    <div class="items-start  lg:w-auto w-[85%] mx-auto ">
                        <label class="w-full text-start text-gray-500  leading-[16px] text-base">Inicio </label>
                        <div class="relative w-full ">
                            <input type="date" wire:model="iniD"
                                class ="h-6 rounded-md border border-gray-400 w-40 text-gray-500 p-1 text-sm bg-gray-100"
                                @disabled($method === 'view') />
                            <input type="time" wire:model="iniH"
                                class ="h-6 rounded-md border border-gray-400 w-20 text-gray-500 pl-1 text-sm bg-gray-100"
                                @disabled($method === 'view') />
                            <x-input-error for="iniD" class="relative top-full py-0 leading-[12px]" />
                            <x-input-error for="iniH" class="relative top-full py-0 leading-[12px]" />
                        </div>
                    </div>

                    <div class="items-start  lg:w-auto w-[85%] mx-auto ">
                        <label class="w-full text-start text-gray-500  leading-[16px] text-base">Fin </label>
                        <div class="relative w-full ">
                            <input type="date" wire:model="finD"
                                class ="h-6 rounded-md border border-gray-400 w-40 text-gray-500 p-1 text-sm bg-gray-100"
                                @disabled($method === 'view') />
                            <input type="time" wire:model="finH"
                                class ="h-6 rounded-md border border-gray-400 w-20 text-gray-500 pl-1 text-sm bg-gray-100"
                                @disabled($method === 'view') />
                            <x-input-error for="finD" class="relative top-full py-0 leading-[12px]" />
                            <x-input-error for="finH" class="relative top-full py-0 leading-[12px]" />
                        </div>
                    </div>

                    <x-form-item-area label="Descripcion" :method="$method" model="descripcion" />

                    @if ($method == 'update' || $method == 'view')
                        <x-form-item label="Estado" method="view" model="estado" />
                    @endif



                    {{-- <x-form-item-sel label="Estado" :method="$method" model="estado" method="view">
                        <option>Elija estado </option>
                        @foreach ($estados as $item)
                            <option value="{{ $item['value'] }}"> {{ $item['label'] }} </option>
                        @endforeach
                    </x-form-item-sel> --}}


                    @if ($method == 'update' && in_array($subasta->estado, ['activa', 'pausada', 'enpuja']))
                        <div class="items-start  lg:w-60 w-[85%] mx-auto  mb-[-5px] mt-1.5">

                            <label class="w-full text-start text-gray-500  leading-[16px] text-base">
                                {{ $subasta->estado == 'activa' || $subasta->estado == 'enpuja' ? 'Pausar' : 'Activar' }}
                            </label>
                            <div class="relative w-full   text-gray-600 flex pl-14 gap-x-10 lg:gap-x-14  text-base">

                                <div class="flex  items-center">

                                    <input type="radio" wire:model="pausar" value="0" name="pausa"
                                        class ="h-6 rounded-md border border-gray-400 w-4 text-gray-500 p-1 text-sm bg-gray-100 mr-0.5" />
                                    No
                                </div>

                                <div class="flex   items-center">
                                    <input type="radio" wire:model="pausar" value="1" name="pausa"
                                        class ="h-6 rounded-md border border-gray-400 w-4 text-gray-500 pl-1 text-sm bg-gray-100 mr-0.5" />Si
                                </div>
                                <x-input-error for="finD" class="relative top-full py-0 leading-[12px]" />
                            </div>
                        </div>
                    @endif


                @endif

                <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm">
                    <button type="button"
                        class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                        wire:click="$parent.$set('method',false)">
                        Cancelar
                    </button>

                    @if ($method != 'view')
                        <button
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center ">
                            {{ $btnText }}
                        </button>
                    @endif


                </div>

            </form>

        </div>
    </div>


</x-modal>
