<x-modal>

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} tipo de bien
            </h2>

            <form
                class="bg-red-80  w-full  flex flex-col justify-center items-center gap-2 lg:text-lg  text-base lg:px-4 px-2 text-gray-200  [&>div]:flex
                            [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto"
                wire:submit={{ $method }}>

                @if ($method == 'delete')
                    <p class="text-center text-gray-600 lg:px-10 px-6"> Esta seguro de eliminar el tipo </p>
                    <p class="text-center text-gray-600"><strong>"{{ $tipo->nombre }}" </strong>?</p>
                @else
                    <x-form-item label="Nombre" :method="$method" model="nombre" />

                    {{-- <x-form-item-sel label="Encargado" :method="$method" model="encargado_id">
                        <option>Elija encargado </option>
                        @foreach ($encargados as $encargado)
                            <option value="{{ $encargado->id }}"> {{ $encargado->nombre }},{{ $encargado->apellido }}
                            </option>
                        @endforeach
                    </x-form-item-sel> --}}

                    <div id="wrapper-select-tom2" class="lg:w-60 w-[85%] mx-auto ">
                        <label class="w-full text-start text-gray-500 leading-[16px] text-base">Encargado</label>
                        <select id="select-tom-tipo-bien-encargado" placeholder="Elija encargado"
                            wire:model="encargado_id">
                            <option value="">Elija encargado</option>
                            @foreach ($encargados as $encargado)
                                <option value="{{ $encargado->id }}">
                                    {{ $encargado->nombre }},{{ $encargado->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- <x-form-item-sel label="Suplente" :method="$method" model="suplente_id">
                        <option>Elija suplente </option>
                        @foreach ($encargados as $suplente)
                            <option value="{{ $suplente->id }}"> {{ $suplente->nombre }},{{ $suplente->apellido }}
                            </option>
                        @endforeach
                    </x-form-item-sel> --}}

                    <div id="wrapper-select-tom2" class="lg:w-60 w-[85%] mx-auto ">
                        <label class="w-full text-start text-gray-500 leading-[16px] text-base">Suplente</label>
                        <select id="select-tom-tipo-bien-suplente" placeholder="Elija suplente"
                            wire:model="suplente_id">
                            <option value="">Elija suplente</option>
                            @foreach ($encargados as $suplente)
                                <option value="{{ $suplente->id }}"> {{ $suplente->nombre }},{{ $suplente->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    @if ($method == 'save')
                        <label class="w-fit text-center text-gray-500 leading-[16px] text-base  lg:m-2 mx-auto ">
                            <input type="checkbox" wire:model="campos" class="mr-2" />Agregar campos
                        </label>
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
