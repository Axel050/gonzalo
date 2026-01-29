<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contrato</title>
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
                                Subastas online - Contrato.
                            </p>
                        </td>
                    </tr>

                    <!-- CONTENT CARD -->
                    <tr>
                        <td style="padding:0 10px;">
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation"
                                style="background:#ffffff;border-radius:8px;">
                                <tr>
                                    <td style="padding:30px 15px;">

                                        <!-- RESUMEN -->
                                        <table width="100%" role="presentation"
                                            style="background:#f1f3f4;border-radius:6px;margin-bottom:25px;">
                                            <tr>
                                                <td style="padding:15px;font-size:13px;color:#444;">
                                                    <strong>Contrato Nº:</strong> #{{ $data['id'] }}<br>
                                                </td>
                                                <td style="padding:15px;font-size:13px;color:#444;text-align:end">
                                                    <strong>Fecha:</strong> {{ $data['fecha'] }}<br>
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="font-size:15px;line-height:1.6;margin:0 0 25px 0;color:#555;">
                                            Hola, estos son los detalles de los lotes que serán incluidos en una futura
                                            subasta.
                                        </p>

                                        <!-- LOTES -->
                                        <h3 style="margin:0 0 15px 0;font-size:18px;color:#111;">
                                            Lotes incluidos
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
                                                        Precio base</th>
                                                    <th
                                                        style="padding:12px;border-bottom:1px solid #ddd;text-align:center;">
                                                        Foto</th>
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
                                                        <td
                                                            style="padding:10px;border-bottom:1px solid #eee;text-align:center;font-weight:600;">
                                                            $ {{ number_format($item->precio_base ?? 0, 0, ',', '.') }}
                                                        </td>
                                                        <td
                                                            style="padding:8px;border-bottom:1px solid #eee;text-align:center;">
                                                            @php
                                                                $route = app()->environment('production')
                                                                    ? 'https://casablanca.ar'
                                                                    : 'http://127.0.0.1:8000';
                                                            @endphp

                                                            @if ($item->lote?->foto1)
                                                                <img src="{{ $route . '/storage/imagenes/lotes/thumbnail/' . $item->lote->foto1 }}"
                                                                    alt="Lote"
                                                                    style="max-height:60px;border-radius:6px;border:1px solid #ddd;">
                                                            @else
                                                                <span style="font-size:11px;color:#999;">N/A</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <!-- CONTRATO LEGAL -->
                                        <table width="100%" role="presentation"
                                            style="margin-top:35px;background:#fafafa;border:1px solid #e0e0e0;">
                                            <tr>
                                                <td style="padding:18px;text-align:center;font-size:18px;color:#333;">
                                                    <strong>Contrato</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="padding:10px;font-size:13px;line-height:1.6;color:#555;text-align:justify;">
                                                    Entre el Sr./Sra. <b>{{ $data['comitente'] }}</b>, CUIT
                                                    <b>{{ $data['cuit'] }}</b>,
                                                    domiciliado en <b>{{ $data['domicilio'] }}</b>, en adelante “El
                                                    comitente” y el Sr. Gonzalo San Martin Vivares, CUIT 20139153503,
                                                    domiciliado en Franklin D. Roosevelt 2225, CABA, en su calidad de
                                                    titular del sitio de subastas online denominado Casablanca.ar, en
                                                    adelante “Casablanca.ar” celebran el presente contrato de comisión y
                                                    mandato para la venta de bienes mediante subasta online, bajo las
                                                    siguientes cláusulas:

                                                    <br><br>

                                                    I.- El presente contrato formaliza las Instrucciones, Términos y
                                                    Condiciones que "El comitente" leyó y aceptó en el momento de
                                                    registrarse y que forman parte del presente contrato.<br>
                                                    II.- "El comitente" entrega y "Casablanca.ar" recibe en su
                                                    domicilio, los bienes descriptos más arriba a los efectos de que
                                                    "Casablanca.ar" los presente en su sitio de subastas online para ser
                                                    vendidos por cuenta y orden de "El comitente". <br>
                                                    III.- Los lotes deberán permanecer en el domicilio de
                                                    "Casablanca.ar" hasta que se
                                                    entreguen a los compradores. En el caso de no haber recibido ofertas
                                                    por alguno de ellos, "El comitente" podrá retirarlos o dejarlos para
                                                    futuras subastas para lo cual se conformará un nuevo contrato. <br>
                                                    IV.-Las fechas, duración y horarios de las subastas serán
                                                    establecidos por "Casablanca.ar".<br>
                                                    V.- Los honorarios por los servicios prestados
                                                    por "Casablanca.ar" serán del 20% del valor de la oferta final, o
                                                    precio de martillo de cada lote. <br>
                                                    VI.- La liquidación se efectuará
                                                    mediante transferencia bancaria dentro de los diez (10) días hábiles
                                                    posteriores a la finalización de la subasta. <br>
                                                    VII.- En el eventual
                                                    caso de que un comprador no formalice el pago de su compra, la
                                                    responsabilidad de “Casablanca.ar” se limita a devolver el bien a
                                                    “El comitente”.<br>
                                                    VIII.- “Casablanca.ar” no será responsable por
                                                    pérdidas o daños derivados de caso fortuito o fuerza mayor, salvo
                                                    dolo o culpa grave.<br>

                                                    IX.- “El comitente” puede solicitar la
                                                    contratación de un seguro teniendo en cuenta la cláusula anterior.
                                                    Este seguro será a cargo de “El comitente”. <br>
                                                    X.- Los gastos
                                                    extraordinarios (logística, restauración, seguros, etc.) serán a
                                                    cargo del Comitente, previa aceptación expresa. <br>
                                                    XI.- La vigencia de
                                                    este contrato se fija en la Ciudad Autónoma de Buenos Aires, desde
                                                    la fecha en que "El comitente" recibe el correo electrónico que lo
                                                    contiene hasta que "Casablanca.ar" haya liquidado los lotes vendidos
                                                    o devueltos los que quedaron sin oferta.
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
