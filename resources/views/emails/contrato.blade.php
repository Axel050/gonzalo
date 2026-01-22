<!DOCTYPE html>
<html>

<head>
    <title>Contrato</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style type="text/css">
        /* Estilos para móviles */
        @media only screen and (max-width: 600px) {
            .main-table {
                width: 100% !important;
            }

            .content-padding {
                padding: 10px !important;
            }

            .lote-table {
                font-size: 12px !important;
            }

            .lote-table th,
            .lote-table td {
                padding: 5px !important;
            }

            .img-lote {
                width: 40px !important;
            }
        }

        .scroll-container {
            -webkit-overflow-scrolling: touch;
            overflow-x: auto;
        }

        img {
            max-width: 100% !important;
            height: auto !important;
            display: block;
        }
    </style>
</head>

<body style="font-family: Arial, sans-serif; color: #333333; margin: 0; padding: 0; background-color: #f4f4f4;">
    <!-- Contenedor principal centrado -->
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" class="main-table"
        style="background-color: #ffffff; border: 1px solid #dddddd; margin-top: 20px; margin-bottom: 20px;">
        <tr>
            <td class="content-padding" style="padding: 30px;">

                <h1 style="font-size: 24px; color: #1a73e8; margin: 0 0 20px 0; text-align: center; font-weight: bold;">
                    CASABLANCA.AR</h1>

                <table width="100%" style="font-size: 13px; color: #666;">
                    <tr>
                        <td style="padding-bottom: 5px;"><strong>Comitente:</strong> {{ $data['comitente'] }}</td>
                        <td style="padding-bottom: 5px; text-align: right;"><strong>Fecha:</strong> {{ $data['fecha'] }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Contrato:</strong> #{{ $data['id'] }}</td>
                        <td></td>
                    </tr>
                </table>




                <hr style="border: 0; border-top: 1px solid #eeeeee; margin: 20px 0;">

                <p style="font-size: 15px; line-height: 1.5; margin: 0 0 20px 0;">
                    {{ $data['message'] }} de contrato.
                </p>

                <p style="font-size: 16px; font-weight: bold; margin: 0 0 10px 0;">Lotes:</p>

                <!-- Contenedor con scroll solo si es estrictamente necesario -->
                <div class="scroll-container">
                    <table class="lote-table" width="100%" cellpadding="0" cellspacing="0"
                        style="border-collapse: collapse; border: 1px solid #cccccc; font-size: 13px; table-layout: fixed;">
                        <thead>
                            <tr style="background-color: #f8f8f8;">
                                <th style="text-align: left; padding: 10px; border: 1px solid #cccccc; width: 25%;">
                                    Título</th>
                                <th style="text-align: left; padding: 10px; border: 1px solid #cccccc; width: 35%;">
                                    Descripción</th>
                                <th style="text-align: center; padding: 10px; border: 1px solid #cccccc; width: 20%;">
                                    Precio</th>
                                <th style="text-align: center; padding: 10px; border: 1px solid #cccccc; width: 20%;">
                                    Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['lotes'] as $item)
                                <tr>
                                    <td style="padding: 10px; border: 1px solid #cccccc; word-break: break-word;">
                                        {{ $item->lote?->titulo ?? 'Sin título' }}
                                    </td>
                                    <td
                                        style="padding: 10px; border: 1px solid #cccccc; word-break: break-word; color: #666; font-size: 12px;">
                                        {{ \Illuminate\Support\Str::limit($item->lote?->descripcion ?? 'Sin descripción', 60) }}
                                    </td>
                                    <td style="padding: 10px; border: 1px solid #cccccc; text-align: center;">
                                        {{ $item->precio_base ?? 'N/A' }}
                                    </td>


                                    @php
                                        $route = app()->environment('production')
                                            ? 'https://casablanca.ar'
                                            : 'http://127.0.0.1:8000';
                                    @endphp

                                    <td style="padding: 5px; border: 1px solid #cccccc; text-align: center;">
                                        @if ($item->lote?->foto1)
                                            <img src="{{ $route . '/storage/imagenes/lotes/thumbnail/' . $item->lote->foto1 }}"
                                                class="img-lote"
                                                style="width: auto; height: auto; border-radius: 4px; display: inline-block;max-height:60px"
                                                alt="Lote" />
                                        @else
                                            <span style="color: #999; font-size: 10px;">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <br>

            </td>
        </tr>
    </table>
</body>

</html>
