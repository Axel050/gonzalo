<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Contrato</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #333;
            font-size: 13px;
        }

        .container {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header img {
            height: 30px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
        }

        .resumen {
            background: #f1f3f4;
            padding: 10px;
            margin-bottom: 20px;
        }

        .resumen td {
            font-size: 12px;
        }

        h3 {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-bottom: 20px;
        }

        th,
        td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background: #f1f3f4;
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .contrato {
            margin-top: 25px;
            border: 1px solid #ddd;
            padding: 15px;
            background: #fafafa;
            page-break-inside: auto;
        }

        .contrato h2 {
            text-align: center;
            margin-bottom: 15px;
        }

        .contrato p {
            text-align: justify;
            line-height: 1.6;
        }

        .page-break {
            page-break-before: always;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- HEADER -->
        <div class="header">
            <img src="{{ public_path('img/mail.png') }}" alt="Casablanca.ar">
            <p>Subastas online - Contrato</p>
        </div>

        <!-- CARD -->
        <div class="card">

            <!-- RESUMEN -->
            <table class="resumen">
                <tr>
                    <td><strong>Contrato Nº:</strong> #{{ $data['id'] }}</td>
                    <td style="text-align:right;"><strong>Fecha:</strong> {{ $data['fecha'] }}</td>
                </tr>
            </table>

            <p>
                Hola, estos son los detalles de los lotes que serán incluidos en una futura subasta.
            </p>

            <!-- LOTES -->
            <h3>Lotes incluidos</h3>

            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th class="text-center">Precio base</th>
                        <th class="text-center">Foto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['lotes'] as $item)
                        <tr>
                            <td>
                                {{ $item->lote?->titulo ?? 'Sin título' }}
                            </td>
                            <td>
                                {{ \Illuminate\Support\Str::limit($item->lote?->descripcion ?? 'Sin descripción', 60) }}
                            </td>
                            <td class="text-center">
                                $ {{ number_format($item->precio_base ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                @if ($item->lote?->foto1)
                                    <img src="{{ public_path('storage/imagenes/lotes/thumbnail/' . $item->lote->foto1) }}"
                                        style="max-height:50px;max-width:50px;">
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <br><br>
        <br><br>

        <!-- CONTRATO (FUERA DE TABLAS) -->
        <div class="contrato">

            <h2>Contrato</h2>

            <p>
                Entre el Sr./Sra. <b>{{ $data['comitente'] }}</b>, CUIT
                <b>{{ $data['cuit'] }}</b>, domiciliado en <b>{{ $data['domicilio'] }}</b>,
                en adelante “El
                comitente” y el Sr. Gonzalo San Martin Vivares, CUIT 20139153503,
                domiciliado en Franklin D. Roosevelt 2225, CABA, en su calidad de
                titular del sitio de subastas online denominado Casablanca.ar, en
                adelante “Casablanca.ar” celebran el presente contrato de comisión y
                mandato para la venta de bienes mediante subasta online, bajo las
                siguientes cláusulas:
            </p>
            <br><br>
            <p>
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
                por "Casablanca.ar" serán del <b>{{ $data['comision'] }}%</b> del
                valor de la oferta
                final, o
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
            </p>

        </div>

    </div>

</body>

</html>
