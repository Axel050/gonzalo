<x-layouts.guest>
    <x-slot name="headerT">
        Detalles
    </x-slot>

    {{-- @livewire('terminos') --}}


    <div class="flex flex-col items-center min-h-[30vh] px-4">



        <svg fill="#fff" class="w-60  h-7 lg:flex  mt-12 mb-4 bg-red-4 lg:scale-150 scale-115">
            <use xlink:href="#casa-icon"></use>
        </svg>

        <h1 class="lg:my-8 my-4  mx-auto lg:text-4xl text-2xl text-center font-semibold">Instructivo Comitentes
        </h1>

        <div class="lg:px-24 px-4 flex flex-col gap-y-2  max-w-7xl">
            <p>
                Cualquier persona, física o jurídica, que tenga el interés y/o la voluntad de participar en este sitio
                de subastas en línea, en adelante “Casablanca.ar”, será considerado como eventual comprador,
                en adelante “El Adquirente”, y acepta los siguientes términos y condiciones:
            </p>
            <p>
                1.- Para obtener la calidad de tal, El Adquirente deberá registrarse en el sitio de Casablanca.ar
                completando los datos obligatorios que en el formulario de registro se solicitan. Casablanca.ar se
                compromete a preservar la confidencialidad de todos los datos. Uno de ellos es el correo
                electrónico que también será considerado como usuario de El Adquirente. Con este último y con
                la contraseña que se elija, se validará el correo electrónico y se habilitará el ingreso al sitio.
            </p>
            <p>
                2.- La información de cada subasta y de los lotes presentados estará disponible para El
                Adquirente una vez que haya ingresado al sitio, a saber: descripción completa de los lotes,
                fotografías, inicio y finalización de la subasta, base, comisión y gastos de envío, próximas
                subastas y subastas anteriores.
            </p>
            <p>
                3.- Una vez ingresado, para participar de una subasta y realizar ofertas, El Adquirente deberá
                abonar un monto como garantía, demostrando un interés genuino en participar de la subasta. Si
                no resultara adjudicatario, Casablanca.ar se compromete a devolver ese monto dentro de las 48
                hs. hábiles siguientes a la finalización de la subasta. Si, como resultado de las pujas, adquiriera
                uno o varios bienes, se descontará ese valor del total de la compra. Esta caución se establece
                para cada subasta en forma individual, NO para cada lote. No se habilitará el acceso a la subasta
                hasta que no se haya comprobado el pago de la misma. El valor de la caución se informará, para
                cada subasta, una vez que El Adquirente haya ingresado al sitio con su usuario y contraseña.
            </p>
            <p>
                4.- El Adquirente habilitado para pujar deberá completar otros datos y podrá ver toda la
                información adicional de cada lote de la subasta, como ser el mínimo de oferta y el tiempo de
                puja final.
            </p>
            <p>
                5.- El tiempo de puja final, se refiere a los minutos que se adicionarán si hay una nueva oferta al
                momento anterior de la finalización de la subasta. Si se recibe una puja en ese instante, se
                adicionará un lapso que permitirá a otros interesados a proponer un monto mayor de compra, tal
                como sucede en los remates presenciales. En esos casos se da por vendido el lote al tercer golpe
                de martillo del subastador. En Casablanca.ar esto sucede cuando, una vez finalizado el tiempo de
                puja final, no haya una oferta superadora. Casablanca.ar tendrá en cuenta al mejor oferente como
                adjudicatario final del bien.
            </p>
            <p>
                6.- El mínimo de oferta se refiere al monto que se debe adicionar con cada puja. Es un límite
                inferior que puede ser mejorado, con múltiplos del mínimo, si El Adquirente tiene deseo de
                ofrecer una cantidad extra para disuadir a los demás oferentes de seguir pujando
            </p>
            <p>
                7.- Una vez finalizada la subasta de cada lote, Casablanca.ar le comunicará a El Adquirente
                adjudicatario, por medio de un correo electrónico, el resultado de la misma con todos los datos
                de la operación: valor de martillo, comisión, IVA (si corresponde), gastos de envío y los datos
                bancarios para abonar el bien u otros medios de pago electrónicos. No se aceptarán pagos en
                efectivo.
            </p>
            <p>
                8.- El Adquirente deberá abonar su compra dentro de las 72 hs. hábiles siguientes a la finalización
                de la subasta. De no cumplir con esta obligación se dará de baja la operación, El Adquirente
                perderá el derecho a la devolución de la garantía y será vetado de participar en futuras subastas
                de Casablanca.ar.
            </p>
            <p>
                9.- Casablanca.ar decidirá si corresponde que algún lote pudiera tener mérito de que se le
                extienda un certificado de autenticidad. En tal caso, el mismo será expedido por el autor, el
                dueño de la obra o quien reúna las condiciones habilitantes para poder hacerlo.
            </p>
            <p>
                10.- Los lotes NO se retiran en las oficinas de Casablanca.ar. Se enviarán al domicilio que El
                Adquirente indique. El departamento de logística de Casablanca.ar se comunicará para coordinar
                día y horario de entrega.
            </p>
            <p>
                11.- Si algún lote pudiera tener una eventual falla o imperfección, estas serán especificadas, en
                detalle, en la descripción de cada lote, no aceptando reclamo alguno por ese motivo. No se
                concederán cambios o devoluciones de los lotes vendidos.
            </p>
            <p>
                12.- SI El Adquirente pujara por un lote que sea de su propiedad con el oprobioso objetivo de
                subir el precio, y resultara ser el mejor oferente, deberá abonar la comisión por venta y la
                comisión por compra, perderá el derecho a la devolución de la garantía y será vetado de
                participar en futuras subastas de Casablanca.ar.
            </p>

            <button onclick="window.close();"
                class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1  lg:w-fit w-full mt-6 mx-auto">
                Vovlver
                <svg class="size-8 lg:ml-8">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </button>

        </div>
    </div>


</x-layouts.guest>
