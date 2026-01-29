<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Puja superada</title>
</head>

<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, Helvetica, sans-serif; color:#333333;">

    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding:20px 0;">

                <!-- MAIN CONTAINER -->
                <table width="600" cellpadding="0" cellspacing="0" role="presentation"
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
                                Subastas online · Puja superada
                            </p>
                        </td>
                    </tr>

                    <!-- CONTENT CARD -->
                    <tr>
                        <td style="padding:0 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                style="background:#ffffff;border-radius:8px;">
                                <tr>
                                    <td style="padding:25px 20px;">

                                        <!-- TITLE -->
                                        <h2 style="margin:0 0 15px 0;font-size:22px;color:#FF530D;">
                                            Tu puja fue superada
                                        </h2>

                                        <p style="font-size:15px;line-height:1.6;margin:0 0 25px 0;color:#555;">
                                            Otro usuario realizó una oferta mayor por este lote. Todavía estás a tiempo
                                            de volver a pujar si querés quedarte con él.
                                        </p>

                                        <!-- LOTE CARD -->
                                        <table width="100%" role="presentation"
                                            style="background:#f1f3f4;border-radius:6px;margin-bottom:30px;">
                                            <tr>
                                                <td
                                                    style="padding:15px;font-size:16px;font-weight:600;text-align:center">
                                                    {{ $data['titulo'] }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding:10px;text-align:center;">
                                                    @php
                                                        $route = app()->environment('production')
                                                            ? 'https://casablanca.ar'
                                                            : 'http://127.0.0.1:8000';
                                                    @endphp

                                                    <img src="{{ $route . '/storage/imagenes/lotes/thumbnail/' . $data['foto'] }}"
                                                        alt="Lote"
                                                        style="max-height:200px;border-radius:6px;border:1px solid #ddd;">
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding:10px;text-align:center">
                                                    <span
                                                        style="display:inline-block;padding:5px 12px;border:1px solid #ccc;border-radius:15px;font-size:13px;margin-right:8px;">
                                                        Lote #{{ $data['lote_id'] }}
                                                    </span>

                                                    <span
                                                        style="display:inline-block;padding:5px 12px;border:1px solid #ccc;border-radius:15px;font-size:13px;">
                                                        Subasta {{ $data['subasta'] }}
                                                    </span>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="padding:15px;text-align:center;">
                                                    <p style="margin:0;font-size:18px;font-weight:700;">
                                                        Oferta actual:
                                                        ${{ number_format($data['monto'], 0, ',', '.') }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- CTA -->
                                        <table align="center" role="presentation" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="background:#262626;border-radius:25px;">
                                                    <a href="https://www.casablanca.ar/pantalla-pujas"
                                                        style="display:inline-block;padding:14px 28px;font-size:16px;font-weight:600;color:#ffffff;text-decoration:none;">
                                                        Volver a pujar →
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td style="padding:25px 20px 0 20px;">
                            <p style="margin:0;font-size:11px;color:#888;text-align:center;">
                                Casablanca.ar · Subastas online
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
