@props(['text', 'variant' => 'italic'])

@php
    $caslonClasses = "font-caslon {$variant} text-[1.15em] x-0.5 align-baseline";
    $chars = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);

    $output = '';
    $toggle = true;

    foreach ($chars as $char) {
        if (trim($char) === '') {
            $output .= ' ';
            continue;
        }

        if ($toggle) {
            $output .= '<span class="font-helvetica">' . e($char) . '</span>';
        } else {
            $output .= '<span class="' . $caslonClasses . '">' . e($char) . '</span>';
        }

        $toggle = !$toggle;
    }
@endphp

{!! $output !!}
