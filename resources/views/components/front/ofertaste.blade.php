@props(['moneda', 'oferta'])
<p
    class="text-casa-black border border-black rounded-full px-4 md:py-2 py-1 md:flex items-center justify-center w-full md:text-xl text-sm bg-casa-base mt-auto">
    Ofertaste:
    <b class="ml-1">
        {{ $moneda }} {{ $oferta }}
    </b>
</p>
