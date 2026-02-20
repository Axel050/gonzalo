<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Verificá tu email · CASABLANCA.AR</title>
</head>

<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, Helvetica, sans-serif; color:#333333;">

    <!-- FULL WIDTH WRAPPER -->
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
                                    <img src="https://casablanca.ar/img/mail.png" alt="Casablanca.ar"
                                        style="height:30px;">
                                </a>
                            </h1>
                            <p style="margin:0;font-size:13px;color:#777;">
                                Subastas online · Verificación de email
                            </p>
                        </td>
                    </tr>

                    <!-- CONTENT CARD -->
                    <tr>
                        <td style="padding:0 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                style="background:#ffffff;border-radius:8px;">
                                <tr>
                                    <td style="padding:30px 25px; text-align:center;">

                                        <h2 style="margin:0 0 15px 0;font-size:22px;color:#262626;">
                                            ¡Bienvenido!
                                        </h2>

                                        <p style="font-size:15px;line-height:1.6;margin:0 0 25px 0;color:#555;">
                                            Para activar tu cuenta necesitás verificar tu dirección de email.
                                            Solo tenés que hacer clic en el botón de abajo.
                                        </p>

                                        <!-- CTA -->
                                        <table align="center" role="presentation" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td style="background:#262626;border-radius:25px;">
                                                    <a href="{{ $url }}"
                                                        style="display:inline-block;padding:14px 32px;font-size:16px;font-weight:600;color:#ffffff;text-decoration:none;">
                                                        Verificar email
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="margin:25px 0 0;font-size:13px;color:#777;line-height:1.5;">
                                            Si no creaste una cuenta en Casablanca.ar, podés ignorar este mensaje.
                                        </p>

                                        <!-- FALLBACK LINK -->
                                        <table width="100%" role="presentation"
                                            style="margin-top:25px;background:#f1f3f4;border-radius:6px;">
                                            <tr>
                                                <td style="padding:15px;font-size:13px;color:#555;">
                                                    Si el botón no funciona, copiá y pegá este enlace en tu navegador:
                                                    <br><br>
                                                    <a href="{{ $url }}"
                                                        style="color:#1a73e8;text-decoration:none;word-break:break-all;">
                                                        {{ $url }}
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
                                © {{ date('Y') }} Casablanca.ar · Subastas online
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
