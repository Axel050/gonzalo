<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Etiqueta Envio Orden {{ $orden->id }}</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            margin: 20px;
        }

        .header {
            border-bottom: 2px solid #111827;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle {
            margin-top: 4px;
            color: #374151;
        }

        .grid {
            width: 100%;
        }

        .col-left,
        .col-right {
            vertical-align: top;
        }

        .col-left {
            width: 68%;
            padding-right: 12px;
        }

        .col-right {
            width: 32%;
            text-align: center;
        }

        .box {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .label {
            font-size: 10px;
            text-transform: uppercase;
            color: #6b7280;
            margin-bottom: 2px;
        }

        .value {
            font-size: 13px;
            margin-bottom: 8px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .list {
            margin: 0;
            padding-left: 16px;
        }

        .list li {
            margin-bottom: 4px;
        }

        .qr {
            width: 154px;
            height: 154px;
            border: 1px solid #e5e7eb;
            padding: 4px;
        }
    </style>
</head>

<body>

    <div style="text-align: center; margin-bottom: 12px;">
        <img src="{{ $logo }}" alt="Logo" style="width: 300px; height: auto; margin-bottom: 12px;">
    </div>
    <div class="header">
        <h1 class="title">Etiqueta de Envio</h1>
        <div class="subtitle">Orden #{{ $orden->id }} - Subasta {{ $subasta?->id }}
            {{ $subasta?->titulo ? '- ' . $subasta->titulo : '' }}</div>
    </div>

    <table class="grid" cellspacing="0" cellpadding="0">
        <tr>
            <td class="col-left">
                <div class="box">
                    <div class="section-title">Datos del adquirente</div>

                    <div class="label">Nombre</div>
                    <div class="value">
                        {{ trim(($adquirente?->nombre ?? '') . ' ' . ($adquirente?->apellido ?? '')) ?: '-' }}</div>

                    <div class="label">Telefono</div>
                    <div class="value">{{ $adquirente?->telefono ?: '-' }}</div>

                    <div class="label">Domicilio de envio</div>
                    <div class="value">{{ $adquirente?->domicilio_envio ?: ($adquirente?->domicilio ?: '-') }}</div>

                </div>


            </td>
            <td class="col-right">
                <div class="box">
                    <img src="{{ $qr }}" alt="QR Orden" class="qr">
                </div>
            </td>
        </tr>
    </table>
</body>

</html>
