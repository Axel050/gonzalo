@props([
    'text',
    'variant' => 'italic', // Por defecto itálica
])

@php
    // 1. Preparamos las clases de la fuente especial (Caslon) usando la variable $variant
    // Asegúrate de que 'font-casa-caslon' coincida con lo que definiste en tu CSS (o usa 'font-caslon')
    $caslonClasses = "font-caslon {$variant} text-[1.15em]  x-0.5 align-baseline";

    // 2. Separamos el texto en caracteres
    $chars = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

    $output = '';
    $toggle = true; // true = Helvetica, false = Caslon

    foreach ($chars as $char) {
        // Si es un espacio vacío, lo añadimos directo sin cambiar el toggle ni poner span
        // (Esto evita que el espacio "consuma" el turno de una fuente y se vea raro)
        if (trim($char) === '') {
            $output .= ' ';
            continue;
        }

        if ($toggle) {
            // Fuente 1: Helvetica
            $output .= '<span class="font-helvetica bg-lue-500">' . e($char) . '</span>';
        } else {
            // Fuente 2: Caslon (Aquí inyectamos las clases dinámicas)
            $output .= '<span class="' . $caslonClasses . '">' . e($char) . '</span>';
        }

        // Solo cambiamos de fuente si acabamos de escribir una letra
        $toggle = !$toggle;
    }
@endphp

<h2 {{ $attributes->merge(['class' => 'leading-tight']) }}>
    {!! $output !!}
</h2>
