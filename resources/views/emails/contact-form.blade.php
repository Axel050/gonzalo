<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Nuevo mensaje de contacto · CASABLANCA.AR</title>
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
                                    CASABLANCA.AR
                                </a>
                            </h1>
                            <p style="margin:0;font-size:13px;color:#777;">
                                Mensaje desde el formulario de contacto
                            </p>
                        </td>
                    </tr>

                    <!-- CONTENT CARD -->
                    <tr>
                        <td style="padding:0 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                style="background:#ffffff;border-radius:8px;">
                                <tr>
                                    <td style="padding:30px 25px;">

                                        <h2 style="margin:0 0 20px 0;font-size:20px;color:#262626;text-align:center;">
                                            📬 Mensaje recibido
                                        </h2>

                                        <!-- DATOS -->
                                        <table width="100%" role="presentation"
                                            style="background:#f1f3f4;border-radius:6px;margin-bottom:25px;">
                                            <tr>
                                                <td style="padding:15px;font-size:14px;color:#444;">
                                                    <strong>Nombre:</strong> {{ $data['name'] }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding:15px;font-size:14px;color:#444;">
                                                    <strong>Email:</strong>
                                                    <a href="mailto:{{ $data['email'] }}"
                                                        style="color:#1a73e8;text-decoration:none;">
                                                        {{ $data['email'] }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- MENSAJE -->
                                        <table width="100%" role="presentation"
                                            style="border:1px solid #e0e0e0;border-radius:6px;">
                                            <tr>
                                                <td style="padding:18px;font-size:15px;line-height:1.6;color:#333;">
                                                    {!! nl2br(e($data['message'])) !!}
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- CTA RESPONDER -->
                                        <table align="center" role="presentation" cellpadding="0" cellspacing="0"
                                            style="margin-top:30px;">
                                            <tr>
                                                <td style="background:#262626;border-radius:25px;">
                                                    <a href="mailto:{{ $data['email'] }}"
                                                        style="display:inline-block;padding:12px 28px;font-size:15px;font-weight:600;color:#ffffff;text-decoration:none;">
                                                        Responder mensaje
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
                                © {{ date('Y') }} Casablanca.ar · Mensaje interno del sitio
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
