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
                        <td>Comitente: {{ $data['comitente'] }}</td>
                        <td>Fecha: {{ $data['fecha'] }}</td>
                        <td>Contrato: {{ $data['id'] }}</td>
                    </tr>
                </table>

                <br>
                <p style="font-size: 16px; line-height: 1.5; margin: 0 0 20px 0;">{{ $data['message'] }} de contrato.
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
                                Precio</th>
                            <th style="font-size: 14px; color: #333333; text-align: left; border: 1px solid #cccccc;">
                                Moneda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['lotes'] as $item)
                            <tr style="border-bottom: 1px solid #cccccc;">
                                <td style="font-size: 14px; color: #333333; border: 1px solid #cccccc; padding: 10px;">
                                    {{ $item->lote?->titulo ?? 'Sin título' }}</td>
                                <td style="font-size: 14px; color: #333333; border: 1px solid #cccccc; padding: 10px;">
                                    {{ $item->lote?->descripcion ?? 'Sin descripción' }}</td>
                                <td style="font-size: 14px; color: #333333; border: 1px solid #cccccc; padding: 10px;">
                                    {{ $item->precio_base ?? 'N/A' }}</td>
                                <td style="font-size: 14px; color: #333333; border: 1px solid #cccccc; padding: 10px;">
                                    {{ $item->moneda?->titulo ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
