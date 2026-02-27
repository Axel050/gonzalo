<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="x-apple-disable-message-reformatting">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Resultado de Subasta</title>
</head>

<body style="margin:0; padding:0; background:#ffffff; font-family:Arial, Helvetica, sans-serif; color:#333333;">

    <table width="100%" cellpadding="0" cellspacing="0" border="0" role="presentation">
        <tr>
            <td align="center" style="padding:20px 0px;">

                <table width="600" cellpadding="0" cellspacing="0" border="0" role="presentation"
                    style="width:100%; max-width:600px; background:#F6F2EE; padding-bottom:30px;">

                    <!-- HEADER -->
                    <tr>
                        <td style="padding:25px; text-align:center;">
                            <h1 style="margin:0 0 10px 0;font-size:26px;font-weight:700;">
                                <a href="https://casablanca.ar" style="text-decoration:none;color:#262626;">
                                    <img src="https://casablanca.ar/img/mail.png" alt="Casablanca.ar"
                                        style="height:30px;">
                                </a>
                            </h1>
                            <p style="margin:0;font-size:13px;color:#777;">
                                Subastas online · Resultado final
                            </p>
                        </td>
                    </tr>


                    @php
                        $route = app()->environment('production') ? 'https://casablanca.ar' : 'http://127.0.0.1:8000';
                    @endphp


                    <!-- CONTENT -->
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
                                                    <strong>Comitente:</strong>
                                                    {{ $data['comitente']->nombre }}
                                                    {{ $data['comitente']->apellido }}
                                                </td>
                                                <td style="padding:15px;font-size:13px;color:#444;text-align:end">
                                                    <strong>Subasta:</strong>
                                                    {{ $data['subasta']->id }}
                                                    – {{ $data['subasta']->titulo }}
                                                </td>
                                            </tr>
                                        </table>

                                        <p style="font-size:15px;line-height:1.6;margin:0 0 25px 0;color:#555;">
                                            Estos son los resultados finales de sus lotes en la subasta.
                                        </p>

                                        <!-- LOTES VENDIDOS -->
                                        @if ($data['lotes_vendidos']->count())
                                            <h3 style="margin:0 0 15px 0;font-size:18px;color:#111;">
                                                ✅ Lotes Vendidos
                                            </h3>

                                            <table width="100%" cellpadding="0" cellspacing="0"
                                                style="border-collapse:collapse;font-size:13px;">
                                                <thead>
                                                    <tr style="background:#f1f3f4;">
                                                        <th style="padding:12px;text-align:left;">Lote</th>
                                                        <th style="padding:12px;text-align:left;">Título</th>
                                                        <th style="padding:12px;text-align:left;">Foto</th>
                                                        <th style="padding:12px;text-align:center;">Precio final</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['lotes_vendidos'] as $lote)
                                                        <tr>
                                                            <td style="padding:10px;border-bottom:1px solid #eee;">
                                                                #{{ $lote->id }}
                                                            </td>
                                                            <td style="padding:10px;border-bottom:1px solid #eee;">
                                                                {{ $lote->titulo }}
                                                            </td>
                                                            <td style="padding:10px;border-bottom:1px solid #eee;">
                                                                @if ($lote->foto1)
                                                                    <img src="{{ $route . '/storage/imagenes/lotes/thumbnail/' . $lote->foto1 }}"
                                                                        alt="Lote"
                                                                        style="max-height:50px;border-radius:6px;border:1px solid #ddd;">
                                                                @else
                                                                    N/A
                                                                @endif
                                                            <td
                                                                style="padding:10px;border-bottom:1px solid #eee;text-align:center;font-weight:600;">
                                                                {{ $lote->moneda_signo }}
                                                                {{ number_format($lote->precio_final ?? ($lote->getPujaFinal()?->monto ?? 0), 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif






                                        @if ($data['total_vendido'] > 0)
                                            <!-- RESUMEN ECONÓMICO -->
                                            <table width="100%" role="presentation"
                                                style="margin-top:30px;font-size:14px;">
                                                <tr>
                                                    <td style="padding:6px 0;">Total vendido</td>
                                                    <td style="padding:6px 0;text-align:right;">
                                                        $ {{ number_format($data['total_vendido'], 0, ',', '.') }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style="padding:6px 0;">
                                                        Comisión
                                                        ({{ number_format($data['porcentaje_comision'], 0) }}%)
                                                    </td>
                                                    <td style="padding:6px 0;text-align:right;">
                                                        - $ {{ number_format($data['monto_comision'], 0, ',', '.') }}
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td
                                                        style="padding:10px 0;font-weight:700;font-size:16px;border-top:1px solid #ddd;">
                                                        Neto estimado a liquidar
                                                    </td>
                                                    <td
                                                        style="padding:10px 0;text-align:right;font-weight:700;font-size:16px;border-top:1px solid #ddd;">
                                                        $ {{ number_format($data['total_neto'], 0, ',', '.') }}
                                                    </td>
                                                </tr>
                                            </table>

                                            <p style="margin-top:25px;font-size:14px;color:#555;line-height:22px;">
                                                En breve nos estaremos contactando para coordinar la liquidación
                                                correspondiente.
                                            </p>
                                        @endif




                                        <!-- LOTES NO VENDIDOS -->
                                        @if ($data['lotes_no_vendidos']->count())
                                            <h3 style="margin:30px 0 15px 0;font-size:18px;color:#111;">
                                                ❌ Lotes No Vendidos
                                            </h3>



                                            <table width="100%" cellpadding="0" cellspacing="0"
                                                style="border-collapse:collapse;font-size:13px;">
                                                <thead>
                                                    <tr style="background:#f1f3f4;">
                                                        <th style="padding:12px;text-align:left;">Lote</th>
                                                        <th style="padding:12px;text-align:left;">Título</th>
                                                        <th style="padding:12px;text-align:left;">Foto</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($data['lotes_no_vendidos'] as $lote)
                                                        <tr>
                                                            <td style="padding:10px;border-bottom:1px solid #eee;">
                                                                #{{ $lote->id }}
                                                            </td>
                                                            <td style="padding:10px;border-bottom:1px solid #eee;">
                                                                {{ $lote->titulo }}
                                                            </td>
                                                            <td style="padding:10px;border-bottom:1px solid #eee;">
                                                                @if ($lote->foto1)
                                                                    <img src="{{ $route . '/storage/imagenes/lotes/thumbnail/' . $lote->foto1 }}"
                                                                        alt="Lote"
                                                                        style="max-height:50px;border-radius:6px;border:1px solid #ddd;">
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif


                                        @if ($data['lotes_no_vendidos']->count() > 0)
                                            <p style="margin-top:25px;font-size:14px;color:#555;line-height:22px;">
                                                En esta subasta hubo {{ $data['lotes_no_vendidos']->count() }} lote(s)
                                                sin
                                                ofertas.
                                                Puede volver a ofrecerlos en futuras subastas o pedir la devolución.
                                                Contactese con nosotros para más información.
                                            </p>
                                        @endif

                                        <p> Ante cualquier consulta puede escribirnos a
                                            <a href="mailto:info@casablanca.ar"
                                                style="color:#1a73e8;text-decoration:none;">
                                                info@casablanca.ar
                                            </a>.
                                        </p>

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
