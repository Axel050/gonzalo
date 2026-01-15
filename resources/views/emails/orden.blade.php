<!DOCTYPE html>
<html>

<head>
    <title>Test Email</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body
    style="font-family: Arial, Helvetica, sans-serif; color: #333333; margin: 0; padding: 20px; background-color: #f4f4f4;">
    <table align="center" width="600" cellpadding="0" cellspacing="0"
        style="background-color: #ffffff; border: 1px solid #dddddd; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
        <tr>
            <td style="padding: 20px;">
                <h1 style="font-size: 24px; color: #1a73e8; margin: 0 0 20px 0; text-align: center;">CASABLANCA.AR</h1>
                <table width="100%">
                    <tr style="font-size: 14px;">
                        <td>Orden: {{ $data['orden_id'] }}</td>
                        <td>Subasta: {{ $data['subasta_id'] }} - {{ $data['subasta_titulo'] }}</td>
                    </tr>
                </table>
                {{-- ADDD BTON --}}
                <br>

                <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px 0;">{{ $data['message'] }} de orden.
                </p>

                <p style="font-size: 16px; font-weight: bold; margin: 0 0 10px 0;">Lotes:</p>
                <table width="100%" cellpadding="10" cellspacing="0"
                    style="border-collapse: collapse; border: 1px solid #cccccc;">
                    <thead>
                        <tr style="background-color: #f8f8f8; border-bottom: 2px solid #cccccc;">
                            <th style="font-size: 14px; color: #333333; text-align: left; border: 1px solid #cccccc;">
                                Título</th>
                            <th style="font-size: 14px; color: #333333; text-align: left; border: 1px solid #cccccc;">
                                Descripción</th>
                            <th style="font-size: 14px; color: #333333; text-align: left; border: 1px solid #cccccc;">
                                Foto</th>
                            <th style="font-size: 14px; color: #333333; text-align: left; border: 1px solid #cccccc;">
                                Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['lotes'] as $item)
                            <tr style="border-bottom: 1px solid #cccccc;">
                                <td style="font-size: 14px; color: #333333; border: 1px solid #cccccc; padding: 10px;">
                                    {{ $item->lote?->titulo ?? 'Sin título' }}</td>
                                <td style="font-size: 14px; color: #333333; border: 1px solid #cccccc; padding: 10px;">
                                    {{ $item->lote?->descripcion ?? 'Sin descripción' }}</td>
                                <td style="border: 1px solid #cccccc; padding: 10px;">
                                    <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $item->lote?->foto1) }}"
                                        style="width:70px" />
                                </td>
                                <td style="font-size: 14px; color: #333333; border: 1px solid #cccccc; padding: 10px;">
                                    {{ $item->lote?->moneda_signo }} {{ $item->precio_final ?? 'N/A' }}</td>
                            </tr>
                        @endforeach


                        <tr>
                            <td style="text-align: center" colspan="4">Subtotal:
                                ${{ $data['subtotal'] }}
                            </td>
                        </tr>

                        @if ($data['envio'] > 0)
                            <tr>
                                <td style="text-align: center" colspan="4">Envío:
                                    ${{ $data['envio'] }}
                                </td>
                            </tr>
                        @endif

                        @if ($data['descuento'] > 0)
                            <tr>
                                <td style="text-align: center" colspan="4">Depósito:
                                    -${{ $data['descuento'] }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td style="text-align: center" colspan="4"><b>Total:
                                    ${{ $data['total'] }}</b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
