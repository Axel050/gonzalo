<div class="min-h-screen overflow-y-auto  pb-4 pt-2  transition-all duration-500 border-sky-900   border-r-2 b-sky-950 bg-gradient-to-l from-cyan-800 to-cyan-950 z-10
 [&::-webkit-scrollbar]:w-2
  [&::-webkit-scrollbar-track]:bg-cyan-400
  [&::-webkit-scrollbar-thumb]:bg-cyan-700"
    :class="openSide ? 'lg:w-[260px] lg:min-w-[260px]  w-0  ' : 'w-[360px] lg:w-0 '" x-cloak>

    <a href="" class="w-full   g-green-200 flex justify-center  mb-20 mt-2">
        {{-- <img src="logo-dark.png" class="h-6" alt=""> --}}
        <h2 class="lg:text-2xl text-lg font-extrabold  w-full text-center p-0 text-white ">CASABLANCA.AR</h2>
    </a>


    @role('admin')
        {{-- CREO QUE DEBERIA VERIFICAR EL ROL QUE TENGA EL USUARIO ; NO  SOLO EL ADMIN ; SIN OEL QUE VENFA EN USER PARA VER SI ESTA active --}}
        {{-- @if (auth()->user()->hasActiveRole('admin'))
            <h1 class="text-white text-center">000xxx</h1>
        @endif --}}
    @endrole

    @role('super-admin')
        {{-- <h1 class="text-white text-center">xxxx</h1> --}}
    @endrole

    @can('unpublish lotes')
        {{-- <a  href="" class="w-full   g-green-200 flex justify-center  mb-16 mt-2">    
      <h2 class="text-2xl font-extrabold  w-full text-center p-0 text-white ">yyyyyyx</h2>
    </a> --}}
    @endcan

    @can(['delete lotes'])
        {{-- <a  href="" class="w-full   g-green-200 flex justify-center  mb-16 mt-2">
    
      <h2 class="text-2xl font-extrabold  w-full text-center p-0 text-white ">xxx</h2>
    </a> --}}
    @endcan




    <ul class="flex  flex-col px-4  mt-2 text-gray-100 lg:pl-6 pl-2  borde  [&>li]:cursor-pointer lg:text-base text-sm ">


        @can('dashboard-ver')
            <x-li-single :active="Request::is('dashboard')" route="dashboard">
                <svg fill="#fff" class="w-6 h-6 ">
                    <use xlink:href="#dashboard"></use>
                </svg>
                <span class="ml-1 ">Panel de control</span>
            </x-li-single>
        @endcan



        @can('personal-ver')
            <li class="hover:text-gray-200  items-center  mb-2" x-data="{ open: false }" @click="open = ! open"
                @click.outside="open = false">

                <button
                    class ="flex  justify-start items-center py-1  rounded-lg w-full pl-2 hover:bg-cyan-900 hover:shadow-md hover:shadow-cyan-700
                  {{-- {{ Request::is('usuarios','roles') ? 'bg-linear-to-l from-sky-300 to-sky-300/10  text-gray-200 font-bold' : '' }}  --}}
                  {{ Request::is('admin/usuarios', 'admin/roles') ? 'bg-linear-to-r from-cyan-700 to-cyan-950  text-gray-200 font-bold g-cyan-900' : '' }} 
                  "
                    :class="{ ' bg-gry-100 text-gray-200 ': open }">
                    <svg class="w-6 h-6 " fill="#fff">
                        <use xlink:href="#personal"></use>
                    </svg>

                    <span class="ml-2 lg:mr-8 ">Personal</span>
                    <svg class="ml-auto mr-2" fill="#fff" height="12px" width="12px" version="1.1" id="XMLID_287_"
                        viewBox="0 0 24 24" xml:space="preserve" :class="{ 'rotate-90': open }">
                        <g id="next">
                            <g>
                                <polygon points="6.8,23.7 5.4,22.3 15.7,12 5.4,1.7 6.8,0.3 18.5,12 		" />
                            </g>
                        </g>
                    </svg>

                </button>

                {{-- submenu --}}
                <ul class="flex flex-col  mt-1.5 border-l-4  border-cyan-800 ml-2 px-2 rounded-l-sm" x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">

                    <li
                        class="pl-6  mb-1.5 py-0.5 hover:text-gray-300 hover:shadow-xs hover:shadow-cyan-700 hover:bg-cyan-900 rounded-lg
                   {{ Request::is('admin/usuarios') ? 'bg-linear-to-r from-cyan-700 to-cyan-950  text-gray-200 font-bold ' : '' }} ">
                        <a href="{{ Route('admin.usuarios') }}" class=" w-full inline-block">Usuarios</a>
                    </li>

                    <li
                        class="pl-6  mb-1.5   py-0.5 hover:text-gray-300 hover:shadow-xs hover:shadow-cyan-700 hover:bg-cyan-900 rounded-lg
                    {{ Request::is('admin/roles') ? 'bg-linear-to-r from-cyan-700 to-cyan-950  text-gray-200 font-bold ' : '' }} ">
                        <a href="{{ Route('admin.roles') }}" class=" w-full inline-block"> Roles</a>
                    </li>


                </ul>

            </li>
        @endcan


        @can('subastas-ver')
            <x-li-single :active="Request::is('admin/subastas')" route="admin.subastas">
                <svg class="h-6 w-6">
                    <use xlink:href="#subastas"></use>
                </svg>
                <span class="ml-1 ">Subastas</span>
            </x-li-single>
        @endcan


        @can('comitentes-ver')
            <x-li-single :active="Request::is('admin/comitentes')" route="admin.comitentes">
                <svg class="h-6 w-6">
                    <use xlink:href="#comitentes"></use>
                </svg>
                <span class="ml-1 ">Comitentes</span>
            </x-li-single>
        @endcan

        @can('adquirentes-ver')
            <x-li-single :active="Request::is('admin/adquirentes')" route="admin.adquirentes">
                <svg class="size-6" fill="#fff">
                    <use xlink:href="#adquirentes"></use>
                </svg>
                <span class="ml-1 ">Adquirentes</span>
            </x-li-single>
        @endcan

        @can('adquirentes-ver')
            <x-li-single :active="Request::is('admin/garantias')" route="admin.garantias">
                <svg fill="#fff" class="size-6">
                    <use xlink:href="#garantias"></use>
                </svg>
                <span class="ml-1 ">Garantías</span>
            </x-li-single>
        @endcan

        @can('adquirentes-ver')
            <x-li-single :active="Request::is('admin/contratos')" route="admin.contratos">
                <svg class="size-6">
                    <use xlink:href="#contratos"></use>
                </svg>
                <span class="ml-1 ">Contratos</span>
            </x-li-single>
        @endcan





        @can('adquirentes-ver')
            <x-li-single :active="Request::is('admin/lotes')" route="admin.lotes">

                <svg class="size-6">
                    <use xlink:href="#lotes"></use>
                </svg>
                <span class="ml-1 ">Lotes</span>
            </x-li-single>
        @endcan









        {{--  -----------AUXILIARES --}}
        @can('auxiliares-ver')
            <div class="flex flex-col mt-16 border-t-2 border-cyan-800 pt-2" x-data="{ openAux: false }">
                <button
                    class="flex  items-center cursor-pointer   hover:text-white
              {{ Request::is('admin/aux/*') ? 'text-gray-50 ' : 'text-gray-300' }} "
                    @click="openAux = ! openAux">

                    <span class="text-lg mb-1 font-bold">Auxiliares</span>
                    <svg class="ml-auto mr-2" fill="#fff" height="12px" width="12px" version="1.1" id="XMLID_287_"
                        viewBox="0 0 24 24" xml:space="preserve" :class="{ 'rotate-90': openAux }">
                        <g id="next">
                            <g>
                                <polygon points="6.8,23.7 5.4,22.3 15.7,12 5.4,1.7 6.8,0.3 18.5,12 		" />
                            </g>
                        </g>
                    </svg>
                </button>

                <ul class="flex flex-col  mt-1.5 border-l-4  border-cyan-800 ml-1 px-2 rounded-l-sm" x-show="openAux"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4">

                    <x-li-single-aux :active="Request::is('admin/aux/condicion-iva')" route="admin.condicon-iva">
                        - Condicion iva
                    </x-li-single-aux>

                    <x-li-single-aux :active="Request::is('admin/aux/estado-adquirentes')" route="admin.estado-adq">
                        - Estado adquirentes
                    </x-li-single-aux>

                    <x-li-single-aux :active="Request::is('admin/aux/tipo-bien')" route="admin.tipo-bien">
                        - Tipo bienes
                    </x-li-single-aux>

                    <x-li-single-aux :active="Request::is('admin/aux/caracteristicas')" route="admin.caracteristicas">
                        - Caracteristicas
                    </x-li-single-aux>

                    <x-li-single-aux :active="Request::is('admin/aux/monedas')" route="admin.monedas">
                        - Monedas
                    </x-li-single-aux>

                    <x-li-single-aux :active="Request::is('admin/aux/estado-lotes')" route="admin.estado-lotes">
                        - Estado lotes
                    </x-li-single-aux>


                </ul>


            </div>
        @endcan


</div>
