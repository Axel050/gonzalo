<!DOCTYPE html>
<html>

<head>
    <title>Test Email</title>
</head>

<body>
    <h1>CASABLANCA.AR</h1>
    <p>{{ $data['message'] }} de contrato</p>
    <br>
    <p>Lotes:</p>
    <ul>
        @foreach ($data['lotes'] as $lote)
            <li>{{ $lote->titulo }}</li>
        @endforeach

    </ul>


</body>

</html>
