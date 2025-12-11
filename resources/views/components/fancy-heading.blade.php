@props([
    'text',
    'variant' => 'italic', // Por defecto será itálica (Book Italic)
])

@php
    // Inyectamos la variable $variant dentro de la clase del span.
    // Nota cómo concatenamos la string:
    $spanClasses = 'font-caslon ' . $variant . ' text-[1.15em]   -mr-0.5 align-baseline';

    $formattedText = preg_replace('/\{(.*?)\}/', '<span class="' . $spanClasses . '">$1</span>', e($text));
@endphp

<h2 {{ $attributes->merge(['class' => 'font-helvetica leading-tight ']) }}>
    {!! $formattedText !!}
</h2>
