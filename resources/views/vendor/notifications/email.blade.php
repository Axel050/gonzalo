<x-mail::message>
    {{-- Greeting --}}
    @if (!empty($greeting))
        # {{ $greeting }}
    @else
        @if ($level === 'error')
            # ¡Ups!
        @else
            # ¡Hola!
        @endif
    @endif

    {{-- Intro Lines --}}
    @foreach ($introLines as $line)
        {{ $line }}
    @endforeach

    {{-- Action Button: AQUÍ SE RENDERIZA EL BOTÓN CORRECTAMENTE --}}
    @isset($actionText)
        <?php
        $color = match ($level) {
            'success', 'error' => $level,
            default => 'primary',
        };
        ?>
        @component('mail::button', ['url' => $actionUrl, 'color' => $color])
            {{ $actionText }}
        @endcomponent
    @endisset

    {{-- Outro Lines --}}
    @foreach ($outroLines as $line)
        {{ $line }}
    @endforeach

    {{-- Salutation: SIN "Regards," --}}
    @if (!empty($salutation))
        {{ $salutation }}
    @else
        Atentamente,<br>
        {{ config('app.name') }} {{-- Cambia a 'CASABLANCA.AR' en config/app.php si quieres --}}
    @endif

    {{-- Subcopy: EN ESPAÑOL Y SIN HTML ROTTO --}}
    @isset($actionText)
        @slot('subcopy')
            Si tienes prsssoblemas haciendo clic en el botón "{{ $actionText }}", copia y pega esta URL en tu navegador:
            {{ $actionUrl }}
        @endslot
    @endisset
</x-mail::message>
