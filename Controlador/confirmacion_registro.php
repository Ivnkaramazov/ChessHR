<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Incluir archivo de conexión a la base de datos
require_once '../Soporte/Conexion.php';

// Inicializar sesión
session_start();

// Obtener datos del formulario de la sesión
$email = $_SESSION['email'];
$nombre = $_SESSION['nombre'];

// Conectar a la base de datos
$conn = Conectarse();

// Verificar si la conexión a la base de datos es correcta
if ($conn) {
    // Consulta para obtener la información del usuario
    $sql = "SELECT * FROM usuarios WHERE usuEmail = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $curso = $row['curso'];
        $precio = obtenerPrecioCurso($curso);

        // Enviar correo electrónico de confirmación de registro
        $destinatario = $email;
        $asunto = "Confirmación de Registro";
        $mensaje = " <!DOCTYPE html> <html> <head> <title>Confirmación de Registro</title> </head> <body> <h1>Registro Exitoso!</h1> <p>Gracias por registrarte en nuestro sitio web, $nombre. Tu cuenta ha sido creada correctamente.</p> <p>Para completar tu registro, por favor haz clic en el siguiente link para realizar el pago:</p> <p><a href='http://chesshr.com.co/Controlador/paypal_payment.php?email=$email&nombre=$nombre&curso=$curso&precio=$precio'>Realizar Pago</a></p> </body> </html> ";

        // Agregar cabecera para enviar correo electrónico en HTML
        $cabecera = "MIME-Version: 1.0\r\n";
        $cabecera .= "From: Tu nombre <ivand.rapzoda@gmail.com>\r\n"; 
        $cabecera = "MIME-Version: 1.0\r\n";
        $cabecera .= "Content-type: text/html; \r\n";


        if (mail($destinatario, $asunto, $mensaje, $cabecera)) {
            echo "Correo electrónico de confirmación de registro enviado correctamente";
        } else {
            echo "Error al enviar correo electrónico de confirmación de registro";
        }
    } else {
        echo "Error al obtener la información del usuario";
    }

    // Cerrar la conexión a la base de datos
    $conn->close();
} else {
    echo "Error al conectar a la base de datos";
}

// Función para obtener el precio del curso
function obtenerPrecioCurso($curso) {
    $conn = Conectarse();
    $sql = "SELECT precio FROM cursos WHERE titulo = '$curso'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['precio'];
    } else {
        return 0;
    }
}
?>