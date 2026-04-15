<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Devolución #{{ $devolucion->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        .header {
            border-bottom: 2px solid #0f766e;
            padding-bottom: 8px;
            margin-bottom: 16px;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            color: #134e4a;
        }

        .box {
            border: 1px solid #d1d5db;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 6px;
        }

        .label {
            font-weight: bold;
            color: #374151;
        }
    </style>
</head>

<body>
    @php
        $lotes = $devolucion->lotes->count() > 0 ? $devolucion->lotes : collect([$devolucion->lote])->filter();
        $comitente = $lotes->first()?->comitente;
    @endphp
    <div class="header">
        @if ($logo)
            <img src="{{ $logo }}" alt="Logo" style="height: 35px;">
        @endif
        <div class="title">Comprobante de devolución #{{ $devolucion->id }}</div>
    </div>

    <div class="box">
        <p><span class="label">Fecha:</span> {{ \Carbon\Carbon::parse($devolucion->fecha)->format('d/m/Y') }}</p>
        <p><span class="label">Comitente:</span>
            {{ $comitente?->id }} -
            {{ $comitente?->nombre }}
            {{ $comitente?->apellido }}
        </p>
        <p><span class="label">Motivo:</span> {{ $devolucion->motivo?->nombre }}</p>
        <p><span class="label">Estado:</span> {{ strtoupper($devolucion->estado ?? 'generada') }}</p>
    </div>

    <div class="box">
        <p class="label">Lotes devueltos</p>
        <ul>
            @foreach ($lotes as $lote)
                <li>#{{ $lote->id }} - {{ $lote->titulo }}</li>
            @endforeach
        </ul>
    </div>

    @if ($devolucion->descripcion)
        <div class="box">
            <p class="label">Descripción</p>
            <p>{{ $devolucion->descripcion }}</p>
        </div>
    @endif
</body>

</html>
