<x-layouts.guest>

    <div class="flex flex-col items-center min-h-[30vh] px-4 pt-10">

        <x-fancy-heading tag="h1" text="P{r}eg{u}nt{a}s Fr{e}cue{n}t{e}s" variant="italic mx-[0.5px] font-normal"
            class=" md:text-[64px] text-[28px] leading-9 md:text-center text-start   md:mb-1 text-wrap font-normal" />

        <div class="w-full max-w-4xl mx-auto mt-12 space-y-4">

            <x-faq-item title="No tengo cuenta y no tengo billetera virtual. ¿Puedo pagar en efectivo?">
                <p>
                    Podés depositar el efectivo en un cajero del banco Santander en la cuenta que te informamos en
                    la orden de lo que compraste.
                </p>
            </x-faq-item>

            <x-faq-item title="¿Puedo retirar los lotes que compré en sus oficinas?">
                <p>
                    No, nosotros te lo enviamos. Si vivís en CABA o Gran Buenos Aires, solo te va a costar lo que
                    sale un viaje de aplicación, siempre que sus dimensiones lo permitan.
                </p>
            </x-faq-item>

            <x-faq-item title="Vivo en el interior. ¿Realizan envíos?">
                <p>
                    Sí. En ese caso averiguamos la mejor manera de hacerte llegar tus lotes de manera segura, sin
                    demoras y lo más económico posible.
                </p>
            </x-faq-item>

            <x-faq-item title=" ¿Lo que tengo que abonar es por envío, es por cada lote?">
                <p>
                    No, solo abonás una vez. Nosotros te enviamos todo junto.
                </p>
            </x-faq-item>

            <x-faq-item
                title="Tengo algunas cosas que me gustaría vender en una subasta, pero son muy grandes. ¿Cómo hago?">
                <p>
                    Vamos al lugar y lo evaluaremos. Si es algo atractivo para incluirlo en alguno de nuestros remates,
                    vemos la forma de trasladarlo.
                </p>
            </x-faq-item>

            <x-faq-item title="No tengo fotos buenas de mis objetos, ¿qué puedo hacer?">
                <p>
                    Envialas igual. Luego nosotros sacaremos fotos profesionales. Son tus cosas y queremos que se
                    vean bien.
                </p>
            </x-faq-item>

            <x-faq-item title="¿Puedo ofertar lo que yo quiera?">
                <p>
                    Sí, siempre que sea una cifra mayor a la sugerida por el sistema, podés ofrecer lo que quieras.
                </p>
            </x-faq-item>

            <x-faq-item title="¿Puedo comprar un lote que no se haya vendido en la subasta?">
                <p>
                    Una vez que la subasta haya terminado, si hay un lote sin ofertas, podés consultarnos por mail o
                    WA. En ese caso el comitente puede llevárselo o dejarlo para venta directa o para incluirlo en una
                    futura subasta. Si lo deja, le comunicamos tu propuesta y te haremos saber la respuesta.
                </p>
            </x-faq-item>

            <x-faq-item title="¿Qué pasa si alguien ofrece más que yo y no estoy mirando la subasta?">
                <p>
                    Si no estás mirando, te va a llegar un mail apenas alguien supere la oferta. No te preocupes,
                    siempre vas a tener tiempo de seguir pujando mientras la subasta esté activa.
                </p>
            </x-faq-item>





        </div>




        <div class="w-full max-w-5xl mx-auto mt-16 border-t pt-12">

            <h2 class="text-2xl font-semibold mb-2 text-center">
                ¿No encontraste tu respuesta?
            </h2>

            <p class="text-center mb-8 text-sm md:text-base">
                Escribinos y te ayudamos con tu consulta.
            </p>

            <livewire:contact-form />
        </div>

        {{-- Volver --}}
        <div class="lg:px-0 px-4 flex md:flex-row flex-col gap-x-15 gap-y-6 max-w-7xl mt-16 justify-center w-full">

            <a href="{{ route('home') }}"
                class="bg-casa-base-2 hover:bg-casa-black-h text-casa-black  hover:text-casa-base rounded-full px-4 flex items-center justify-between gap-x-5 py-1 lg:w-fit w-full font-bold border  border-casa-black">
                <svg class="size-8 sm:mr-6 rotate-180">
                    <use xlink:href="#arrow-right"></use>
                </svg>
                Volver a inicio
            </a>


            <a href="https://wa.me/+541130220449" target="_blank"
                class="bg-casa-base-2 hover:bg-casa-black-h text-casa-black  hover:text-casa-base rounded-full px-4 flex items-center justify-between gap-x-5 py-1 lg:w-fit w-full font-bold border  border-casa-black">
                Contactanos a whatsApp
                <svg class="size-8 sm:ml-6 ">
                    <use xlink:href="#arrow-right"></use>
                </svg>
            </a>


        </div>

    </div>






</x-layouts.guest>
