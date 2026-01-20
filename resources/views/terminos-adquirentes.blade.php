<x-layouts.guest>
    <x-slot name="headerT">
        Detalles
    </x-slot>

    {{-- @livewire('terminos') --}}


    <div class="flex flex-col items-center min-h-[30vh] px-4">



        <svg fill="#fff" class="w-60  h-7 lg:flex  mt-12 mb-4 bg-red-4 lg:scale-150 scale-115">
            <use xlink:href="#casa-icon"></use>
        </svg>

        <h1 class="lg:my-8 my-4  mx-auto lg:text-4xl text-2xl text-center font-semibold">Términos y condiciones para los
            Adquirentes
        </h1>

        <div class="lg:px-24 px-4 flex flex-col gap-y-2 sm:gap-y-3  max-w-7xl">
            <p>
                Cualquier persona, humana o jurídica, que tenga el interés y/o la voluntad de participar en este
                sitio de subastas en línea, en adelante “Casablanca.ar”, será considerado como eventual
                comprador, en adelante “El Adquirente”, y acepta los siguientes términos y condiciones:
            </p>

            <p>
                1.- Para obtener la calidad de tal, El Adquirente deberá registrarse en el sitio de Casablanca.ar
                completando la información identificatoria de los campos obligatorios que en el formulario de
                registro se solicitan. Uno de ellos es el correo electrónico que también será considerado como
                usuario de El Adquirente. Con este último se validará el correo electrónico y se le habilitará el
                ingreso. Casablanca.ar se reserva el derecho de rechazar el registro de El Adquirente, si así lo
                llegara a considerar. El Adquirente se compromete a mantener su contraseña en secreto. De igual
                modo, se compromete a cerrar cada sesión y a notificar a Casablanca.ar cualquier pérdida o
                acceso no autorizado por parte de terceros. Es de exclusiva responsabilidad del Adquirente
                mantener la confidencialidad de la cuenta de usuario y de la contraseña, las cuales serán
                personales e intransferibles. El incumplimiento de las obligaciones facultará a Casablanca.ar a
                revocar las autorizaciones de acceso al sitio.
            </p>

            <p>
                2.- La información de cada subasta y de los lotes presentados estará disponible para El
                Adquirente una vez que haya ingresado al sitio, a saber: descripción completa de los lotes,
                fotografías, inicio y finalización de la subasta, base, comisión y gastos de envío, próximas
                subastas y subastas anteriores. También podrá informarse sobre el mínimo de oferta y el tiempo
                de puja final, explicados en el punto 4. Y estará facultado para hacer ofertas.
            </p>

            <p>
                3.- Una vez hecha la primer oferta se lo considerará mejor postor. Si la misma es superada
                recibirá una notificación en el cuadro del lote que está pujando. También recibirá un correo
                electrónico anunciando esta situación, debiendo ingresar al sitio para subir la oferta, si así lo
                desea. El tiempo de puja final, se refiere a los minutos que se adicionarán si hay una nueva oferta
                al momento anterior de la finalización de la subasta. Si se recibe una puja en ese instante, se
                adicionará un lapso que permitirá a otros interesados a proponer un monto mayor de compra. Si
                al finalizar el tiempo de puja final, no hay una oferta superadora, Casablanca.ar tendrá en cuenta
                al último oferente como adjudicatario final del bien. El mínimo de oferta se refiere al monto que se
                debe adicionar con cada puja. Es un límite inferior que puede ser mejorado si El Adquirente tiene
                deseo de ofrecer una cantidad extra para disuadir a los demás oferentes de seguir pujando.
            </p>

            <p>
                4.- Una vez finalizada la subasta de cada lote, Casablanca.ar le comunicará a El Adquirente
                adjudicatario, por medio de un correo electrónico, el resultado de la misma con todos los datos
                de la operación: valor de compra, comisión, gastos de envío y los datos bancarios para abonar el
                bien. Estos resultados también se verán reflejados en el carrito de El Adquirente, disponible en el
                sitio.
            </p>

            <p>
                5.- El Adquirente deberá abonar su compra dentro de las 72 hs. hábiles siguientes a la finalización
                de la subasta. De no cumplir con esta obligación se dará de baja la operación, El Adquirente será
                considerado postor remiso y será vetado de participar en futuras subastas de Casablanca.ar.
            </p>

            <p>
                6.- SI El Adquirente pujara por un lote que sea de su propiedad, y resultara ser el mejor oferente,
                deberá abonar la comisión por venta y la comisión por compra, y será vetado de participar en
                futuras subastas de Casablanca.ar.
            </p>

            <p>
                7.- Los lotes NO se retiran en las oficinas de Casablanca.ar. Se enviarán al domicilio que El
                Adquirente indique dentro de las 48 hs. hábiles posteriores a la efectivización del pago de la
                compra. El departamento de logística de Casablanca.ar se comunicará para coordinar día y
                horario de entrega.
            </p>

            <p>
                8.- La descripción de cada lote detalla todas las características de los bienes. No se aceptarán
                reclamos por vicios que hayan sido informados, ni se concederán cambios o devoluciones de los
                lotes vendidos.
            </p>

            <p>
                9.- Casablanca.ar no puede revelar la procedencia de los lotes salvo expresa autorización de
                sus dueños.
            </p>

            <p>
                10.- Casablanca.ar se compromete a preservar la confidencialidad de todos los datos de El
                Adquirente y de las operaciones que realice.
            </p>

            <p>
                11.- Casablanca.ar se reserva el derecho de emprender las eventuales acciones judiciales que
                considere, sentando jurisdicción en la Ciudad Autónoma de Buenos Aires.
            </p>


            <button onclick="window.close();"
                class="bg-casa-black hover:bg-casa-black-h text-gray-50 rounded-full px-4 flex items-center justify-between gap-x-5 py-1  lg:w-fit w-full mt-6 mx-auto font-bold">
                <svg class="size-8 sm:mr-8 rotate-180">
                    <use xlink:href="#arrow-right"></use>
                </svg>
                Aceptar y volver

            </button>

        </div>
    </div>


</x-layouts.guest>
