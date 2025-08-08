<?php
$ch = curl_init("https://api.mercadopago.com/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo "cURL error: " . curl_error($ch);
} else {
    echo "Conexión exitosa.";
}
curl_close($ch);
?>
