<x-modal>


    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} contrato
            </h2>

            {{-- form --}}
            <div class="bg-red-80  w-full  flex flex-col gap-2 lg:text-lg  text-base lg:px-4 px-2 text-gray-200  [&>div]:flex
                            [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto"
                {{-- wire:submit={{ $method }} --}}>

                @if ($method == 'delete')
                    <p class="text-center text-gray-600 lg:px-10 px-6"> Esta seguro de eliminar el contrato</p>
                    <p class="text-center text-gray-600"><strong>"{{ $deposito->comitente?->nombre }}
                            {{ $deposito->comitente?->apellido }}" </strong>?</p>
                @else
                    <x-form-item-sel label="Comitente" :method="$method" model="comitente_id">
                        <option>Elija comitente </option>
                        @foreach ($comitentes as $adq)
                            <option value="{{ $adq->id }}">
                                {{ $adq->alias?->nombre }} - {{ $adq->nombre }} {{ $adq->apellido }} </option>
                        @endforeach
                    </x-form-item-sel>

                    {{-- <x-form-item-sel label="Subasta" :method="$method" model="subasta_id">
                        <option>Elija subasta </option>
                        @foreach ($subastas as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->id }}</option>
                        @endforeach
                    </x-form-item-sel> --}}

                    <x-form-item-area label="Descripcion" :method="$method" model="descripcion" />

                    <x-form-item label="Fecha" :method="$method" model="fecha" type="date" />

                    @if ($method == 'save')
                        <label
                            class="flex items-center justify-center text-gray-500 leading-[16px] text-base  lg:m-2 bg-ed-100 mx-auto col-span-2 mt-2">
                            <input type="checkbox" wire:model="lotes" class="mr-2 size-4" />Agregar
                            lotes
                        </label>
                    @endif


                    <div class="border  border-blue-900 flex flex-col p-5 text-accent">

                        <button wire:click="$toggle('test')" type="button"
                            class="text-red-500 rounded-3xl p-3 bg-amber-300">xxxx</button>
                        <p class="bg-orage-100 p-2 text-lg">aaaaaaTest = {{ $test }}</p>
                        <p class="bg-orage-100 p-2 text-lg" wire:show="test">aaaaaaTest </p>
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
                            class="bg-green-600 hover:bg-green-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center "
                            wire:click="$method">
                            {{ $btnText }}
                        </button>
                    @endif


                </div>

            </div>


            {{-- </form> --}}

        </div>
    </div>
</x-modal>
