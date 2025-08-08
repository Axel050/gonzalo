<?php
// Ya no es necesario forzar CURLOPT_CAINFO si php.ini está bien configurado.
// De hecho, es mejor quitarlo para asegurarnos de que la configuración global funciona.

$ch = curl_init("https://api.mercadopago.com/");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Esta línea ya no es necesaria, la comentamos o la eliminamos
// curl_setopt($ch, CURLOPT_CAINFO, "C:/xampp/php/extras/ssl/cacert.pem");

$response = curl_exec($ch);

if (curl_errno($ch)) {
    // Proporcionamos un mensaje de error más detallado
    echo "❌ cURL error (" . curl_errno($ch) . "): " . curl_error($ch);
} else {
    echo "✅ Conexión SSL exitosa.";
    // Opcional: muestra un poco de la respuesta para estar seguros
    // echo "<pre>" . htmlspecialchars(substr($response, 0, 300)) . "</pre>";
}
curl_close($ch);
?>