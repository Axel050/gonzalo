<div class="bg-gay-50 w-full z-10 fullscreen py-5">
    <x-action-message on="adquirenteCreated" class="  absolute    top-0 right-0 z-50 shadow-lg green-action"> Adquirente
        creado con exitó.</x-action-message>
    <x-action-message on="adquirenteUpdated" class="  absolute    top-0 right-0 z-50 shadow-lg orange-action">Adquirente
        actualizado con exitó.</x-action-message>
    <x-action-message on="adquirenteDeleted" class="  absolute    top-0 right-0 z-50 shadow-lg red-action">Adquirente
        eliminado con exitó.</x-action-message>

    <x-action-message on="autorizadoCreated" class="  absolute   top-0 right-0 z-50 yellow-action">Autorizado agregado con
        exitó.</x-action-message>


    <div class="">
        <div
            class="w-full flex item-center justify-between order-4  lg:flex-row lg:items-center  mx-auto bg-gray-300 lg:py-4  py-2 lg:px-6 px-3 rounded-md  shadow-md">
            <div class="flex flex-col lg:flex-row lg:gap-4  text-gray-700">
                <div>
                    <label for="query" class="text-sm lg:text-base text-gray-600 ">Buscar</label>
                    <input type="{{ $inputType }}" nombre="query" wire:model.live="query"
                        class="lg:h-7 h-6 rounded-md border border-gray-400 w-40 lg:w-48 bg-gray-100">
                </div>

                <div class="text-xs flex gap-2 lg:gap-3 ">
                    <select wire:model.live="searchType"
                        class="lg:h-7 h-6 rounded-md border border-gray-400 lg:w-full w-fit ml-auto mt-1 lg:mt-0 text-gray-500 text-sm py-0.5 cursor-pointer">
                        <option value="todos">Todos</option>
                        <option value="id">ID</option>
                        <option value="nombre">Nombre</option>
                        <option value="apellido">Apellido</option>
                        <option value="mail">Mail</option>
                        <option value="CUIT">CUIT</option>
                        <option value="telefono">Telefono</option>
                        <option value="alias">Alias</option>
                    </select>
                </div>

            </div>


            <button
                class="border border-white hover:text-gray-200 hover:bg-green-700 bg-green-500 px-2 py-0.5 rounded-lg text-white text-sm h-7 place-self-center flex items-center gap-x-2 cursor-pointer"
                wire:click="option('save')" title="Agregar comitente">

                <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    stroke="#ffffff">
                    <g id="SVGRepo_bgCarrier" stroke-width="0" />
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" />
                    <g id="SVGRepo_iconCarrier">
                        <path d="M7 12L12 12M12 12L17 12M12 12V7M12 12L12 17" stroke="#ffffff" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="12" cy="12" r="9" stroke="#ffffff" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </g>
                </svg>
                <span class="">
                    Agregar
                </span>
            </button>


        </div>


        @if ($method)
            @if ($method != 'autorizados')
                @livewire('admin.adquirentes.modal', ['method' => $method, 'id' => $id])
            @else
                @livewire('admin.adquirentes.modal-autorizados', ['id' => $id])
            @endif
        @endif



        <div class="overflow-x-auto bg-gray-200 m-4 border-2 border-gray-600  mx-auto rounded-md  shadow-md relative">



            {{-- <x-action-message on="comitenteNotExits" class="bg-blue-500  border-blue-700 absolute left-0 z-10" >Barrio inexistente.</x-action-message>  --}}


            <div class="min-w-full inline-block align-middle ">
                <div class="overflow-hidden">

                    @if (count($adquirentes))



                        <table class="min-w-full divide-y  divide-gray-600 ">
                            <thead>



                                <tr
                                    class="bg-gray-400 relative text-gray-700 font-bold divide-x-2 divide-gray-600 [&>th]:pl-2 [&>th]:pr-1 [&>th]:lg:pl-4 [&>th]:text-start text-sm ">


                                    <th scope="col" class="py-1">ID</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">CUIT</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Alias</th>
                                    {{-- <th scope="col" >Estado</th> --}}
                                    <th scope="col">Lotes</th>


                                    <th scope="col" class="lg:w-[190px] w-[90px]">Accion</th>

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-400 text-gray-600  text-sm bg-gray-300">

                                @foreach ($adquirentes as $comitente)
                                    <tr
                                        class="divide-x-2 divide-y-2 divide-gray-400 [&>td]:pl-2 [&>td]:pr-1 [&>td]:lg:pl-4 [&>td]:text-start ">


                                        <td class="py-2">{{ $comitente->id }}</td>
                                        <td class="py-2">{{ $comitente->nombre }}, {{ $comitente->apellido }}</td>
                                        <td class="py-2">{{ $comitente->telefono }}</td>
                                        <td class="py-2">{{ $comitente->CUIT }}</td>
                                        <td class="py-2">{{ $comitente->user?->email }}</td>
                                        <td class="py-2">{{ $comitente->alias }}</td>

                                        {{-- <td class="py-2">{{\Carbon\Carbon::parse($comitente->fecha_fin)->format('Y-m-d H:i') }}</td> --}}
                                        {{-- <td class="py-2 font-semibold {{$comitente->estado ? "text-green-600" : "text-red-600"}}">{{$comitente->estado ? "On" : "Off"}}</td> --}}
                                        <td class="py-2">
                                            {{-- <button class="bg-cyan-900 text-white px-4 rounded-2xl cursor-pointer py-0.5 hover:bg-cyan-950" --}}
                                            <button
                                                class="bg-cyan-900 text-white px-4 rounded-2xl cursor-pointer py-0.5 hover:bg-cyan-950"
                                                title="Ver lotes"> {{ $comitente->lotes?->count() }}</button>

                                        </td>





                                        <td>
                                            <div class="flex justfy-end lg:gap-x-6 gap-x-4 text-white text-xs">


                                                <button
                                                    class=" hover:text-gray-200  hover:bg-yellow-900 flex items-center py-0.5 bg-yellow-800 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('autorizados',{{ $comitente->id }})"
                                                    title="Ver autorizados">
                                                    <svg width="20px" height="18px" fill="none"
                                                        viewBox="0 0 512 512" xml:space="preserve">
                                                        <g>
                                                            <path class="st0"
                                                                d="M48.335,490.794c0.016-19.684,4.754-35.814,12.292-49.534c11.288-20.533,29.242-35.692,47.474-46.686
                                                                      c18.217-10.994,36.453-17.692,47.818-21.697c8.954-3.168,19.354-7.755,28.211-13.902c4.429-3.093,8.506-6.577,11.782-10.871
                                                                      c3.234-4.241,5.773-9.623,5.777-15.825c0-9.149,0-20.579,0-36.258v-0.505l-0.054-0.506c-0.532-4.9-2.48-8.766-4.444-12.096
                                                                      c-3.013-5.023-6.4-9.394-9.497-15.059c-3.086-5.643-5.96-12.456-7.667-22.049l-0.992-5.604l-5.359-1.914
                                                                      c-2.45-0.88-4.203-1.73-5.68-2.756c-2.174-1.546-4.188-3.613-6.744-8.368c-2.519-4.723-5.287-11.996-8.323-22.669
                                                                      c-1.305-4.555-1.741-8-1.741-10.442c0.076-4.196,1.006-5.183,1.515-5.819c0.544-0.612,1.512-1.079,2.588-1.317l8.521-1.906
                                                                      l-0.915-8.682c-2.01-19.048-4.792-46.532-4.792-73.734c-0.008-18.382,1.297-36.626,4.777-51.685
                                                                      c2.886-12.717,7.415-22.822,13.049-29.253c9.053,2.066,17.436,2.817,25.268,2.81c13.815-0.03,25.88-1.884,39.167-1.853h0.314
                                                                      l0.333-0.015c4.98-0.306,9.436-0.452,13.435-0.452c12.755,0.007,20.705,1.462,27.16,3.95c6.446,2.488,11.966,6.278,19.43,12.089
                                                                      l1.922,1.492l2.393,0.421c8.754,1.569,15.238,4.686,20.471,8.919c7.798,6.323,13.05,15.656,16.361,27.232
                                                                      c3.3,11.53,4.502,25.05,4.49,38.486c0.004,11.316-0.823,22.569-1.776,32.621c-0.954,10.061-2.025,18.849-2.499,25.702l-0.004,0.007
                                                                      c-0.084,1.218-0.191,2.266-0.314,3.446l-0.87,8.352l8.12,2.136c1.037,0.275,1.856,0.72,2.373,1.332
                                                                      c0.49,0.636,1.374,1.738,1.435,5.735c0,2.442-0.437,5.887-1.734,10.427c-4.038,14.248-7.656,22.378-10.729,26.612
                                                                      c-1.543,2.136-2.868,3.384-4.345,4.425c-1.478,1.026-3.232,1.876-5.681,2.756l-5.358,1.914l-0.992,5.604
                                                                      c-1.167,6.606-2.572,11.369-4.054,15.105c-2.236,5.589-4.636,9.049-7.728,13.62c-3.063,4.509-6.753,10.121-9.635,18.168
                                                                      l-0.582,1.608v1.714c0,15.679,0,27.109,0,36.258c-0.011,5.719,2.128,10.895,5.049,15.006c4.433,6.209,10.523,10.733,17.142,14.691
                                                                      c6.634,3.92,13.902,7.15,20.87,9.861l7.097-18.266c-8.41-3.246-17.011-7.358-22.822-11.622c-2.909-2.105-5.072-4.234-6.263-5.949
                                                                      c-1.214-1.761-1.462-2.832-1.474-3.721c0-8.743,0-19.675,0-34.305c1.264-3.193,2.584-5.796,4.078-8.215
                                                                      c2.526-4.15,5.89-8.344,9.267-14.653c2.802-5.26,5.302-11.882,7.234-20.548c1.7-0.827,3.396-1.784,5.05-2.94
                                                                      c5.068-3.499,9.355-8.598,12.862-15.266c3.545-6.699,6.604-15.098,9.865-26.474c1.677-5.91,2.48-11.094,2.484-15.809
                                                                      c0.057-7.579-2.312-14.148-6.232-18.582c-1.366-1.569-2.844-2.756-4.33-3.782c0.494-5.834,1.386-13.574,2.232-22.5
                                                                      c0.98-10.358,1.864-22.202,1.864-34.467c-0.038-19.408-2.106-39.902-10.316-57.587c-4.115-8.82-9.888-16.934-17.769-23.342
                                                                      c-7.262-5.918-16.33-10.16-26.849-12.395c-7.139-5.474-14.052-10.267-22.669-13.597c-9.302-3.605-20.04-5.274-34.222-5.266
                                                                      c-4.478,0-9.32,0.16-14.622,0.482C225.025,3.1,212.902,4.9,201.2,4.869c-8.169-0.008-16.223-0.789-25.559-3.446L170.638,0
                                                                      l-3.985,3.338c-12.26,10.412-18.841,25.93-22.868,43.171c-3.977,17.318-5.267,36.786-5.278,56.087
                                                                      c0.004,25.188,2.255,50.069,4.168,68.742c-1.458,0.949-2.909,2.044-4.284,3.506c-4.226,4.426-6.874,11.27-6.802,19.209
                                                                      c0.003,4.716,0.808,9.915,2.492,15.825c4.356,15.151,8.295,25.08,13.624,32.614c2.657,3.744,5.742,6.806,9.095,9.126
                                                                      c1.646,1.148,3.33,2.098,5.022,2.924c3.035,12.969,8.146,22.37,12.528,29.176c2.466,3.851,4.643,6.913,5.991,9.202
                                                                      c1.29,2.144,1.673,3.369,1.75,3.928c0,15.228,0,26.451,0,35.431c0.003,0.713-0.276,1.968-1.792,3.982
                                                                      c-2.196,2.978-6.99,6.775-12.735,9.991c-5.734,3.269-12.36,6.102-18.16,8.146c-15.614,5.528-45.238,16.315-71.467,37.315
                                                                      c-13.114,10.511-25.426,23.664-34.478,40.094c-9.057,16.414-14.742,36.104-14.723,58.988c0,3.973,0.169,8.054,0.517,12.226
                                                                      l0.751,8.98h320.684v-19.599H48.404C48.396,491.874,48.335,491.314,48.335,490.794z" />
                                                            <path class="st0"
                                                                d="M412.708,361.088c-38.968,0-70.556,31.588-70.556,70.556c0,38.968,31.588,70.556,70.556,70.556
                                                                      c38.968,0,70.556-31.588,70.556-70.556C483.264,392.676,451.676,361.088,412.708,361.088z M451.906,441.444h-29.398v29.398h-19.599
                                                                      v-29.398H373.51v-19.599h29.398v-29.399h19.599v29.399h29.398V441.444z" />
                                                        </g>
                                                    </svg>
                                                    <span class="hidden lg:block">Autorizados</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-green-900 flex items-center py-0.5 bg-green-800 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('view',{{ $comitente->id }})"
                                                    title="Ver comitente">
                                                    <svg width="20px" height="19px" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z"
                                                            stroke="#fff" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <path
                                                            d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z"
                                                            stroke="#fff" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                    <span class="hidden lg:block">Ver</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200  hover:bg-red-700 flex items-center py-0.5 bg-red-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('delete',{{ $comitente->id }})">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <g id="SVGRepo_bgCarrier" stroke-width="0" />
                                                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                        <g id="SVGRepo_iconCarrier">
                                                            <path
                                                                d="M6 7V18C6 19.1046 6.89543 20 8 20H16C17.1046 20 18 19.1046 18 18V7M6 7H5M6 7H8M18 7H19M18 7H16M10 11V16M14 11V16M8 7V5C8 3.89543 8.89543 3 10 3H14C15.1046 3 16 3.89543 16 5V7M8 7H16"
                                                                stroke="#ffffff" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round" />
                                                        </g>
                                                    </svg>
                                                    <span class="hidden lg:block">Eliminar</span>
                                                </button>

                                                <button
                                                    class=" hover:text-gray-200 hover:bg-orange-700 flex items-center py-0.5 bg-orange-600 rounded-lg px-1 cursor-pointer"
                                                    wire:click="option('update',{{ $comitente->id }})">
                                                    <svg width="20px" height="20px" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                            d="M21.1213 2.70705C19.9497 1.53548 18.0503 1.53547 16.8787 2.70705L15.1989 4.38685L7.29289 12.2928C7.16473 12.421 7.07382 12.5816 7.02986 12.7574L6.02986 16.7574C5.94466 17.0982 6.04451 17.4587 6.29289 17.707C6.54127 17.9554 6.90176 18.0553 7.24254 17.9701L11.2425 16.9701C11.4184 16.9261 11.5789 16.8352 11.7071 16.707L19.5556 8.85857L21.2929 7.12126C22.4645 5.94969 22.4645 4.05019 21.2929 2.87862L21.1213 2.70705ZM18.2929 4.12126C18.6834 3.73074 19.3166 3.73074 19.7071 4.12126L19.8787 4.29283C20.2692 4.68336 20.2692 5.31653 19.8787 5.70705L18.8622 6.72357L17.3068 5.10738L18.2929 4.12126ZM15.8923 6.52185L17.4477 8.13804L10.4888 15.097L8.37437 15.6256L8.90296 13.5112L15.8923 6.52185ZM4 7.99994C4 7.44766 4.44772 6.99994 5 6.99994H10C10.5523 6.99994 11 6.55223 11 5.99994C11 5.44766 10.5523 4.99994 10 4.99994H5C3.34315 4.99994 2 6.34309 2 7.99994V18.9999C2 20.6568 3.34315 21.9999 5 21.9999H16C17.6569 21.9999 19 20.6568 19 18.9999V13.9999C19 13.4477 18.5523 12.9999 18 12.9999C17.4477 12.9999 17 13.4477 17 13.9999V18.9999C17 19.5522 16.5523 19.9999 16 19.9999H5C4.44772 19.9999 4 19.5522 4 18.9999V7.99994Z"
                                                            fill="#ffffff" />
                                                    </svg>
                                                    <span class="hidden lg:block">Editar</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    @else
                        <h3 class="w-full text-center py-8 px-3 rounded-md text-xl">¡Sin resultados para
                            "<strong>{{ $query }}</strong>"!</h3>
                    @endif
                </div>

            </div>
        </div>
        @if (count($adquirentes))
            <div class="w-full  justify-between  lg:w-[75%]  mx-auto px-2 ">
                {{ $adquirentes->links() }}
            </div>
        @endif
    </div>

</div> <!-- end card -->



</div>
