<div class=" min-h-screen overflow-y-auto  pt-4  transition-all duration-500 border-sky-900   border-r-2 b-sky-950 bg-gradient-to-l from-cyan-800 to-cyan-950"  
    :class="openSide? 'lg:w-[260px] lg:min-w-[260px]  w-0  ' : 'w-[360px] lg:w-0 '  "         
    x-cloak
        >  

    <a  href="" class="w-full   g-green-200 flex justify-center  mb-16 mt-2">
        {{-- <img src="logo-dark.png" class="h-6" alt=""> --}}
        <h2 class="text-2xl font-extrabold  w-full text-center p-0 text-white ">CASABLANCA.AR</h2>
    </a>


    @can("unpublish lotes")
            
    {{-- <a  href="" class="w-full   g-green-200 flex justify-center  mb-16 mt-2">    
      <h2 class="text-2xl font-extrabold  w-full text-center p-0 text-white ">yyyyyyx</h2>
    </a> --}}
    @endcan

    @can(["delete lotes"])
        
    {{-- <a  href="" class="w-full   g-green-200 flex justify-center  mb-16 mt-2">
    
      <h2 class="text-2xl font-extrabold  w-full text-center p-0 text-white ">xxx</h2>
    </a> --}}
    @endcan

    


      <ul class="flex  flex-col px-4  mt-2 text-gray-100 lg:pl-6 pl-2  borde  [&>li]:cursor-pointer lg:text-base text-sm ">        


    <x-li-single  :active="Request::is('dashboard')" route="dashboard">
              <svg fill="#fff" class="w-6 h-6 " viewBox="0 0 1920 1920" xmlns="http://www.w3.org/2000/svg" stroke="#fff">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                    <g id="SVGRepo_iconCarrier"> <path d="M833.935 1063.327c28.913 170.315 64.038 348.198 83.464 384.79 27.557 51.84 92.047 71.944 144 44.387 51.84-27.558 71.717-92.273 44.16-144.113-19.426-36.593-146.937-165.46-271.624-285.064Zm-43.821-196.405c61.553 56.923 370.899 344.81 415.285 428.612 56.696 106.842 15.811 239.887-91.144 296.697-32.64 17.28-67.765 25.411-102.325 25.411-78.72 0-154.955-42.353-194.371-116.555-44.386-83.802-109.102-501.346-121.638-584.245-3.501-23.717 8.245-47.21 29.365-58.277 21.346-11.294 47.096-8.02 64.828 8.357ZM960.045 281.99c529.355 0 960 430.757 960 960 0 77.139-8.922 153.148-26.654 225.882l-10.39 43.144h-524.386v-112.942h434.258c9.487-50.71 14.231-103.115 14.231-156.084 0-467.125-380.047-847.06-847.059-847.06-467.125 0-847.059 379.935-847.059 847.06 0 52.97 4.744 105.374 14.118 156.084h487.454v112.942H36.977l-10.39-43.144C8.966 1395.137.044 1319.128.044 1241.99c0-529.243 430.645-960 960-960Zm542.547 390.686 79.85 79.85-112.716 112.715-79.85-79.85 112.716-112.715Zm-1085.184 0L530.123 785.39l-79.85 79.85L337.56 752.524l79.849-79.85Zm599.063-201.363v159.473H903.529V471.312h112.942Z" fill-rule="evenodd"/> </g>
              </svg>      
                <span class="ml-1 ">Panel de control</span>
    </x-li-single>
        


              
            <li class="hover:text-gray-200  items-center  mb-2"  
                 x-data="{open:false}"    @click="open = ! open"  @click.outside="open = false"  >

                <button  class ="flex  justify-start items-center py-1  rounded-lg w-full pl-2 hover:bg-cyan-900 hover:shadow-md hover:shadow-cyan-700
                  {{-- {{ Request::is('usuarios','roles') ? 'bg-linear-to-l from-sky-300 to-sky-300/10  text-gray-200 font-bold' : '' }}  --}}
                  {{ Request::is('usuarios','roles') ? 'bg-linear-to-r from-cyan-700 to-cyan-950  text-gray-200 font-bold g-cyan-900' : '' }} 
                  "            
                  :class="{ ' bg-gry-100 text-gray-200 ': open }" 
                  >
                      <svg fill="#fff" class="w-6 h-6 " version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 20 26" enable-background="new 0 0 24 24" xml:space="preserve" stroke="#fff">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                            <g id="SVGRepo_iconCarrier"> <g id="user-admin"> <path d="M22.3,16.7l1.4-1.4L20,11.6l-5.8,5.8c-0.5-0.3-1.1-0.4-1.7-0.4C10.6,17,9,18.6,9,20.5s1.6,3.5,3.5,3.5s3.5-1.6,3.5-3.5 c0-0.6-0.2-1.2-0.4-1.7l1.9-1.9l2.3,2.3l1.4-1.4l-2.3-2.3l1.1-1.1L22.3,16.7z M12.5,22c-0.8,0-1.5-0.7-1.5-1.5s0.7-1.5,1.5-1.5 s1.5,0.7,1.5,1.5S13.3,22,12.5,22z"/> <path d="M2,19c0-3.9,3.1-7,7-7c2,0,3.9,0.9,5.3,2.4l1.5-1.3c-0.9-1-1.9-1.8-3.1-2.3C14.1,9.7,15,7.9,15,6c0-3.3-2.7-6-6-6 S3,2.7,3,6c0,1.9,0.9,3.7,2.4,4.8C2.2,12.2,0,15.3,0,19v5h8v-2H2V19z M5,6c0-2.2,1.8-4,4-4s4,1.8,4,4s-1.8,4-4,4S5,8.2,5,6z"/> </g> </g>
                      </svg>
                                      
                      <span class="ml-2 lg:mr-8 ">Usuarios</span>                
                      <svg  class="ml-auto mr-2" fill="#fff" height="12px" width="12px" version="1.1"  id="XMLID_287_"  viewBox="0 0 24 24"        xml:space="preserve" 
                        :class="{ 'rotate-90': open }" >
                        <g id="next">
                          <g>
                            <polygon points="6.8,23.7 5.4,22.3 15.7,12 5.4,1.7 6.8,0.3 18.5,12 		"/>
                          </g>
                        </g>
                      </svg>

                 </button>
  
            {{-- submenu --}}
            <ul class="flex flex-col  mt-1.5 border-l-4  border-cyan-800 ml-2 px-2 rounded-l-sm" x-show="open" >  

                 <li class="pl-6  mb-1.5 py-0.5 hover:text-gray-300 hover:shadow-xs hover:shadow-cyan-700 hover:bg-cyan-900 rounded-lg
                   {{ Request::is('users') ? 'bg-linear-to-r from-cyan-700 to-cyan-950  text-gray-200 font-bold '  : '' }} " >
                   <a href="" class=" w-full inline-block">Usuarios</a>
                </li>

                <li class="pl-6  mb-1.5   py-0.5 hover:text-gray-300 hover:shadow-xs hover:shadow-cyan-700 hover:bg-cyan-900 rounded-lg
                    {{ Request::is('roles') ? 'bg-linear-to-r from-cyan-700 to-cyan-950  text-gray-200 font-bold '  : '' }} " 
                     >
                  <a  href="" class=" w-full inline-block"> Roles</a>              
                </li>
                                
                
             </ul>                                     
             
           </li>


            <x-li-single  :active="Request::is('admin/subastas')"  route="admin.subastas" >            
                  <svg class="h-6 w-6" version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 482 482"     xml:space="preserve" fill="#ffffff" stroke="#ffffff">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <style type="text/css"> .st0{fill:#ffffff;} </style> <g> <path class="st0" d="M215.402,437.214H26.364C11.797,437.214,0,449.011,0,463.571v29.428h241.749v-29.428 C241.749,449.011,229.953,437.214,215.402,437.214z"></path> <path class="st0" d="M204.557,406.227c0-14.559-11.797-26.356-26.356-26.356H63.549c-14.558,0-26.356,11.797-26.356,26.356v17.034 h167.364V406.227z"></path> <path class="st0" d="M129.388,311.01c51.39,44.821,74.125,55.052,89.5,41.664c15.376-13.388-5.583-24.722,10.812-43.508 l-112.118-97.786c-16.385,18.786-30.465-0.429-41.639,16.622C64.762,245.053,77.998,266.196,129.388,311.01z"></path> <path class="st0" d="M354.76,165.758c16.395-18.794,30.465,0.438,41.647-16.622c11.174-17.052-2.063-38.187-53.453-83.009 c-51.398-44.814-74.124-55.053-89.508-41.664c-15.376,13.38,5.591,24.714-10.803,43.508L354.76,165.758z"></path> <polygon class="st0" points="344.175,177.9 232.058,80.106 128.167,199.246 240.284,297.032 "></polygon> <path class="st0" d="M498.723,366.146c-10.223-8.925-23.812-11.502-35.972-8.092c7.343-20.419-16.2-28.646-43.264-49.587 c-33.816-26.162-90.662-72.399-99.074-79.742l-33,37.85c8.412,7.317,61.958,57.368,92.465,87.302 c24.428,23.965,35.787,46.169,55.011,36.123c-1.726,12.504,2.686,25.623,12.908,34.541c16.125,14.07,40.595,12.386,54.666-3.739 C516.516,404.678,514.848,380.209,498.723,366.146z"></path> </g> </g>
                  </svg>                
                 <span class="ml-1 ">Subastas</span>
            </x-li-single>


            <x-li-single  :active="Request::is('admin/comitentes')"  route="admin.comitentes" >            
                  <svg class="h-6 w-6" version="1.1" id="_x32_"  viewBox="0 0 282.931 282.931"   xml:space="preserve" fill="#ffffff" stroke="#ffffff">	 	                 
                            <g>
                              <g>
                                <path d="M16.154,154.083c0.125-1.427,0.041-2.88,0.041-4.316c0.005-14.77-0.041-29.544,0.084-44.311
                                  c0.01-1.27,1.112-2.526,1.706-3.791c0.779,1.295,1.757,2.511,2.277,3.905c0.353,0.947,0.074,2.138,0.074,3.22
                                  c0,43.77-0.013,87.531,0.005,131.304c0,7.708,3.593,12.212,9.717,12.339c6.489,0.127,10.135-4.266,10.161-12.431
                                  c0.043-12.608,0.01-25.212,0.005-37.82c0-12.07-0.079-24.141,0.094-36.206c0.021-1.463,1.384-2.915,2.128-4.377
                                  c0.635,0.254,1.262,0.508,1.896,0.771c0,2.133,0,4.266,0,6.398c0,24.13,0.015,48.266-0.016,72.401
                                  c-0.005,4.51,1.341,8.79,5.741,9.974c3.224,0.873,7.977,0.68,10.354-1.188c2.453-1.935,3.981-6.459,3.999-9.861
                                  c0.249-44.306,0.16-88.611,0.15-132.916c0-0.716-0.272-1.523-0.031-2.143c0.447-1.163,1.173-2.219,1.788-3.321
                                  c0.681,1.013,1.767,1.955,1.955,3.057c0.333,1.925,0.125,3.945,0.125,5.921c-0.005,13.688-0.061,27.378-0.005,41.065
                                  c0.028,6.516,2.902,9.983,8.018,10.039c5.258,0.066,8.033-3.255,8.046-9.82c0.025-21.795,0.056-43.587-0.018-65.379
                                  c-0.035-10.796-6.269-16.95-17.194-17.004c-16.392-0.084-32.776-0.073-49.165-0.025C6.28,69.603,0.098,75.796,0.065,87.549
                                  c-0.041,16.389-0.016,32.78-0.01,49.17c0,5.761-0.165,11.534,0.079,17.288c0.198,4.723,3.593,7.795,7.978,7.805
                                  C12.546,161.816,15.753,158.774,16.154,154.083z"/>
                                <path d="M58.383,46.684c0.066-8.97-7.071-16.199-16-16.188c-8.948,0.005-16.25,7.259-16.187,16.084
                                  c0.056,8.63,7.17,15.75,15.828,15.844C51.19,62.517,58.314,55.664,58.383,46.684z"/>
                                <path d="M99.71,87.543c-0.041,16.389-0.01,32.781-0.01,49.17c0,5.761-0.165,11.529,0.079,17.287
                                  c0.203,4.723,3.593,7.795,7.978,7.806c4.441,0.01,7.647-3.026,8.049-7.724c0.125-1.427,0.041-2.88,0.041-4.316
                                  c0.005-14.77-0.041-29.544,0.084-44.311c0.01-1.27,1.106-2.526,1.706-3.791c0.779,1.295,1.757,2.511,2.277,3.905
                                  c0.353,0.947,0.066,2.138,0.066,3.22c0,43.77-0.01,87.531,0.005,131.304c0,7.708,3.595,12.212,9.719,12.339
                                  c6.49,0.127,10.135-4.266,10.161-12.431c0.041-12.608,0.005-25.212,0.005-37.82c0-12.07-0.079-24.141,0.094-36.206
                                  c0.021-1.463,1.384-2.915,2.128-4.377c0.632,0.254,1.262,0.508,1.896,0.771c0,2.133,0,4.266,0,6.398
                                  c0,24.13,0.015,48.266-0.015,72.401c-0.005,4.51,1.341,8.79,5.743,9.974c3.225,0.873,7.978,0.68,10.349-1.188
                                  c2.458-1.935,3.986-6.459,4.002-9.861c0.249-44.306,0.162-88.611,0.152-132.916c0-0.716-0.274-1.523-0.036-2.143
                                  c0.452-1.163,1.179-2.219,1.793-3.321c0.681,1.013,1.767,1.955,1.955,3.057c0.33,1.925,0.122,3.945,0.122,5.921
                                  c-0.006,13.688-0.062,27.378-0.006,41.065c0.025,6.516,2.905,9.983,8.019,10.039c5.261,0.066,8.033-3.255,8.043-9.82
                                  c0.031-21.795,0.057-43.587-0.015-65.379c-0.036-10.796-6.271-16.95-17.194-17.004c-16.392-0.084-32.775-0.073-49.165-0.025
                                  C105.925,69.598,99.738,75.791,99.71,87.543z"/>
                                <path d="M158.033,46.684c0.066-8.97-7.073-16.199-16-16.188c-8.95,0.005-16.25,7.259-16.186,16.084
                                  c0.056,8.63,7.17,15.75,15.828,15.844C150.842,62.517,157.967,55.664,158.033,46.684z"/>
                                <path d="M265.691,69.588c-16.392-0.084-32.773-0.074-49.165-0.025c-11.806,0.035-17.991,6.228-18.021,17.981
                                  c-0.041,16.389-0.01,32.781-0.01,49.17c0,5.761-0.168,11.529,0.076,17.287c0.203,4.723,3.595,7.795,7.978,7.806
                                  c4.442,0.01,7.647-3.026,8.048-7.724c0.127-1.427,0.041-2.88,0.041-4.316c0.005-14.77-0.041-29.544,0.086-44.311
                                  c0.011-1.27,1.107-2.526,1.707-3.791c0.776,1.295,1.757,2.511,2.274,3.905c0.355,0.947,0.066,2.138,0.066,3.22
                                  c0,43.77-0.011,87.531,0.005,131.304c0,7.708,3.595,12.212,9.719,12.339c6.49,0.127,10.136-4.266,10.161-12.431
                                  c0.041-12.608,0.005-25.212,0.005-37.82c0-12.07-0.076-24.141,0.097-36.206c0.021-1.463,1.382-2.915,2.123-4.377
                                  c0.635,0.254,1.265,0.508,1.899,0.771c0,2.133,0,4.266,0,6.398c0,24.13,0.015,48.266-0.016,72.401
                                  c-0.005,4.51,1.341,8.79,5.743,9.974c3.225,0.873,7.973,0.68,10.349-1.188c2.458-1.935,3.986-6.459,4.002-9.861
                                  c0.248-44.306,0.162-88.611,0.152-132.916c0-0.716-0.274-1.523-0.036-2.143c0.452-1.163,1.179-2.219,1.793-3.321
                                  c0.681,1.013,1.767,1.955,1.955,3.057c0.33,1.925,0.122,3.945,0.122,5.921c-0.006,13.688-0.062,27.378-0.006,41.065
                                  c0.025,6.516,2.905,9.983,8.019,10.039c5.261,0.066,8.033-3.255,8.044-9.82c0.03-21.795,0.056-43.587-0.016-65.379
                                  C282.855,75.796,276.619,69.641,265.691,69.588z"/>
                                <path d="M256.831,46.684c0.065-8.97-7.074-16.199-16.001-16.188c-8.947,0.005-16.25,7.259-16.184,16.084
                                  c0.056,8.63,7.17,15.75,15.828,15.844C249.639,62.517,256.764,55.664,256.831,46.684z"/>
                              </g>
                            </g>
                  </svg>
                 <span class="ml-1 ">Comitentes</span>
            </x-li-single>
            
            <x-li-single  :active="Request::is('admin/adquirentes')"  route="admin.adquirentes" >                              
                <svg class="size-6" fill="#fff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                    viewBox="0 0 31.662 31.662" xml:space="preserve">
                    <g>
                      <g>
                        <path d="M13.193,13.308h4.496c0.23-1.27,0.906-2.364,1.863-3.159c0.004,0,0.009,0,0.015,0c0.797-0.027,1.836-0.237,2.821-0.966
                          c0.121-0.089,0.238-0.185,0.351-0.284c1.412-1.252,2.187-3.332,2.292-6.192c0.025-0.758-0.564-1.396-1.32-1.425
                          c-0.826-0.042-1.396,0.562-1.425,1.322c-0.084,2.161-0.602,3.664-1.506,4.349c-0.196,0.151-0.405,0.254-0.606,0.323
                          c-0.006,0.002-0.015,0.003-0.021,0.005c-0.595-0.568-1.418-0.845-1.974-0.845h-3.398h-3.397c-1.246,0-2.237,1.251-2.259,2.624
                          C11.201,9.567,12.811,11.246,13.193,13.308z"/>
                        <ellipse cx="14.78" cy="3.195" rx="3.261" ry="3.195"/>
                        <path d="M14.359,21.546c0-2.479-1.068-3.526-2.55-3.526h-0.081H8.373c1.854-0.271,3.275-1.834,3.275-3.728
                          c0-2.08-1.72-3.768-3.847-3.768c-2.123,0-3.844,1.688-3.844,3.768c0,1.894,1.421,3.456,3.276,3.728H3.877H3.795
                          c-1.484,0-2.688,1.588-2.688,3.229v5.02h13.252V21.546z"/>
                        <path d="M19.101,14.292c0,1.894,1.422,3.456,3.274,3.728h-3.22h-0.219c-1.485,0-2.618,1.588-2.618,3.229v5.02h13.15v-4.72
                          c0-2.45-1.029-3.481-2.481-3.506c-0.021,0-0.019-0.021-0.037-0.021h-3.438c1.855-0.271,3.277-1.834,3.277-3.729
                          c0-2.08-1.722-3.768-3.846-3.768C20.821,10.524,19.101,12.212,19.101,14.292z"/>
                        <rect x="0.029" y="28.423" width="31.604" height="3.239"/>
                      </g>
                    </g>
                </svg>
                 <span class="ml-1 ">Adquirentes</span>
            </x-li-single>


            {{-- <x-li-single  :active="Request::is('comitentes')"  route="comitentes" >            
                  <svg class="h-6 w-6" fill="#fff" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	                 viewBox="0 0 31.662 31.662" xml:space="preserve">
                      <g>
                        <g>
                          <path d="M13.193,13.308h4.496c0.23-1.27,0.906-2.364,1.863-3.159c0.004,0,0.009,0,0.015,0c0.797-0.027,1.836-0.237,2.821-0.966
                            c0.121-0.089,0.238-0.185,0.351-0.284c1.412-1.252,2.187-3.332,2.292-6.192c0.025-0.758-0.564-1.396-1.32-1.425
                            c-0.826-0.042-1.396,0.562-1.425,1.322c-0.084,2.161-0.602,3.664-1.506,4.349c-0.196,0.151-0.405,0.254-0.606,0.323
                            c-0.006,0.002-0.015,0.003-0.021,0.005c-0.595-0.568-1.418-0.845-1.974-0.845h-3.398h-3.397c-1.246,0-2.237,1.251-2.259,2.624
                            C11.201,9.567,12.811,11.246,13.193,13.308z"/>
                          <ellipse cx="14.78" cy="3.195" rx="3.261" ry="3.195"/>
                          <path d="M14.359,21.546c0-2.479-1.068-3.526-2.55-3.526h-0.081H8.373c1.854-0.271,3.275-1.834,3.275-3.728
                            c0-2.08-1.72-3.768-3.847-3.768c-2.123,0-3.844,1.688-3.844,3.768c0,1.894,1.421,3.456,3.276,3.728H3.877H3.795
                            c-1.484,0-2.688,1.588-2.688,3.229v5.02h13.252V21.546z"/>
                          <path d="M19.101,14.292c0,1.894,1.422,3.456,3.274,3.728h-3.22h-0.219c-1.485,0-2.618,1.588-2.618,3.229v5.02h13.15v-4.72
                            c0-2.45-1.029-3.481-2.481-3.506c-0.021,0-0.019-0.021-0.037-0.021h-3.438c1.855-0.271,3.277-1.834,3.277-3.729
                            c0-2.08-1.722-3.768-3.846-3.768C20.821,10.524,19.101,12.212,19.101,14.292z"/>
                          <rect x="0.029" y="28.423" width="31.604" height="3.239"/>
                        </g>
                      </g>
                  </svg>
                 <span class="ml-1 ">Adquirentes</span>
            </x-li-single> --}}
              
  
                


          {{-- @if(auth()->user()->hasRole('Administrador')  ) --}}
          @if(auth()->user()->hasAnyPermission([
            'empresas-ver','empresas-crear','empresas-editar','empresas-actualizar','empresas-eliminar',
            'gremios-ver','gremios-crear','gremios-editar','gremios-actualizar','gremios-eliminar',
            'sectores-ver','sectores-crear','sectores-editar','sectores-actualizar','sectores-eliminar',
            'condiciones-ver','condiciones-crear','condiciones-editar','condiciones-actualizar','condiciones-eliminar',
            ]) && auth()->user()->estado ==1 )             
        <li class="fle hover:text-gray-200  hover:shadow-md hover:shadow-sky-600  items-center pl-1 mt-2"  
            x-data="  {open:false}"   
            @click="open = ! open"
            @click.outside="open = false"  >                                                

                <div  class = "flex  justify-start items-center py-1 
                  {{ Request::is('empresas','gremios','sectores','condiciones') ? 'bg-linear-to-l from-sky-300 to-sky-300/10  text-gray-200 font-bold' : '' }} 
                  "            
                  :class="{ ' bg-gry-100 text-gray-200 ': open }" 
                  >
                    

                     <svg class="w-6 h-6 " viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M9 4L9 20M15 4L15 20M3 9H21M3 15H21M6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V7.2C21 6.0799 21 5.51984 20.782 5.09202C20.5903 4.71569 20.2843 4.40973 19.908 4.21799C19.4802 4 18.9201 4 17.8 4H6.2C5.07989 4 4.51984 4 4.09202 4.21799C3.71569 4.40973 3.40973 4.71569 3.21799 5.09202C3 5.51984 3 6.07989 3 7.2V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.07989 20 6.2 20Z" stroke="#fff " stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                      <span class="ml-2 lg:mr-8 ">Tablas auxiliares</span>                
                      <svg  class="ml-auto mr-2" fill="#000000" height="12px" width="12px" version="1.1"  id="XMLID_287_"  viewBox="0 0 24 24"        xml:space="preserve" 
                        :class="{ 'rotate-90': open }" >
                        <g id="next">
                          <g>
                            <polygon points="6.8,23.7 5.4,22.3 15.7,12 5.4,1.7 6.8,0.3 18.5,12 		"/>
                          </g>
                        </g>
                      </svg>
                  </div>
  
            {{-- submenu --}}
            <ul class="flex flex-col  mt-1" x-show="open" >  
                      <li class="pl-6  mb-1   py-1 hover:text-gray-300 hover:shadow-md hover:shadow-sky-600
                  {{ Request::is('empresas') ? 'bg-linear-to-l from-sky-300 to-sky-300/10  text-gray-200 font-bold' : '' }} " >
                   <a href="{{Route('empresas')}}" class=" w-full inline-block">- Empresas</a>
                </li>

                <li class="pl-6  mb-1   py-1 hover:text-gray-300 hover:shadow-md hover:shadow-sky-600
                    {{ Request::is('gremios') ? 'bg-linear-to-l from-sky-300 to-sky-300/10  text-gray-200 font-bold' : '' }} " >
                  <a  href="{{Route('gremios')}}" class=" w-full inline-block">- Gremios</a>              
                </li>
                
                <li class="pl-6  mb-1   py-1 hover:text-gray-300 hover:shadow-md hover:shadow-sky-600
                {{ Request::is('sectores') ?  'bg-linear-to-l from-sky-300 to-sky-300/10  text-gray-200 font-bold' : '' }} " >
                  <a href="{{Route('sectores')}}" class=" w-full inline-block">- Sectores</a></li>
                <li class="pl-6  mb   py-1 hover:text-gray-300 hover:shadow-md hover:shadow-sky-600
                {{ Request::is('condiciones') ? 'bg-linear-to-l from-sky-300 to-sky-300/10  text-gray-200 font-bold' : '' }} " >
                  <a href="{{Route('condiciones')}}" class=" w-full inline-block">                  
                  -Condicion de miembro</a></li>
                
             </ul>                                     
             
           </li>
           

           @endif


           @if(auth()->user()->hasAnyPermission([
                      'empresas-ver','empresas-crear','empresas-editar','empresas-actualizar','empresas-eliminar',
                      'gremios-ver','gremios-crear','gremios-editar','gremios-actualizar','gremios-eliminar',
                      'sectores-ver','sectores-crear','sectores-editar','sectores-actualizar','sectores-eliminar',
                      'condiciones-ver','condiciones-crear','condiciones-editar','condiciones-actualizar','condiciones-eliminar',
                      ]) && auth()->user()->estado ==1 ) 
                                
              <li class="pl- mb-1 mt-2   py-1 hover:text-gray-200 hover:shadow-md hover:shadow-sky-600 px-1 
                  {{ Request::is("adminrequerimientos") ? 'bg-linear-to-l from-sky-300 to-sky-300/10  text-gray-200 font-bold' : '' }} "            
                >
                  <a class="flex gap-x-2" href="{{Route('requerimientos-afiliado-admin')}}">                                
                    <svg class="w-6 h-6" viewBox="0 0 1800 1800" enable-background="new 0 0 1800 1800" xml:space="preserve" fill="#ffffff" stroke="#ffffff">
                          <g id="SVGRepo_bgCarrier" stroke-width="0"/>
                          <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"/>
                          <g id="SVGRepo_iconCarrier"> <g> <path fill="#ffffff" d="M1506.693,279.092h-150.36v-85.277c0-17.353-14.065-31.418-31.419-31.418h-227.317 C1078.205,70.574,996.5,2.304,900.003,2.304c-96.499,0-178.202,68.27-197.595,160.092H475.091 c-17.353,0-31.419,14.065-31.419,31.418v85.277H293.307c-17.353,0-31.419,14.066-31.419,31.419v1455.764 c0,17.353,14.066,31.419,31.419,31.419h1213.386c17.354,0,31.42-14.066,31.42-31.419V310.511 C1538.113,293.158,1524.047,279.092,1506.693,279.092z M506.511,225.234h223.28c16.617,0,30.354-12.935,31.362-29.517 c4.436-73.219,65.424-130.574,138.85-130.574c73.425,0,134.413,57.355,138.849,130.574c1.009,16.582,14.746,29.517,31.363,29.517 h223.28v53.858v62.838v74.81H506.511v-74.81v-62.838V225.234z M1475.274,1734.855H324.728V341.93h118.944v106.229 c0,17.354,14.066,31.419,31.419,31.419h849.823c17.354,0,31.419-14.066,31.419-31.419V341.93h118.941V1734.855z"/> <path fill="#ffffff" d="M663.633,684.019L534.366,813.291l-57.803-57.806c-12.272-12.265-32.164-12.265-44.437,0 c-12.269,12.272-12.269,32.164,0,44.437l80.021,80.022c6.136,6.132,14.176,9.201,22.219,9.201c8.043,0,16.083-3.069,22.219-9.201 l151.486-151.486c12.269-12.273,12.269-32.165,0-44.438C695.799,671.755,675.907,671.755,663.633,684.019z"/> <path fill="#ffffff" d="M824.996,750.563c-17.354,0-31.419,14.066-31.419,31.419c0,17.354,14.066,31.419,31.419,31.419h520.665 c17.354,0,31.419-14.066,31.419-31.419c0-17.353-14.065-31.419-31.419-31.419H824.996z"/> <path fill="#ffffff" d="M663.633,1039.925l-129.267,129.272l-57.803-57.807c-12.272-12.265-32.164-12.265-44.437,0 c-12.269,12.272-12.269,32.164,0,44.438l80.021,80.021c6.136,6.133,14.176,9.2,22.219,9.2c8.043,0,16.083-3.067,22.219-9.2 l151.486-151.486c12.269-12.272,12.269-32.163,0-44.438C695.799,1027.66,675.907,1027.66,663.633,1039.925z"/> <path fill="#ffffff" d="M1345.661,1106.467H824.996c-17.354,0-31.419,14.066-31.419,31.42s14.066,31.42,31.419,31.42h520.665 c17.354,0,31.419-14.066,31.419-31.42S1363.015,1106.467,1345.661,1106.467z"/> <path fill="#ffffff" d="M663.633,1395.83l-129.267,129.272l-57.803-57.808c-12.272-12.264-32.164-12.264-44.437,0 c-12.269,12.274-12.269,32.166,0,44.439l80.021,80.021c6.136,6.132,14.176,9.199,22.219,9.199c8.043,0,16.083-3.067,22.219-9.199 l151.486-151.486c12.269-12.274,12.269-32.166,0-44.438C695.799,1383.566,675.907,1383.566,663.633,1395.83z"/> <path fill="#ffffff" d="M1345.661,1462.373H824.996c-17.354,0-31.419,14.066-31.419,31.42s14.066,31.418,31.419,31.418h520.665 c17.354,0,31.419-14.064,31.419-31.418S1363.015,1462.373,1345.661,1462.373z"/> </g> </g>
                      </svg>
           
                <span class="ml-1 ">Requerimientos</span></a>
              </li>

              
            @endif

        

          {{-- <li class="pl-2 mb-1   py-1 hover:text-gray-600 hover:shadow-md hover:shadow-gray-200" @click="title = 'Ai Chat' "  >
          <a class="flex gap-x-2">          
           <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" >
                <g clip-path="url(#clip0_15_3)">
                <rect width="24" height="24" fill="white"/>
                <path d="M9 21H4C3.44772 21 3 20.5523 3 20V12.4142C3 12.149 3.10536 11.8946 3.29289 11.7071L11.2929 3.70711C11.6834 3.31658 12.3166 3.31658 12.7071 3.70711L20.7071 11.7071C20.8946 11.8946 21 12.149 21 12.4142V20C21 20.5523 20.5523 21 20 21H15M9 21H15M9 21V15C9 14.4477 9.44772 14 10 14H14C14.5523 14 15 14.4477 15 15V21" stroke="#000000" stroke-linejoin="round"/>
                </g>
                <defs>
                <clipPath id="clip0_15_3">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
            </svg>          
             <span>Ai Chat</span></a>
          </li> --}}
        

        
        {{-- <li class="title  text-start w-full mb-2 mt-4 ">Custom</li>

        <li class="pl-2 mb-1   py-1 hover:text-gray-600 hover:shadow-md hover:shadow-gray-200 bordr">
          <a class="flex gap-x-2">          
           <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 4L9 20M15 4L15 20M3 9H21M3 15H21M6.2 20H17.8C18.9201 20 19.4802 20 19.908 19.782C20.2843 19.5903 20.5903 19.2843 20.782 18.908C21 18.4802 21 17.9201 21 16.8V7.2C21 6.0799 21 5.51984 20.782 5.09202C20.5903 4.71569 20.2843 4.40973 19.908 4.21799C19.4802 4 18.9201 4 17.8 4H6.2C5.07989 4 4.51984 4 4.09202 4.21799C3.71569 4.40973 3.40973 4.71569 3.21799 5.09202C3 5.51984 3 6.07989 3 7.2V16.8C3 17.9201 3 18.4802 3.21799 18.908C3.40973 19.2843 3.71569 19.5903 4.09202 19.782C4.51984 20 5.07989 20 6.2 20Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
             <span>Tablas</span></a>
          </li>

      
           <x-dropdown2  title="opciones">
            <li class="pl-2  mb-1   py-1 hover:text-gray-600 hover:shadow-md hover:shadow-gray-200"><a href="/">- opcion 1</a></li>
            <li class="pl-2  mb-1   py-1 hover:text-gray-600 hover:shadow-md hover:shadow-gray-200"><a>- opcion 2</a></li>
            
          </x-dropdown2> 

          <li class="pl-2 mb-1   py-1 hover:text-gray-600 hover:shadow-md hover:shadow-gray-200">
          <a class="flex gap-x-2">          
           <svg width="20px" height="20px" viewBox="0 0 24 24" fill="none" >
                <g clip-path="url(#clip0_15_3)">
                <rect width="24" height="24" fill="white"/>
                <path d="M9 21H4C3.44772 21 3 20.5523 3 20V12.4142C3 12.149 3.10536 11.8946 3.29289 11.7071L11.2929 3.70711C11.6834 3.31658 12.3166 3.31658 12.7071 3.70711L20.7071 11.7071C20.8946 11.8946 21 12.149 21 12.4142V20C21 20.5523 20.5523 21 20 21H15M9 21H15M9 21V15C9 14.4477 9.44772 14 10 14H14C14.5523 14 15 14.4477 15 15V21" stroke="#000000" stroke-linejoin="round"/>
                </g>
                <defs>
                <clipPath id="clip0_15_3">
                <rect width="24" height="24" fill="white"/>
                </clipPath>
                </defs>
            </svg>          
             <span>Tablas</span></a>
          </li>
        




        

              
            
          
        
        
      </ul> --}}


    {{-- </div> --}}

  
  
  
</div>


