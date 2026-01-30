<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Devolución de garantía</title>
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
                                Subastas online - Devolución
                            </p>

                        </td>
                    </tr>

                    <!-- CONTENT CARD -->
                    <tr>
                        <td style="padding:0 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                style="background:#ffffff;border-radius:8px;">
                                <tr>
                                    <td style="padding:30px 15px;text-align:center;">

                                        <h2 style="margin:0 0 20px 0;font-size:22px;color:#111;font-weight:600;">
                                            Devolución de garantía
                                        </h2>

                                        <p style="margin:10px 0;font-size:15px;color:#555;">
                                            <strong>Subasta:</strong> {{ $data['subasta'] }}
                                        </p>

                                        <p style="margin:10px 0;font-size:15px;color:#555;">
                                            <strong>Monto de la garantía:</strong><br>
                                            <span style="font-size:20px;font-weight:600;color:#111;">
                                                $ {{ number_format($data['monto_garantia'], 0, ',', '.') }}
                                            </span>
                                        </p>

                                        {{-- ALIAS BANCARIO --}}
                                        @if ($data['alias_bancario'])
                                            <table width="100%" role="presentation"
                                                style="margin-top:25px;background:#f1f3f4;border-radius:6px;">
                                                <tr>
                                                    <td style="padding:15px;text-align:center;">
                                                        <p style="margin:0;font-size:14px;color:#333;">
                                                            <strong>Alias bancario:</strong><br>
                                                            <span style="font-size:16px;font-weight:600;">
                                                                {{ $data['alias_bancario'] }}
                                                            </span>
                                                        </p>
                                                        <p style="margin:10px 0 0;font-size:15px;color:#777;">
                                                            Si el alias no es correcto, escribinos a
                                                            <a href="mailto:info@casablanca.ar"
                                                                style="color:#1a73e8;text-decoration:none;">
                                                                info@casablanca.ar
                                                            </a>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </table>
                                        @else
                                            <table width="100%" role="presentation"
                                                style="margin-top:25px;background:#fff4e5;border-radius:6px;">
                                                <tr>
                                                    <td style="padding:15px 5px;text-align:left;">
                                                        <p style="margin:0;font-size:14px;color:#663c00;">
                                                            ⚠️ No tenemos registrado tu alias bancario.
                                                        </p>
                                                        <p style="margin:8px 0 0;font-size:15px;">
                                                            Podés cargarlo desde
                                                            <a href="{{ route('adquirentes.perfil') }}"
                                                                style="color:#1a73e8;text-decoration:none;">tu
                                                                perfil</a>
                                                            o escribirnos a
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

                    <tr>
                        <td style="padding:25px 20px 0 20px;">
                            <p style="margin:0;font-size:11px;color:#888;text-align:center;">
                                Casablanca.ar · Subastas online ·<br>
                            </p>
                        </td>
                    </tr>


                </table>

            </td>
        </tr>


    </table>

</body>

</html>
