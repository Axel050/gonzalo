<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Factura #{{ $factura->id }}</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 4px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .font-bold {
            font-weight: bold;
        }

        .header-table td {
            border: none;
            padding: 2px;
        }
    </style>
</head>

<body>

    <div class="text-center" style="margin-bottom: 10px;">
        @if ($logo)
            <img src="{{ $logo }}" alt="Logo" style="width: 200px; height: auto;">
        @endif
    </div>

    <!-- HEADER -->
    <table class="header-table" style="background:#f9fafb; padding:5px; border:1px solid #e5e7eb;">
        <tr>
            <td style="width:50%; vertical-align:top;">
                <strong>Adquirente:</strong><br>
                {{ $adquirente->nombre }} {{ $adquirente->apellido }}<br>
                CUIT: {{ $adquirente->CUIT ?? '-' }}<br>
                {{ $adquirente->domicilio ?? '' }}
            </td>

            <td style="width:50%; vertical-align:top; text-align:right;">
                <strong style="font-size: 14px;">FACTURA #{{ $factura->id }}</strong><br><br>
                Fecha: {{ $factura->fecha }}<br>

                <span style="text-transform:uppercase;">
                    {{ str_replace('_', ' ', $factura->tipo_concepto) }}
                </span>
            </td>
        </tr>
    </table>

    <!-- ITEMS -->
    <table>
        <thead>
            <tr>
                <th>Concepto</th>
                <th class="text-right">Monto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->concepto }}</td>
                    <td class="text-right">
                        ${{ number_format($item->precio, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTAL -->
    <div style="float: right; width: 250px; margin-top: 10px;">
        <table style="border: none;">
            <tr>
                <td style="border: none; padding-top: 10px;">
                    <h3>TOTAL:</h3>
                </td>
                <td style="border: none; padding-top: 10px;" class="text-right">
                    <h3>${{ number_format($factura->monto_total, 0, ',', '.') }}</h3>
                </td>
            </tr>
        </table>
    </div>

    <div style="clear: both;"></div>

</body>

</html>
