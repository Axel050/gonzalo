<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Liquidación #{{ $liquidacion->numero }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .half-page {
            height: 48%;
            box-sizing: border-box;
            padding-bottom: 10px;
        }

        .dashed-line {
            border-bottom: 2px dashed #999;
            margin: 10px 0;
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


    {{-- Para duplicado cambiar a 2 --}}
    {{-- @for ($i = 0; $i < 2; $i++) --}}
    @for ($i = 0; $i < 1; $i++)
        <div class="half-page">
            <div class="text-center" style="margin-bottom: 10px;">
                @if ($logo)
                    <img src="{{ $logo }}" alt="Logo" style="width: 200px; height: auto;">
                @endif
            </div>

            <table class="header-table" style="background:#f9fafb; padding:5px; border:1px solid #e5e7eb;">
                <tr>
                    <td style="width:50%; vertical-align:top;">
                        <strong>Comitente:</strong><br>
                        {{ $comitente->nombre }} {{ $comitente->apellido }}<br>
                        CUIT: {{ $comitente->CUIT ?? '-' }}<br>
                        {{ $comitente->domicilio ?? '' }}
                    </td>
                    <td style="width:50%; vertical-align:top; text-align:right;">
                        <strong style="font-size: 14px;">LIQUIDACIÓN #{{ $liquidacion->numero }}</strong><br>
                        {{-- <span style="font-weight:bold; color:blue;">{{ $i === 0 ? 'ORIGINAL' : 'DUPLICADO' }}</span> --}}
                        <br>
                        Fecha: {{ \Carbon\Carbon::parse($liquidacion->fecha)->format('d/m/Y') }}<br>
                        Estado: <span style="text-transform:uppercase;">{{ $liquidacion->estado }}</span>
                    </td>
                </tr>
            </table>

            <table>
                <thead>
                    <tr>
                        <th>Concepto</th>
                        <th>Tipo</th>
                        <th class="text-right">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->concepto }}</td>
                            <td>
                                @if ($item->tipo == 'ingreso')
                                    Ingreso
                                @elseif($item->tipo == 'egreso_comision')
                                    Comisión
                                @else
                                    Gasto
                                @endif
                            </td>
                            <td class="text-right">
                                @if ($item->tipo == 'ingreso')
                                    ${{ number_format($item->monto, 0, ',', '.') }}
                                @else
                                    - ${{ number_format($item->monto, 0, ',', '.') }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="float: right; width: 250px; margin-top: 10px;">
                <table style="border: none;">

                    {{-- <tr>
                            <td style="border: none;">Subtotal Lotes:</td>
                            <td style="border: none;" class="text-right font-bold">
                                ${{ number_format($liquidacion->subtotal_lotes, 2, ',', '.') }}</td>
                        </tr> --}}
                    {{-- @if ($item->tipo != 'ingreso')
                        <tr>
                            <td style="border: none;">Comisión ({{ $liquidacion->comision_porcentaje }}%):</td>
                            <td style="border: none;" class="text-right font-bold text-orange">-
                                ${{ number_format($liquidacion->subtotal_comisiones, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="border: none;">Gastos Extra:</td>
                            <td style="border: none;" class="text-right font-bold text-red">-
                                ${{ number_format($liquidacion->subtotal_gastos, 0, ',', '.') }}</td>
                        </tr>
                    @endif --}}
                    <tr>
                        <td style="border: none; padding-top: 10px;">
                            <h3>TOTAL:</h3>
                        </td>
                        <td style="border: none; padding-top: 10px;" class="text-right">
                            <h3>${{ number_format($liquidacion->monto_total, 0, ',', '.') }}</h3>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="clear: both;"></div>

            @if ($liquidacion->observaciones)
                <div style="margin-top: 10px; font-size: 11px;">
                    <strong>Observaciones:</strong><br>
                    {{ $liquidacion->observaciones }}
                </div>
            @endif
        </div>

        @if ($i === 0)
            <div class="dashed-line"></div>
        @endif
    @endfor

</body>

</html>
