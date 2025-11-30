<!DOCTYPE html>
<html>

<head>
    <title>Test Email</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="font-family: Arial, Helvetica, sans-serif; color: #333333; margin: 0; padding: 20px; ">
    <table align="center" width="600" cellpadding="0" cellspacing="0"
        style="background-color:#F6F2EE;padding-bottom:30px  ">
        <tr style="text-align:center;">

            <td style="padding: 20px;text-align:center;">
                <h1 style="font-size: 24px; color: #262626; margin: 0 0 20px 0; text-align: center;">CASABLANCA.AR</h1>
                <h3 style="font-size: 20px; color: #FF530D; margin: 20px 0 20px 0; text-align: center;">¡Tu puja fue
                    superada!</h3>



        </tr>

        <tr>
            <td>


                <table width="300px"
                    style="background-color: #EDE7E1;padding:15px;margin-top:10px;border:1px solid #000" align="center">
                    <tr style="font-size: 19px;text-align:left;font-weight:700">
                        <td>
                            {{ $data['titulo'] }}
                        </td>
                    </tr>
                    <tr style="text-align:center;">
                        <td>

                            {{-- storage/imagenes/lotes/thumbnail/ --}}

                            @php

                                if (app()->environment('production')) {
                                    $route = 'https://casablanca.ar';
                                } else {
                                    $route = 'http://127.0.0.1:8000';
                                }

                            @endphp



                            {{-- // <img  src={{{Storage::url('$data['lote']['foto1'] }}</td> --}}
                            <img src="{{ $route . '/storage/imagenes/lotes/thumbnail/' . $data['foto'] }}"
                                style="width: 250px;" />
                            {{-- <img src="{{ Storage::url('imagenes/lotes/thumbnail/' . $data['foto']) }}"
                                style="width: 250px;" /> --}}


                        </td>

                    </tr>
                    <tr>

                        <td style="padding-top:10px;text-align:left;padding-left:10px">
                            <span
                                style="padding:5px 10px;border:1px
                solid #000;border-radius:15px; font-size:14px;margin-right:15px">
                                Lote: {{ $data['lote_id'] }}
                            </span>
                            <span style="padding:5px 10px;border:1px solid #000;border-radius:15px; font-size:14px;">
                                Subasta: {{ $data['subasta'] }}
                            </span>
                        </td>

                    </tr>

                    <tr style="text-align:center;">
                        <td>
                            <p style="margin-top: 20px;font-size:20px;font-weight:800">Oferta actual:
                                ${{ $data['monto'] }}</p>
                        </td>
                    </tr>



                </table>

                <table style="text-align: center;margin-top:40px" align="center">
                    <tr>
                        <td>
                            <a href="https://www.casablanca.ar/pantalla-pujas"
                                style="border-radius:20px; padding:10px 15px ; text-decoration:none;background-color:#262626;color:white;font-size:18px;font-weight:700;line-height:1;">
                                <span style=";vertical-align:middle;">Ir a pujas</span>

                                <img src="{{ $route . '/arrow-r.png' }}"
                                    style="width:25px;margin-left:70px;display:inline;vertical-align:middle;" />

                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>

</html>
