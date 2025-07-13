<div class="flex flex-col justify-center items-center h-lvh w-full ">
    <h1 class="text-5xl text-white mx-auto font-bold"> {{ $lote->titulo }} {{ $id }}</h1>

    <p class="text-gray-100 mt-4 text-lg">Precio base : <b>{{ (int) $base }}</b></p>
    <p class="text-gray-100 mt-2 text-lg">Precio actual : <b> {{ (int) $ultimaOferta }}</b></p>
    {{-- @dump($ownPuja) --}}



    @if (auth()->user()?->adquirente?->estado_id == 1 || auth()->user()?->adquirente?->garantia(9))

        @if ($own || $pujado)
            <button
                class="bg-green-400 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl cursor-not-allowed">
                Tu oferta es la ultima
            </button>
        @else
            <button
                class="bg-green-500 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-700"
                wire:click.debounce.500ms="registrarPuja(1,500)" wire:loading.attr="disabled"
                wire:loading.class="opacity-50 cursor-not-allowed" wire:target="registrarPuja">
                {{-- Muestra/oculta SÓLO cuando 'registrarPuja' está en ejecución --}}
                <span wire:loading.remove wire:target="registrarPuja">Pujar</span>
                <span wire:loading wire:target="registrarPuja">Procesando...</span>
            </button>
        @endif
    @else
        <button
            class="bg-green-300 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-500">No
            habilitado para pujar</button>
    @endif

    @error('puja')
        <h1 class="text-white text-lg mt-2">eorr _ {{ $message }}</h1>
    @enderror

    <x-input-error for="puja" class="absolute top-full text-white text-2xl mt-2" />
    {{-- @if (auth()->user()?->adquirente?->garantia(9))
      <button
          class="bg-green-300 px-4 py-2 rounded-2xl mx-auto text-white mt-8 font-bold text-xl hover:bg-green-500">
          Pujar G</button>
  @endif --}}


</div>
