<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configuración de la API de PayPal
$client_id = 'AUEOF1icwWWkUTWlSN6bO_4N60DhgPM-T-gchBroz81-vZ4zKq2ZZbLqFrg8ZjtHDFUwoJ9Y_us7rqmo';
$secret = 'EOCCZkbDP4yXQSmMkBfBOwIghrml7vvpjhvCml8mwj6z7VbuzHxE3DYFEXMFBbfmJpQI6Qn-76BZnlGp';
$endpoint = 'https://api.paypal.com/v2';

// Configuración del pago
$curso = obtenerCursoDeLaBaseDeDatos(); // función que obtiene el curso de la base de datos
$precio = $curso->precio; // obtiene el precio del curso desde la base de datos

if ($precio <= 0) {
    echo "Error: El precio debe ser mayor que cero.";
    exit;
}

$amount = $precio; // asigna el precio del curso a la variable $amount
$currency = 'USD';
$description = 'Pago de curso';

// Obtener token de acceso
$credenciales = base64_encode($client_id . ':' . $secret);
$headers = array(
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Basic ' . $credenciales
);
$ch = curl_init('https://api.paypal.com/v1/oauth2/token');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
$error = curl_error($ch);
$info = curl_getinfo($ch);
curl_close($ch);

if ($error) {
    echo "Error: $error\n";
} else {
    $respuesta = json_decode($response, true);

    if (isset($respuesta['error'])) {
        echo "Error: " . $respuesta['error'] . "\n";
        echo "Descripción del error: " . $respuesta['error_description'] . "\n";
    } elseif ($respuesta === null) {
        echo "Error: No se pudo obtener el token de acceso\n";
    } else {
        $token = $respuesta['access_token'];

        // Enviar la solicitud de pago
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        );
        $pago = array(
            'intent' => 'AUTHORIZE',
            'payer' => array(
                'payment_method' => 'paypal'
            ),
            'purchase_units' => array(
                array(
                    'amount' => array(
                        'currency_code' => $currency,
                        'value' => $amount
                    ),
                    'description' => $description
                )
            ),
            'redirect_urls' => array(
                'return_url' => 'https://example.com/pago-completado',
                'cancel_url' => 'https://example.com/pago-cancelado'
            )
        );
        $ch = curl_init($endpoint . '/checkout/orders');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($pago));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $http_message = curl_error($ch);
        curl_close($ch);

        if ($http_message) {
            echo "Error: $http_message\n";
        } else {
            $respuesta = json_decode($response, true);

            if (isset($respuesta['error'])) {
                echo "Error: " . $respuesta['error'] . "\n";
                echo "Descripción del error: " . $respuesta['error_description'] . "\n";
            } else {
                $enlaceDePago = $respuesta['links'][1]['href'];
                header('Location: ' . $enlaceDePago);
                exit;
            }
        }
    }
}

function obtenerCursoDeLaBaseDeDatos() {
    // Aquí debes implementar la lógica para obtener el curso de la base de datos
    // Por ejemplo:
    $db = new mysqli('localhost', 'chesshrc_1996', 'FnI@nH6{gVi{', 'chesshrc_chesshr');
    $result = $db->query("SELECT * FROM cursos WHERE id_curso = 2");
    $curso = $result->fetch_object();
    return $curso;
}
?>

