<x-modal>

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} rol
            </h2>

            <form
                class="bg-red-80  w-full  flex flex-col gap-2 lg:text-lg  text-base lg:px-4 px-2 text-gray-200  [&>div]:flex
                            [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto"
                wire:submit={{ $method }}>

                @if ($method == 'delete')
                    <p class="text-center text-gray-600 lg:px-10 px-6"> Esta seguro de eliminar el rol
                    </p>
                    <p class="text-center text-gray-600"><strong>"{{ $rol->name }}" </strong>?</p>
                @else
                    <x-form-item label="Nombre" model="name" />
                    <x-form-item label="Descripcion" model="description" />

                    <div class="items-start  lg:w-auto w-[85%] mx-auto ">
                        <label class="w-full text-start text-gray-500 leading-[16px] text-base">
                            Activo
                        </label>
                        <div class="flex lg:w-60 h-6  w-full text-gray-500  text-sm pl-3 items-center">

                            Si<input type="radio" wire:model="is_active" name="active" value="1"
                                class="ml-1 mr-6 size-4">
                            No <input type="radio" wire:model="is_active" name="active" value="0"
                                class="ml-1 size-4">
                        </div>

                    </div>
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
