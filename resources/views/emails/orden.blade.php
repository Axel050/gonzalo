<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Detalle de pago</title>
</head>

<body style="margin:0; padding:0; background:#ffffff; font-family:Arial, Helvetica, sans-serif; color:#333333;">

    <!-- FULL WIDTH WRAPPER -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
        <tr>
            <td align="center" style="padding:20px 0px;">

                <!-- MAIN CONTAINER -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" role="presentation"
                    style="width:100%; max-width:600px; background:#F6F2EE; padding-bottom:30px;">

                    <!-- HEADER -->
                    <tr>
                        <td style="padding:25px; text-align:center;">
                            <h1 style="margin:0 0 10px 0;font-size:26px;font-weight:700;letter-spacing:1px;">
                                <a href="https://casablanca.ar" style="text-decoration:none;color:#262626;">
                                    CASABLANCA.AR
                                </a>
                            </h1>
                            <p style="margin:0;font-size:13px;color:#777;">
                                Subastas online · Detalle de pago
                            </p>
                        </td>
                    </tr>

                    <!-- CONTENT CARD -->
                    <tr>
                        <td style="padding:0 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                style="background:#ffffff;border-radius:8px;">
                                <tr>
                                    <td style="padding:20px 15px;">

                                        <!-- RESUMEN -->
                                        <table width="100%" role="presentation"
                                            style="background:#f1f3f4;border-radius:6px;margin-bottom:25px;">
                                            <tr>
                                                <td style="padding:15px;font-size:13px;color:#444;">
                                                    <strong>Orden:</strong> {{ $data['orden_id'] }}
                                                </td>
                                                <td style="padding:15px;font-size:13px;color:#444;text-align:end">
                                                    <strong>Subasta:</strong> {{ $data['subasta_id'] }} –
                                                    {{ $data['subasta_titulo'] }}
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="font-size:15px;line-height:1.6;margin:0 0 25px 0;color:#555;">
                                            Estos son los detalles de los lotes adjudicados y el monto total a abonar.
                                        </p>

                                        <!-- LOTES -->
                                        <h3 style="margin:0 0 15px 0;font-size:18px;color:#111;">
                                            Lotes
                                        </h3>

                                        <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                            style="border-collapse:collapse;font-size:13px;">
                                            <thead>
                                                <tr style="background:#f1f3f4;">
                                                    <th
                                                        style="padding:12px;border-bottom:1px solid #ddd;text-align:left;">
                                                        Título</th>
                                                    <th
                                                        style="padding:12px;border-bottom:1px solid #ddd;text-align:left;">
                                                        Descripción</th>
                                                    <th
                                                        style="padding:12px;border-bottom:1px solid #ddd;text-align:center;">
                                                        Foto</th>
                                                    <th
                                                        style="padding:12px;border-bottom:1px solid #ddd;text-align:center;">
                                                        Precio</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['lotes'] as $item)
                                                    <tr>
                                                        <td style="padding:10px;border-bottom:1px solid #eee;">
                                                            {{ $item->lote?->titulo ?? 'Sin título' }}
                                                        </td>
                                                        <td
                                                            style="padding:10px;border-bottom:1px solid #eee;color:#666;font-size:12px;">
                                                            {{ \Illuminate\Support\Str::limit($item->lote?->descripcion ?? 'Sin descripción', 60) }}
                                                        </td>

                                                        @php
                                                            $route = app()->environment('production')
                                                                ? 'https://casablanca.ar'
                                                                : 'http://127.0.0.1:8000';
                                                        @endphp

                                                        <td
                                                            style="padding:8px;border-bottom:1px solid #eee;text-align:center;">
                                                            @if ($item->lote?->foto1)
                                                                <img src="{{ $route . '/storage/imagenes/lotes/thumbnail/' . $item->lote->foto1 }}"
                                                                    alt="Lote"
                                                                    style="max-height:60px;border-radius:6px;border:1px solid #ddd;">
                                                            @else
                                                                <span style="font-size:11px;color:#999;">N/A</span>
                                                            @endif
                                                        </td>

                                                        <td
                                                            style="padding:10px;border-bottom:1px solid #eee;text-align:center;font-weight:600;">
                                                            {{ $item->lote?->moneda_signo }}
                                                            {{ number_format($item->precio_final ?? 0, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- TOTALES -->
                                        <table width="100%" role="presentation"
                                            style="margin-top:20px;font-size:14px;">
                                            <tr>
                                                <td style="padding:6px 0;">Subtotal</td>
                                                <td style="padding:6px 0;text-align:right;">
                                                    $ {{ number_format($data['subtotal'], 0, ',', '.') }}
                                                </td>
                                            </tr>

                                            @if ($data['envio'] > 0)
                                                <tr>
                                                    <td style="padding:6px 0;">Envío</td>
                                                    <td style="padding:6px 0;text-align:right;">
                                                        $ {{ number_format($data['envio'], 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endif

                                            @if ($data['descuento'] > 0)
                                                <tr>
                                                    <td style="padding:6px 0;">Devolución de garantia</td>
                                                    <td style="padding:6px 0;text-align:right;">
                                                        - $ {{ number_format($data['descuento'], 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            @endif

                                            <tr>
                                                <td
                                                    style="padding:10px 0;font-weight:700;font-size:16px;border-top:1px solid #ddd;">
                                                    Total a pagar
                                                </td>
                                                <td
                                                    style="padding:10px 0;text-align:right;font-weight:700;font-size:16px;border-top:1px solid #ddd;">
                                                    $ {{ number_format($data['total'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- DATOS DE PAGO -->
                                        <table width="100%" role="presentation"
                                            style="margin-top:30px;background:#f1f3f4;border-radius:6px;">
                                            <tr>
                                                <td style="padding:18px;font-size:14px;color:#333;line-height:22px;">
                                                    <strong style="font-size: 19px;">Datos para el pago</strong><br><br>
                                                    Titular: <b>Gonzalo San Martín Vivares</b><br>
                                                    Cuenta: <b>014-025920/4</b><br>
                                                    CBU: <b>0720014488000002592040</b><br>
                                                    Alias: <b>casablanca.ar</b>
                                                </td>
                                            </tr>
                                        </table>

                                        @if ($data['faltantes'])
                                            <table width="100%" role="presentation"
                                                style="margin-top:25px;background:#fff4e5;border-radius:6px;">
                                                <tr>
                                                    <td style="padding:15px;text-align:left;">
                                                        <p style="margin:0;font-size:16px;color:#663c00;">
                                                            ⚠️ No tenemos todos tus datos.
                                                        </p>
                                                        @foreach ($data['faltantes'] as $item)
                                                            <ul style="font-size: 15px">
                                                                <li>{{ $item }}</li>
                                                            </ul>
                                                        @endforeach
                                                        <p style="margin:8px 0 0;font-size:15px;">
                                                            Podés cargarlo desde
                                                            <a href="{{ route('adquirentes.perfil') }}"
                                                                style="color:#1a73e8;text-decoration:none;">tu
                                                                perfil</a>
                                                            o
                                                            escribirnos a
                                                            <a href="mailto:info@casablanca.ar"
                                                                style="color:#1a73e8;text-decoration:none;">
                                                                info@casablanca.ar
                                                            </a>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        @endif


                                    </td>
                                </tr>
                            </table>





                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="padding:25px 20px 0 20px;">
                            <p style="margin:0;font-size:11px;color:#888;text-align:center;">
                                Casablanca.ar · Subastas online <br>

                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
