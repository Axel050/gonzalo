<x-modal>

    <div class="bg-gray-200  pb-6 text-gray-700  text-start rounded-xl ml-0">
        <div class="flex  flex-col justify-center items-center  ">
            <h2 class="lg:text-2xl text-xl mb-2  w-full text-center py-1  border-b border-gray-300 text-white rounded-t-lg"
                style="{{ $bg }}">
                {{ $title }} auditoria
            </h2>

            <form
                class="bg-red-80  w-full  flex flex-col gap-2 lg:text-lg  text-base lg:px-4 px-2 text-gray-200  [&>div]:flex
                            [&>div]:flex-col  [&>div]:justify-center pt-4 max-h-[85vh] overflow-y-auto"
                wire:submit={{ $method }}>

                @if ($method == 'delete')
                    <p class="text-center text-gray-600 lg:px-10 px-6"> Esta seguro de eliminar la auditoria</p>
                    <p class="text-center text-gray-600"><strong>"{{ $auditoria->id }}" </strong>?</p>
                @else
                    {{-- @dump($auditoria) --}}
                    {{-- <td class="py-2">{{ class_basename($aud->auditable_type) }}</td> --}}
                    {{-- <td class="py-2">{{ $aud->auditable_id }}</td> --}}

                    <ul
                        class="mx-auto mb-[-5px] text-gray-700 grid grid-cols-2 [&>li]:text-start lg:gap-4 gap-2 items-start [&>li]:shadow-lg [&>li]:px-1 [&>li]:bg-gray-100 [&>li]:rounded-lg">
                        <li>ID: <span class="text-gray-500"> {{ $auditoria->id }}</span></li>
                        @php

                            switch ($auditoria->event) {
                                case 'created':
                                    $event = 'Crear';
                                    break;
                                case 'updated':
                                    $event = 'Editar';
                                    break;
                                case 'deleted':
                                    $event = 'Eliminar';
                                    break;
                                default:
                                    $event = '';
                                    break;
                            }
                        @endphp
                        <li>Evento: <span class="text-gray-500"> {{ $event }}</span></li>
                        @php
                            $tipo =
                                class_basename($auditoria->auditable_type) === 'Deposito'
                                    ? 'Garantia'
                                    : class_basename($auditoria->auditable_type);
                        @endphp
                        <li>Tipo:
                            <span class="text-gray-500"> {{ $tipo }}</span>
                        </li>
                        <li>Tipo ID:
                            <span class="text-gray-500"> {{ $auditoria->auditable_id }}
                            </span>
                        </li>
                        <li class="">Usario: <span class="text-gray-500"> {{ $auditoria->user->name }}
                                {{ $auditoria->user?->personal?->apellido }}</span></li>
                        <li>Fecha: <span class="text-gray-500"> {{ $auditoria->created_at }}</span></li>

                        <li class="flex flex-col text-gray-500">
                            <span class="text-center text-gray-700">
                                Antiguo:
                            </span>
                            @foreach ($auditoria->old_values as $key => $value)
                                @if ($key != 'id')
                                    <p>
                                        <span class=" text-gray-600">{{ ucfirst($key) }}:</span>
                                        {{ is_string($value) && \Carbon\Carbon::hasFormat($value, 'Y-m-d H:i:s') ? \Carbon\Carbon::parse($value)->format('d/m/Y H:i') : $value }}
                                    </p>
                                @endif
                            @endforeach
                        </li>

                        <li class="flex flex-col text-gray-500">
                            <span class="text-center text-gray-700">
                                Nuevo:
                            </span>
                            @foreach ($auditoria->new_values as $key => $value)
                                @if ($key != 'id')
                                    <p>
                                        <span class=" text-gray-600">{{ ucfirst($key) }}:</span>
                                        {{ is_string($value) && \Carbon\Carbon::hasFormat($value, 'Y-m-d H:i:s') ? \Carbon\Carbon::parse($value)->format('d/m/Y H:i') : $value }}
                                    </p>
                                @endif
                            @endforeach
                        </li>

                    </ul>
                @endif

                <div class="flex !flex-row gap-6 justify-center lg:text-base text-sm">
                    <button type="button"
                        class="bg-orange-600 hover:bg-orange-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 "
                        wire:click="$parent.$set('method',false)">
                        Salir
                    </button>

                    @if ($method == 'delete')
                        <button
                            class="bg-red-600 hover:bg-red-700 mt-4 rounded-lg px-2 lg:py-1 py-0.5 flex text-center items-center ">
                            {{ $btnText }}
                        </button>
                    @endif


                </div>

            </form>

        </div>
    </div>


</x-modal>
