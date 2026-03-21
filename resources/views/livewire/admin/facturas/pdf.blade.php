<div style="text-align: center; margin-bottom: 20px;">
    <img src="{{ $logo }}" alt="Logo" style="width: 300px; height: auto; margin-bottom: 12px;">




    <table width="100%"
        style="margin-bottom:12px;background:#f9fafb;padding:5px;border-radius:6px;border:1px solid #e5e7eb;">
        <tr>

            <td style="width:50%; vertical-align:top; text-align:left;">
                <strong>Adquirente:</strong><br>
                {{ $adquirente->nombre }} {{ $adquirente->apellido }}<br>
                {{ $adquirente->domicilio }}<br>
                CUIT: {{ $adquirente->CUIT }}
            </td>

            <td style="width:50%; vertical-align:top; text-align:right;">
                <strong>Factura #{{ $factura->id }}</strong><br>
                Fecha: {{ $factura->fecha }}<br>

                <span style="font-weight:bold; color:orange; text-transform:uppercase;">
                    {{ str_replace('_', ' ', $factura->tipo_concepto) }}
                </span>

            </td>

        </tr>
    </table>

    <table width="100%" border="1" cellpadding="5">
        <tr>
            <th>Concepto</th>
            <th>Monto</th>
        </tr>

        @foreach ($items as $item)
            <tr>
                <td>{{ $item->concepto }}</td>
                <td>${{ number_format($item->precio, 2) }}</td>
            </tr>
        @endforeach

    </table>

    <h3>Total: ${{ number_format($factura->monto_total, 2) }}</h3>

</div>
