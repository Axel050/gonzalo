<x-modal class="lg:max-w-[80%] lg:w-auto ">


    <div class="bg-gray-200  pb-8 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} usuario
            </h2>

            <form
                class="w-full  grid lg:grid-cols-4 grid-cols-1 lg:gap-4 gap-2 
                            text-base lg:px-8 px-2 text-gray-200  [&>div]:flex
                            [&>div]:flex-col   pt-4 max-h-[85vh] overflow-y-auto "
                wire:submit={{ $method }}>

                @if ($method == 'delete')
                    <p class="text-center text-gray-600 lg:px-10 px-6 col-span-4"> Esta seguro de eliminar el
                        usuario</p>
                    <p class="text-center text-gray-600 col-span-4"><strong>"{{ $personal->nombre }}" </strong>?
                    </p>
                @else
                    <div class="lg:col-span-4">
                        <x-form-item-foto label="" model="foto" :foto="$foto" w="150" h="150"
                            folder="personal" />
                    </div>

                    <x-form-item label="Nombre" model="nombre" />
                    <x-form-item label="Apellido" model="apellido" />
                    <x-form-item label="Email" model="email" />
                    <x-form-item label="Alias" model="alias" />
                    <x-form-item label="telefono" model="telefono" />
                    <x-form-item label="CUIT" model="CUIT" />
                    <x-form-item label="Domicilio" model="domicilio" />
                    <x-form-item-sel label="Rol" model="role_id">
                        <option value="">Elija rol</option>
                        @foreach ($roles as $rol)
                            <option value={{ $rol->id }}>{{ $rol->name }}</option>
                        @endforeach
                    </x-form-item-sel>
                    <x-form-item label="Password" model="password" />
                    <x-form-item label="Confirme password" model="password_confirmation" />



                @endif

                <div
                    class="flex
                               !flex-row gap-6 justify-center lg:text-base text-sm lg:col-span-4 grid-cols-1">
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
