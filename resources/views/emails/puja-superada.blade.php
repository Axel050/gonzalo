<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
</head>

<body style="margin:0; padding:0; background:#ffffff; font-family: Arial, Helvetica, sans-serif; color:#333333;">

    <!-- FULL WIDTH WRAPPER -->
    <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
        <tr>
            <td align="center" style="padding:20px;">

                <!-- MAIN CONTAINER (FLUID) -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" role="presentation"
                    style="width:100%; max-width:600px; background:#F6F2EE; padding-bottom:30px;">

                    <!-- HEADER -->
                    <tr>
                        <td style="padding:20px; text-align:center;">

                            <h1 style="font-size:24px; color:#262626; margin:0 0 20px 0;">
                                CASABLANCA.AR
                            </h1>

                            <h3 style="font-size:22px; color:#FF530D; margin:20px 0;">
                                ¡Tu puja fue superada!
                            </h3>

                        </td>
                    </tr>

                    <!-- PRODUCT CONTAINER -->
                    <tr>
                        <td>

                            <table width="300" cellpadding="0" cellspacing="0" border="0" role="presentation"
                                align="center"
                                style="width:100%; max-width:300px; background:#EDE7E1; padding:15px; margin-top:10px; border:1px solid #000;">

                                <!-- TÍTULO -->
                                <tr>
                                    <td style="font-size:19px; text-align:left; font-weight:700;">
                                        {{ $data['titulo'] }}
                                    </td>
                                </tr>

                                <!-- IMAGEN -->
                                <tr>
                                    <td style="text-align:center; padding-top:10px;">

                                        @php
                                            if (app()->environment('production')) {
                                                $route = 'https://casablanca.ar';
                                            } else {
                                                $route = 'http://127.0.0.1:8000';
                                            }
                                        @endphp

                                        <img src="{{ $route . '/storage/imagenes/lotes/thumbnail/' . $data['foto'] }}"
                                            alt=""
                                            style="width:100%; max-width:250px; height:auto; display:block; margin:0 auto;" />

                                    </td>
                                </tr>

                                <!-- TAGS -->
                                <tr>
                                    <td style="padding-top:10px; text-align:left;">

                                        <span
                                            style="display:inline-block; padding:5px 10px; border:1px solid #000; border-radius:15px; font-size:14px; margin-right:10px;">
                                            Lote: {{ $data['lote_id'] }}
                                        </span>

                                        <span
                                            style="display:inline-block; padding:5px 10px; border:1px solid #000; border-radius:15px; font-size:14px;">
                                            Subasta: {{ $data['subasta'] }}
                                        </span>

                                    </td>
                                </tr>

                                <!-- MONTO -->
                                <tr>
                                    <td style="text-align:center;">
                                        <p style="margin-top:20px; font-size:20px; font-weight:800;">
                                            Oferta actual: ${{ $data['monto'] }}
                                        </p>
                                    </td>
                                </tr>

                            </table>

                            <!-- BOTÓN -->
                            <table cellpadding="0" cellspacing="0" align="center" role="presentation"
                                style="margin-top:40px;">
                                <tr>
                                    <td bgcolor="#262626" style="border-radius:20px;">

                                        <a href="https://www.casablanca.ar/pantalla-pujas"
                                            style="display:inline-block; padding:12px 20px; color:#ffffff; text-decoration:none; font-size:18px; font-weight:700; vertical-align:middle;">
                                            Ir a pujas

                                            <span
                                                style="display:inline-block; font-size: 45px; line-height: 10px; height: 20px; vertical-align: middle;  padding:0; margin:0;margin-left:40px">
                                                →
                                            </span>
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
