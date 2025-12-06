<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Verifica tu email en {{ $appName }}</title>
</head>

<body
    style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, Helvetica, sans-serif; -webkit-font-smoothing: antialiased; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%"
        style="border-collapse: collapse;">
        <tr>
            <td align="center" style="padding: 0;">
                <!-- Contenedor principal (ancho fijo para emails) -->
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border-collapse: collapse; max-width: 600px; background-color: #ffffff;">
                    <!-- Header -->
                    <tr>
                        <td
                            style="padding: 40px 30px 20px; text-align: center; background-color: #ffffff; border-bottom: 1px solid #e9ecef;">
                            <h1 style="margin: 0; font-size: 24px; font-weight: bold; color: #333333;">
                                ¡Hola!</h1>
                            <p style="margin: 10px 0 0; font-size: 16px; color: #666666;">Bienvenido a
                                {{ $appName }}</p>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 30px; text-align: center; background-color: #ffffff;">
                            <p style="margin: 0 0 20px; font-size: 16px; line-height: 1.5; color: #333333;">
                                Por favor, haz clic en el botón de abajo para verificar tu dirección de email y activar
                                tu cuenta.
                            </p>

                            <!-- Botón centrado con tabla -->
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0"
                                style="border-collapse: collapse; margin: 0 auto;">
                                <tr>
                                    <td align="center" style="padding: 0;">
                                        <a href="{{ $url }}"
                                            style="background-color: #007bff; color: #ffffff !important; padding: 15px 30px; text-decoration: none; border-radius: 5px; font-size: 16px; font-weight: bold; display: inline-block; border: none; min-width: 150px;">
                                            Verificar Email
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 20px 0 0; font-size: 14px; color: #666666;">
                                Si no creaste una cuenta, puedes ignorar este mensaje de forma segura.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            style="padding: 20px 30px 40px; text-align: center; background-color: #f8f9fa; border-top: 1px solid #e9ecef;">
                            <p style="margin: 0 0 10px; font-size: 14px; color: #666666;">
                                Si tienes problemas con el botón, copia y pega esta URL en tu navegador:<br>
                                <a href="{{ $url }}"
                                    style="color: #007bff; text-decoration: underline;">{{ $url }}</a>
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #999999;">
                                Atentamente,<br>
                                El equipo de {{ $appName }}
                            </p>
                            <hr style="border: none; border-top: 1px solid #e9ecef; margin: 20px 0;">
                            <p style="margin: 0; font-size: 12px; color: #999999;">
                                &copy; {{ date('Y') }} {{ $appName }}. Todos los derechos reservados.<br>
                                <a href="{{ config('app.url', 'https://casablanca.ar') }}"
                                    style="color: #007bff; text-decoration: underline;">casablanca.ar</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
