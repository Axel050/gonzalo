<!DOCTYPE html>
<html>

<head>
    <title>QR Lote 11</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }

        svg {
            width: 100mm;
            height: 100mm;
        }

        p {
            font-size: 14px;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Código QR para Lote {{ $id }}</h1>
    <br>
    <img src="{{ $qr }}" alt="QR Code" style="width: 400px; height: 400px;">
    <br>
    <p>URL: {{ $url }}</p>
</body>

</html>
